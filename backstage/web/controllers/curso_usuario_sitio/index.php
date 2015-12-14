<?php

/*
 * This file is part of the CRUD Admin Generator project.
 *
 * Author: Jon Segador <jonseg@gmail.com>
 * Web: http://crud-admin-generator.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once __DIR__.'/../../../vendor/autoload.php';
require_once __DIR__.'/../../../src/app.php';

use Symfony\Component\Validator\Constraints as Assert;

$app->match('/curso_usuario_sitio/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
    $start = 0;
    $vars = $request->query->all();
    $qsStart = (int)$vars["start"];
    $search = $vars["search"];
    $order = $vars["order"];
    $columns = $vars["columns"];
    $qsLength = (int)$vars["length"];    
    
    if($qsStart) {
        $start = $qsStart;
    }    
	
    $index = $start;   
    $rowsPerPage = $qsLength;
       
    $rows = array();
    
    $searchValue = $search['value'];
    $orderValue = $order[0];
    
    $orderClause = "";
    if($orderValue) {
        $orderClause = " ORDER BY ". $columns[(int)$orderValue['column']]['data'] . " " . $orderValue['dir'];
    }
    
    $table_columns = array(
		'cus_id', 
		'cus_cur_id', 
		'cus_usi_id', 
		'cus_fecha', 
		'cus_validado', 
		'cur_asistio', 
		'cur_aprobo', 
		'cur_nota', 
		'cur_tco_id', 
		'cur_tce_id', 
		'cus_habilitado', 
		'cus_fecha_baja', 
		'cur_tieneEvaluacion', 
		'cur_evaluacionObligatoria', 
		'cur_rindio', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'datetime', 
		'char(2)', 
		'char(2)', 
		'char(2)', 
		'varchar(50)', 
		'int(11)', 
		'int(11)', 
		'tinyint(4)', 
		'datetime', 
		'char(2)', 
		'char(2)', 
		'char(2)', 

    );    
    
    $whereClause = "";
    
    $i = 0;
    foreach($table_columns as $col){
        
        if ($i == 0) {
           $whereClause = " WHERE";
        }
        
        if ($i > 0) {
            $whereClause =  $whereClause . " OR"; 
        }
        
        $whereClause =  $whereClause . " " . $col . " LIKE '%". $searchValue ."%'";
        
        $i = $i + 1;
    }
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `curso_usuario_sitio`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `curso_usuario_sitio`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
        for($i = 0; $i < count($table_columns); $i++){

		if( $table_columns_type[$i] != "blob") {
				$rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
		} else {				if( !$row_sql[$table_columns[$i]] ) {
						$rows[$row_key][$table_columns[$i]] = "0 Kb.";
				} else {
						$rows[$row_key][$table_columns[$i]] = " <a target='__blank' href='menu/download?id=" . $row_sql[$table_columns[0]];
						$rows[$row_key][$table_columns[$i]] .= "&fldname=" . $table_columns[$i];
						$rows[$row_key][$table_columns[$i]] .= "&idfld=" . $table_columns[0];
						$rows[$row_key][$table_columns[$i]] .= "'>";
						$rows[$row_key][$table_columns[$i]] .= number_format(strlen($row_sql[$table_columns[$i]]) / 1024, 2) . " Kb.";
						$rows[$row_key][$table_columns[$i]] .= "</a>";
				}
		}

        }
    }    
    
    $queryData = new queryData();
    $queryData->start = $start;
    $queryData->recordsTotal = $recordsTotal;
    $queryData->recordsFiltered = $recordsTotal;
    $queryData->data = $rows;
    
    return new Symfony\Component\HttpFoundation\Response(json_encode($queryData), 200);
});




/* Download blob img */
$app->match('/curso_usuario_sitio/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . curso_usuario_sitio . " WHERE ".$idfldname." = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($rowid));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('menu_list'));
    }

    header('Content-Description: File Transfer');
    header('Content-Type: image/jpeg');
    header("Content-length: ".strlen( $row_sql[$fieldname] ));
    header('Expires: 0');
    header('Cache-Control: public');
    header('Pragma: public');
    ob_clean();    
    echo $row_sql[$fieldname];
    exit();
   
    
});



