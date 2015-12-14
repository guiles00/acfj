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

$app->match('/grupo_novedad/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'gno_id', 
		'gno_nombre', 
		'gno_color_fondo', 
		'gno_mostrar', 
		'gno_texto', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'varchar(6)', 
		'char(2)', 
		'text', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `grupo_novedad`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `grupo_novedad`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/grupo_novedad/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . grupo_novedad . " WHERE ".$idfldname." = ?";
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



$app->match('/grupo_novedad', function () use ($app) {
    
	$table_columns = array(
		'gno_id', 
		'gno_nombre', 
		'gno_color_fondo', 
		'gno_mostrar', 
		'gno_texto', 

    );

    $primary_key = "gno_id";	

    return $app['twig']->render('grupo_novedad/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('grupo_novedad_list');



$app->match('/grupo_novedad/create', function () use ($app) {
    
    $initial_data = array(
		'gno_nombre' => '', 
		'gno_color_fondo' => '', 
		'gno_mostrar' => '', 
		'gno_texto' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('gno_nombre', 'text', array('required' => true));
	$form = $form->add('gno_color_fondo', 'text', array('required' => false));
	$form = $form->add('gno_mostrar', 'text', array('required' => true));
	$form = $form->add('gno_texto', 'textarea', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `grupo_novedad` (`gno_nombre`, `gno_color_fondo`, `gno_mostrar`, `gno_texto`) VALUES (?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['gno_nombre'], $data['gno_color_fondo'], $data['gno_mostrar'], $data['gno_texto']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'grupo_novedad created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('grupo_novedad_list'));

        }
    }

    return $app['twig']->render('grupo_novedad/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('grupo_novedad_create');



$app->match('/grupo_novedad/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `grupo_novedad` WHERE `gno_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('grupo_novedad_list'));
    }

    
    $initial_data = array(
		'gno_nombre' => $row_sql['gno_nombre'], 
		'gno_color_fondo' => $row_sql['gno_color_fondo'], 
		'gno_mostrar' => $row_sql['gno_mostrar'], 
		'gno_texto' => $row_sql['gno_texto'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('gno_nombre', 'text', array('required' => true));
	$form = $form->add('gno_color_fondo', 'text', array('required' => false));
	$form = $form->add('gno_mostrar', 'text', array('required' => true));
	$form = $form->add('gno_texto', 'textarea', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `grupo_novedad` SET `gno_nombre` = ?, `gno_color_fondo` = ?, `gno_mostrar` = ?, `gno_texto` = ? WHERE `gno_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['gno_nombre'], $data['gno_color_fondo'], $data['gno_mostrar'], $data['gno_texto'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'grupo_novedad edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('grupo_novedad_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('grupo_novedad/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('grupo_novedad_edit');



$app->match('/grupo_novedad/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `grupo_novedad` WHERE `gno_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `grupo_novedad` WHERE `gno_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'grupo_novedad deleted!',
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

    return $app->redirect($app['url_generator']->generate('grupo_novedad_list'));

})
->bind('grupo_novedad_delete');






