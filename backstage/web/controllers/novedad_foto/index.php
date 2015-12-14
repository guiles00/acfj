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

$app->match('/novedad_foto/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'nfo_id', 
		'nfo_nov_id', 
		'nfo_orden', 
		'nfo_titulo', 
		'nfo_foto', 
		'nfo_descripcion', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'tinyint(4)', 
		'varchar(255)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `novedad_foto`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `novedad_foto`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/novedad_foto/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . novedad_foto . " WHERE ".$idfldname." = ?";
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



$app->match('/novedad_foto', function () use ($app) {
    
	$table_columns = array(
		'nfo_id', 
		'nfo_nov_id', 
		'nfo_orden', 
		'nfo_titulo', 
		'nfo_foto', 
		'nfo_descripcion', 

    );

    $primary_key = "nfo_id";	

    return $app['twig']->render('novedad_foto/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('novedad_foto_list');



$app->match('/novedad_foto/create', function () use ($app) {
    
    $initial_data = array(
		'nfo_nov_id' => '', 
		'nfo_orden' => '', 
		'nfo_titulo' => '', 
		'nfo_foto' => '', 
		'nfo_descripcion' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('nfo_nov_id', 'text', array('required' => true));
	$form = $form->add('nfo_orden', 'text', array('required' => true));
	$form = $form->add('nfo_titulo', 'text', array('required' => true));
	$form = $form->add('nfo_foto', 'text', array('required' => false));
	$form = $form->add('nfo_descripcion', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `novedad_foto` (`nfo_nov_id`, `nfo_orden`, `nfo_titulo`, `nfo_foto`, `nfo_descripcion`) VALUES (?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['nfo_nov_id'], $data['nfo_orden'], $data['nfo_titulo'], $data['nfo_foto'], $data['nfo_descripcion']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'novedad_foto created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('novedad_foto_list'));

        }
    }

    return $app['twig']->render('novedad_foto/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('novedad_foto_create');



$app->match('/novedad_foto/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `novedad_foto` WHERE `nfo_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('novedad_foto_list'));
    }

    
    $initial_data = array(
		'nfo_nov_id' => $row_sql['nfo_nov_id'], 
		'nfo_orden' => $row_sql['nfo_orden'], 
		'nfo_titulo' => $row_sql['nfo_titulo'], 
		'nfo_foto' => $row_sql['nfo_foto'], 
		'nfo_descripcion' => $row_sql['nfo_descripcion'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('nfo_nov_id', 'text', array('required' => true));
	$form = $form->add('nfo_orden', 'text', array('required' => true));
	$form = $form->add('nfo_titulo', 'text', array('required' => true));
	$form = $form->add('nfo_foto', 'text', array('required' => false));
	$form = $form->add('nfo_descripcion', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `novedad_foto` SET `nfo_nov_id` = ?, `nfo_orden` = ?, `nfo_titulo` = ?, `nfo_foto` = ?, `nfo_descripcion` = ? WHERE `nfo_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['nfo_nov_id'], $data['nfo_orden'], $data['nfo_titulo'], $data['nfo_foto'], $data['nfo_descripcion'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'novedad_foto edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('novedad_foto_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('novedad_foto/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('novedad_foto_edit');



$app->match('/novedad_foto/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `novedad_foto` WHERE `nfo_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `novedad_foto` WHERE `nfo_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'novedad_foto deleted!',
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

    return $app->redirect($app['url_generator']->generate('novedad_foto_list'));

})
->bind('novedad_foto_delete');






