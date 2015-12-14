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

$app->match('/contenido_agregado/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'cag_id', 
		'cag_con_id', 
		'con_titulo', 
		'con_texto', 
		'con_foto', 
		'con_foto_ubicacion', 
		'con_epigrafo', 
		'con_html', 
		'con_download', 
		'con_video', 
		'con_adjunto', 

    );
    
    $table_columns_type = array(
		'bigint(11)', 
		'int(11)', 
		'varchar(255)', 
		'text', 
		'varchar(255)', 
		'char(1)', 
		'varchar(255)', 
		'text', 
		'text', 
		'text', 
		'varchar(255)', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `contenido_agregado`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `contenido_agregado`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/contenido_agregado/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . contenido_agregado . " WHERE ".$idfldname." = ?";
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



$app->match('/contenido_agregado', function () use ($app) {
    
	$table_columns = array(
		'cag_id', 
		'cag_con_id', 
		'con_titulo', 
		'con_texto', 
		'con_foto', 
		'con_foto_ubicacion', 
		'con_epigrafo', 
		'con_html', 
		'con_download', 
		'con_video', 
		'con_adjunto', 

    );

    $primary_key = "cag_id";	

    return $app['twig']->render('contenido_agregado/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('contenido_agregado_list');



$app->match('/contenido_agregado/create', function () use ($app) {
    
    $initial_data = array(
		'cag_con_id' => '', 
		'con_titulo' => '', 
		'con_texto' => '', 
		'con_foto' => '', 
		'con_foto_ubicacion' => '', 
		'con_epigrafo' => '', 
		'con_html' => '', 
		'con_download' => '', 
		'con_video' => '', 
		'con_adjunto' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('cag_con_id', 'text', array('required' => true));
	$form = $form->add('con_titulo', 'text', array('required' => false));
	$form = $form->add('con_texto', 'textarea', array('required' => false));
	$form = $form->add('con_foto', 'text', array('required' => false));
	$form = $form->add('con_foto_ubicacion', 'text', array('required' => true));
	$form = $form->add('con_epigrafo', 'text', array('required' => false));
	$form = $form->add('con_html', 'textarea', array('required' => false));
	$form = $form->add('con_download', 'textarea', array('required' => false));
	$form = $form->add('con_video', 'textarea', array('required' => false));
	$form = $form->add('con_adjunto', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `contenido_agregado` (`cag_con_id`, `con_titulo`, `con_texto`, `con_foto`, `con_foto_ubicacion`, `con_epigrafo`, `con_html`, `con_download`, `con_video`, `con_adjunto`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['cag_con_id'], $data['con_titulo'], $data['con_texto'], $data['con_foto'], $data['con_foto_ubicacion'], $data['con_epigrafo'], $data['con_html'], $data['con_download'], $data['con_video'], $data['con_adjunto']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'contenido_agregado created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('contenido_agregado_list'));

        }
    }

    return $app['twig']->render('contenido_agregado/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('contenido_agregado_create');



$app->match('/contenido_agregado/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `contenido_agregado` WHERE `cag_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('contenido_agregado_list'));
    }

    
    $initial_data = array(
		'cag_con_id' => $row_sql['cag_con_id'], 
		'con_titulo' => $row_sql['con_titulo'], 
		'con_texto' => $row_sql['con_texto'], 
		'con_foto' => $row_sql['con_foto'], 
		'con_foto_ubicacion' => $row_sql['con_foto_ubicacion'], 
		'con_epigrafo' => $row_sql['con_epigrafo'], 
		'con_html' => $row_sql['con_html'], 
		'con_download' => $row_sql['con_download'], 
		'con_video' => $row_sql['con_video'], 
		'con_adjunto' => $row_sql['con_adjunto'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('cag_con_id', 'text', array('required' => true));
	$form = $form->add('con_titulo', 'text', array('required' => false));
	$form = $form->add('con_texto', 'textarea', array('required' => false));
	$form = $form->add('con_foto', 'text', array('required' => false));
	$form = $form->add('con_foto_ubicacion', 'text', array('required' => true));
	$form = $form->add('con_epigrafo', 'text', array('required' => false));
	$form = $form->add('con_html', 'textarea', array('required' => false));
	$form = $form->add('con_download', 'textarea', array('required' => false));
	$form = $form->add('con_video', 'textarea', array('required' => false));
	$form = $form->add('con_adjunto', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `contenido_agregado` SET `cag_con_id` = ?, `con_titulo` = ?, `con_texto` = ?, `con_foto` = ?, `con_foto_ubicacion` = ?, `con_epigrafo` = ?, `con_html` = ?, `con_download` = ?, `con_video` = ?, `con_adjunto` = ? WHERE `cag_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['cag_con_id'], $data['con_titulo'], $data['con_texto'], $data['con_foto'], $data['con_foto_ubicacion'], $data['con_epigrafo'], $data['con_html'], $data['con_download'], $data['con_video'], $data['con_adjunto'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'contenido_agregado edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('contenido_agregado_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('contenido_agregado/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('contenido_agregado_edit');



$app->match('/contenido_agregado/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `contenido_agregado` WHERE `cag_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `contenido_agregado` WHERE `cag_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'contenido_agregado deleted!',
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

    return $app->redirect($app['url_generator']->generate('contenido_agregado_list'));

})
->bind('contenido_agregado_delete');