$app->match('/curso_usuario_sitio', function () use ($app) {
    
	$table_columns = array(
		'cus_id', 
		'cus_cur_id', 
		'cus_usi_id', 
		'cus_fecha', 
		'cus_validado', 
		'cur_asistio', 
		'cur_aprobo', 
		'cur_nota', 
		'cur_tco_id', 
		'cur_tce_id', 
		'cus_habilitado', 
		'cus_fecha_baja', 
		'cur_tieneEvaluacion', 
		'cur_evaluacionObligatoria', 
		'cur_rindio', 

    );

    $primary_key = "cus_id";	

    return $app['twig']->render('curso_usuario_sitio/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('curso_usuario_sitio_list');



$app->match('/curso_usuario_sitio/create', function () use ($app) {
    
    $initial_data = array(
		'cus_cur_id' => '', 
		'cus_usi_id' => '', 
		'cus_fecha' => '', 
		'cus_validado' => '', 
		'cur_asistio' => '', 
		'cur_aprobo' => '', 
		'cur_nota' => '', 
		'cur_tco_id' => '', 
		'cur_tce_id' => '', 
		'cus_habilitado' => '', 
		'cus_fecha_baja' => '', 
		'cur_tieneEvaluacion' => '', 
		'cur_evaluacionObligatoria' => '', 
		'cur_rindio' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('cus_cur_id', 'text', array('required' => true));
	$form = $form->add('cus_usi_id', 'text', array('required' => true));
	$form = $form->add('cus_fecha', 'text', array('required' => true));
	$form = $form->add('cus_validado', 'text', array('required' => true));
	$form = $form->add('cur_asistio', 'text', array('required' => true));
	$form = $form->add('cur_aprobo', 'text', array('required' => true));
	$form = $form->add('cur_nota', 'text', array('required' => false));
	$form = $form->add('cur_tco_id', 'text', array('required' => false));
	$form = $form->add('cur_tce_id', 'text', array('required' => false));
	$form = $form->add('cus_habilitado', 'text', array('required' => true));
	$form = $form->add('cus_fecha_baja', 'text', array('required' => false));
	$form = $form->add('cur_tieneEvaluacion', 'text', array('required' => true));
	$form = $form->add('cur_evaluacionObligatoria', 'text', array('required' => true));
	$form = $form->add('cur_rindio', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `curso_usuario_sitio` (`cus_cur_id`, `cus_usi_id`, `cus_fecha`, `cus_validado`, `cur_asistio`, `cur_aprobo`, `cur_nota`, `cur_tco_id`, `cur_tce_id`, `cus_habilitado`, `cus_fecha_baja`, `cur_tieneEvaluacion`, `cur_evaluacionObligatoria`, `cur_rindio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['cus_cur_id'], $data['cus_usi_id'], $data['cus_fecha'], $data['cus_validado'], $data['cur_asistio'], $data['cur_aprobo'], $data['cur_nota'], $data['cur_tco_id'], $data['cur_tce_id'], $data['cus_habilitado'], $data['cus_fecha_baja'], $data['cur_tieneEvaluacion'], $data['cur_evaluacionObligatoria'], $data['cur_rindio']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'curso_usuario_sitio created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('curso_usuario_sitio_list'));

        }
    }

    return $app['twig']->render('curso_usuario_sitio/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('curso_usuario_sitio_create');



$app->match('/curso_usuario_sitio/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `curso_usuario_sitio` WHERE `cus_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('curso_usuario_sitio_list'));
    }

    
    $initial_data = array(
		'cus_cur_id' => $row_sql['cus_cur_id'], 
		'cus_usi_id' => $row_sql['cus_usi_id'], 
		'cus_fecha' => $row_sql['cus_fecha'], 
		'cus_validado' => $row_sql['cus_validado'], 
		'cur_asistio' => $row_sql['cur_asistio'], 
		'cur_aprobo' => $row_sql['cur_aprobo'], 
		'cur_nota' => $row_sql['cur_nota'], 
		'cur_tco_id' => $row_sql['cur_tco_id'], 
		'cur_tce_id' => $row_sql['cur_tce_id'], 
		'cus_habilitado' => $row_sql['cus_habilitado'], 
		'cus_fecha_baja' => $row_sql['cus_fecha_baja'], 
		'cur_tieneEvaluacion' => $row_sql['cur_tieneEvaluacion'], 
		'cur_evaluacionObligatoria' => $row_sql['cur_evaluacionObligatoria'], 
		'cur_rindio' => $row_sql['cur_rindio'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('cus_cur_id', 'text', array('required' => true));
	$form = $form->add('cus_usi_id', 'text', array('required' => true));
	$form = $form->add('cus_fecha', 'text', array('required' => true));
	$form = $form->add('cus_validado', 'text', array('required' => true));
	$form = $form->add('cur_asistio', 'text', array('required' => true));
	$form = $form->add('cur_aprobo', 'text', array('required' => true));
	$form = $form->add('cur_nota', 'text', array('required' => false));
	$form = $form->add('cur_tco_id', 'text', array('required' => false));
	$form = $form->add('cur_tce_id', 'text', array('required' => false));
	$form = $form->add('cus_habilitado', 'text', array('required' => true));
	$form = $form->add('cus_fecha_baja', 'text', array('required' => false));
	$form = $form->add('cur_tieneEvaluacion', 'text', array('required' => true));
	$form = $form->add('cur_evaluacionObligatoria', 'text', array('required' => true));
	$form = $form->add('cur_rindio', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `curso_usuario_sitio` SET `cus_cur_id` = ?, `cus_usi_id` = ?, `cus_fecha` = ?, `cus_validado` = ?, `cur_asistio` = ?, `cur_aprobo` = ?, `cur_nota` = ?, `cur_tco_id` = ?, `cur_tce_id` = ?, `cus_habilitado` = ?, `cus_fecha_baja` = ?, `cur_tieneEvaluacion` = ?, `cur_evaluacionObligatoria` = ?, `cur_rindio` = ? WHERE `cus_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['cus_cur_id'], $data['cus_usi_id'], $data['cus_fecha'], $data['cus_validado'], $data['cur_asistio'], $data['cur_aprobo'], $data['cur_nota'], $data['cur_tco_id'], $data['cur_tce_id'], $data['cus_habilitado'], $data['cus_fecha_baja'], $data['cur_tieneEvaluacion'], $data['cur_evaluacionObligatoria'], $data['cur_rindio'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'curso_usuario_sitio edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('curso_usuario_sitio_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('curso_usuario_sitio/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('curso_usuario_sitio_edit');



$app->match('/curso_usuario_sitio/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `curso_usuario_sitio` WHERE `cus_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `curso_usuario_sitio` WHERE `cus_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'curso_usuario_sitio deleted!',
            )
        );
    }
    else{
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );  
    }

    return $app->redirect($app['url_generator']->generate('curso_usuario_sitio_list'));

})
->bind('curso_usuario_sitio_delete');






