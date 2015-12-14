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

$app->match('/galeria/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'gal_id', 
		'gal_orden', 
		'gal_nombre', 
		'gal_foto1', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `galeria`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `galeria`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/galeria/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . galeria . " WHERE ".$idfldname." = ?";
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



$app->match('/galeria', function () use ($app) {
    
	$table_columns = array(
		'gal_id', 
		'gal_orden', 
		'gal_nombre', 
		'gal_foto1', 

    );

    $primary_key = "gal_id";	

    return $app['twig']->render('galeria/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('galeria_list');



$app->match('/galeria/create', function () use ($app) {
    
    $initial_data = array(
		'gal_orden' => '', 
		'gal_nombre' => '', 
		'gal_foto1' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('gal_orden', 'text', array('required' => true));
	$form = $form->add('gal_nombre', 'text', array('required' => true));
	$form = $form->add('gal_foto1', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `galeria` (`gal_orden`, `gal_nombre`, `gal_foto1`) VALUES (?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['gal_orden'], $data['gal_nombre'], $data['gal_foto1']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'galeria created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('galeria_list'));

        }
    }

    return $app['twig']->render('galeria/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('galeria_create');



$app->match('/galeria/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `galeria` WHERE `gal_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('galeria_list'));
    }

    
    $initial_data = array(
		'gal_orden' => $row_sql['gal_orden'], 
		'gal_nombre' => $row_sql['gal_nombre'], 
		'gal_foto1' => $row_sql['gal_foto1'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('gal_orden', 'text', array('required' => true));
	$form = $form->add('gal_nombre', 'text', array('required' => true));
	$form = $form->add('gal_foto1', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `galeria` SET `gal_orden` = ?, `gal_nombre` = ?, `gal_foto1` = ? WHERE `gal_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['gal_orden'], $data['gal_nombre'], $data['gal_foto1'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'galeria edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('galeria_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('galeria/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('galeria_edit');



$app->match('/galeria/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `galeria` WHERE `gal_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `galeria` WHERE `gal_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'galeria deleted!',
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

    return $app->redirect($app['url_generator']->generate('galeria_list'));

})
->bind('galeria_delete');






