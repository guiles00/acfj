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

$app->match('/video1/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'vi1_id', 
		'vi1_nombre', 
		'vi1_fecha', 
		'vi1_mostrarEnWeb', 
		'vi1_gcu3_id', 
		'vi1_tem_id', 
		'vi1_foto1', 
		'vi1_copete', 
		'vi1_descripcion', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'date', 
		'char(2)', 
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'text', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `video1`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `video1`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/video1/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . video1 . " WHERE ".$idfldname." = ?";
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



$app->match('/video1', function () use ($app) {
    
	$table_columns = array(
		'vi1_id', 
		'vi1_nombre', 
		'vi1_fecha', 
		'vi1_mostrarEnWeb', 
		'vi1_gcu3_id', 
		'vi1_tem_id', 
		'vi1_foto1', 
		'vi1_copete', 
		'vi1_descripcion', 

    );

    $primary_key = "vi1_id";	

    return $app['twig']->render('video1/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('video1_list');



$app->match('/video1/create', function () use ($app) {
    
    $initial_data = array(
		'vi1_nombre' => '', 
		'vi1_fecha' => '', 
		'vi1_mostrarEnWeb' => '', 
		'vi1_gcu3_id' => '', 
		'vi1_tem_id' => '', 
		'vi1_foto1' => '', 
		'vi1_copete' => '', 
		'vi1_descripcion' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('vi1_nombre', 'text', array('required' => true));
	$form = $form->add('vi1_fecha', 'text', array('required' => true));
	$form = $form->add('vi1_mostrarEnWeb', 'text', array('required' => true));
	$form = $form->add('vi1_gcu3_id', 'text', array('required' => true));
	$form = $form->add('vi1_tem_id', 'text', array('required' => true));
	$form = $form->add('vi1_foto1', 'text', array('required' => true));
	$form = $form->add('vi1_copete', 'textarea', array('required' => true));
	$form = $form->add('vi1_descripcion', 'textarea', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `video1` (`vi1_nombre`, `vi1_fecha`, `vi1_mostrarEnWeb`, `vi1_gcu3_id`, `vi1_tem_id`, `vi1_foto1`, `vi1_copete`, `vi1_descripcion`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['vi1_nombre'], $data['vi1_fecha'], $data['vi1_mostrarEnWeb'], $data['vi1_gcu3_id'], $data['vi1_tem_id'], $data['vi1_foto1'], $data['vi1_copete'], $data['vi1_descripcion']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'video1 created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('video1_list'));

        }
    }

    return $app['twig']->render('video1/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('video1_create');



$app->match('/video1/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `video1` WHERE `vi1_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('video1_list'));
    }

    
    $initial_data = array(
		'vi1_nombre' => $row_sql['vi1_nombre'], 
		'vi1_fecha' => $row_sql['vi1_fecha'], 
		'vi1_mostrarEnWeb' => $row_sql['vi1_mostrarEnWeb'], 
		'vi1_gcu3_id' => $row_sql['vi1_gcu3_id'], 
		'vi1_tem_id' => $row_sql['vi1_tem_id'], 
		'vi1_foto1' => $row_sql['vi1_foto1'], 
		'vi1_copete' => $row_sql['vi1_copete'], 
		'vi1_descripcion' => $row_sql['vi1_descripcion'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('vi1_nombre', 'text', array('required' => true));
	$form = $form->add('vi1_fecha', 'text', array('required' => true));
	$form = $form->add('vi1_mostrarEnWeb', 'text', array('required' => true));
	$form = $form->add('vi1_gcu3_id', 'text', array('required' => true));
	$form = $form->add('vi1_tem_id', 'text', array('required' => true));
	$form = $form->add('vi1_foto1', 'text', array('required' => true));
	$form = $form->add('vi1_copete', 'textarea', array('required' => true));
	$form = $form->add('vi1_descripcion', 'textarea', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `video1` SET `vi1_nombre` = ?, `vi1_fecha` = ?, `vi1_mostrarEnWeb` = ?, `vi1_gcu3_id` = ?, `vi1_tem_id` = ?, `vi1_foto1` = ?, `vi1_copete` = ?, `vi1_descripcion` = ? WHERE `vi1_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['vi1_nombre'], $data['vi1_fecha'], $data['vi1_mostrarEnWeb'], $data['vi1_gcu3_id'], $data['vi1_tem_id'], $data['vi1_foto1'], $data['vi1_copete'], $data['vi1_descripcion'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'video1 edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('video1_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('video1/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('video1_edit');



$app->match('/video1/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `video1` WHERE `vi1_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `video1` WHERE `vi1_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'video1 deleted!',
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

    return $app->redirect($app['url_generator']->generate('video1_list'));

})
->bind('video1_delete');






