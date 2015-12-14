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

$app->match('/usuario/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'usu_id', 
		'usu_login', 
		'usu_clave', 
		'usu_per_id', 
		'usu_email', 
		'usu_nombre', 

    );
    
    $table_columns_type = array(
		'int(10) unsigned', 
		'varchar(255)', 
		'varchar(255)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `usuario`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `usuario`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/usuario/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . usuario . " WHERE ".$idfldname." = ?";
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



$app->match('/usuario', function () use ($app) {
    
	$table_columns = array(
		'usu_id', 
		'usu_login', 
		'usu_clave', 
		'usu_per_id', 
		'usu_email', 
		'usu_nombre', 

    );

    $primary_key = "usu_id";	

    return $app['twig']->render('usuario/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('usuario_list');



$app->match('/usuario/create', function () use ($app) {
    
    $initial_data = array(
		'usu_login' => '', 
		'usu_clave' => '', 
		'usu_per_id' => '', 
		'usu_email' => '', 
		'usu_nombre' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('usu_login', 'text', array('required' => true));
	$form = $form->add('usu_clave', 'text', array('required' => true));
	$form = $form->add('usu_per_id', 'text', array('required' => true));
	$form = $form->add('usu_email', 'text', array('required' => false));
	$form = $form->add('usu_nombre', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `usuario` (`usu_login`, `usu_clave`, `usu_per_id`, `usu_email`, `usu_nombre`) VALUES (?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['usu_login'], $data['usu_clave'], $data['usu_per_id'], $data['usu_email'], $data['usu_nombre']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'usuario created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('usuario_list'));

        }
    }

    return $app['twig']->render('usuario/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('usuario_create');



$app->match('/usuario/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `usuario` WHERE `usu_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('usuario_list'));
    }

    
    $initial_data = array(
		'usu_login' => $row_sql['usu_login'], 
		'usu_clave' => $row_sql['usu_clave'], 
		'usu_per_id' => $row_sql['usu_per_id'], 
		'usu_email' => $row_sql['usu_email'], 
		'usu_nombre' => $row_sql['usu_nombre'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('usu_login', 'text', array('required' => true));
	$form = $form->add('usu_clave', 'text', array('required' => true));
	$form = $form->add('usu_per_id', 'text', array('required' => true));
	$form = $form->add('usu_email', 'text', array('required' => false));
	$form = $form->add('usu_nombre', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `usuario` SET `usu_login` = ?, `usu_clave` = ?, `usu_per_id` = ?, `usu_email` = ?, `usu_nombre` = ? WHERE `usu_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['usu_login'], $data['usu_clave'], $data['usu_per_id'], $data['usu_email'], $data['usu_nombre'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'usuario edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('usuario_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('usuario/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('usuario_edit');



$app->match('/usuario/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `usuario` WHERE `usu_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `usuario` WHERE `usu_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'usuario deleted!',
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

    return $app->redirect($app['url_generator']->generate('usuario_list'));

})
->bind('usuario_delete');






