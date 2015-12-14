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

$app->match('/video2/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'vi2_id', 
		'vi2_nombre', 
		'vi2_vi1_id', 
		'vi2_ses1_nombre', 
		'vi2_ses1_descripcion', 
		'vi2_ses1_video', 
		'vi2_ses2_nombre', 
		'vi2_ses2_descripcion', 
		'vi2_ses2_video', 
		'vi2_ses3_nombre', 
		'vi2_ses3_descripcion', 
		'vi2_ses3_video', 
		'vi2_ses4_nombre', 
		'vi2_ses4_descripcion', 
		'vi2_ses4_video', 
		'vi2_ses5_nombre', 
		'vi2_ses5_descripcion', 
		'vi2_ses5_video', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'int(11)', 
		'varchar(255)', 
		'text', 
		'text', 
		'varchar(255)', 
		'text', 
		'text', 
		'varchar(255)', 
		'text', 
		'text', 
		'varchar(255)', 
		'text', 
		'text', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `video2`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `video2`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/video2/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . video2 . " WHERE ".$idfldname." = ?";
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



$app->match('/video2', function () use ($app) {
    
	$table_columns = array(
		'vi2_id', 
		'vi2_nombre', 
		'vi2_vi1_id', 
		'vi2_ses1_nombre', 
		'vi2_ses1_descripcion', 
		'vi2_ses1_video', 
		'vi2_ses2_nombre', 
		'vi2_ses2_descripcion', 
		'vi2_ses2_video', 
		'vi2_ses3_nombre', 
		'vi2_ses3_descripcion', 
		'vi2_ses3_video', 
		'vi2_ses4_nombre', 
		'vi2_ses4_descripcion', 
		'vi2_ses4_video', 
		'vi2_ses5_nombre', 
		'vi2_ses5_descripcion', 
		'vi2_ses5_video', 

    );

    $primary_key = "vi2_id";	

    return $app['twig']->render('video2/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('video2_list');



$app->match('/video2/create', function () use ($app) {
    
    $initial_data = array(
		'vi2_nombre' => '', 
		'vi2_vi1_id' => '', 
		'vi2_ses1_nombre' => '', 
		'vi2_ses1_descripcion' => '', 
		'vi2_ses1_video' => '', 
		'vi2_ses2_nombre' => '', 
		'vi2_ses2_descripcion' => '', 
		'vi2_ses2_video' => '', 
		'vi2_ses3_nombre' => '', 
		'vi2_ses3_descripcion' => '', 
		'vi2_ses3_video' => '', 
		'vi2_ses4_nombre' => '', 
		'vi2_ses4_descripcion' => '', 
		'vi2_ses4_video' => '', 
		'vi2_ses5_nombre' => '', 
		'vi2_ses5_descripcion' => '', 
		'vi2_ses5_video' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('vi2_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_vi1_id', 'text', array('required' => true));
	$form = $form->add('vi2_ses1_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses1_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses1_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses2_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses2_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses2_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses3_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses3_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses3_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses4_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses4_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses4_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses5_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses5_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses5_video', 'textarea', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `video2` (`vi2_nombre`, `vi2_vi1_id`, `vi2_ses1_nombre`, `vi2_ses1_descripcion`, `vi2_ses1_video`, `vi2_ses2_nombre`, `vi2_ses2_descripcion`, `vi2_ses2_video`, `vi2_ses3_nombre`, `vi2_ses3_descripcion`, `vi2_ses3_video`, `vi2_ses4_nombre`, `vi2_ses4_descripcion`, `vi2_ses4_video`, `vi2_ses5_nombre`, `vi2_ses5_descripcion`, `vi2_ses5_video`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['vi2_nombre'], $data['vi2_vi1_id'], $data['vi2_ses1_nombre'], $data['vi2_ses1_descripcion'], $data['vi2_ses1_video'], $data['vi2_ses2_nombre'], $data['vi2_ses2_descripcion'], $data['vi2_ses2_video'], $data['vi2_ses3_nombre'], $data['vi2_ses3_descripcion'], $data['vi2_ses3_video'], $data['vi2_ses4_nombre'], $data['vi2_ses4_descripcion'], $data['vi2_ses4_video'], $data['vi2_ses5_nombre'], $data['vi2_ses5_descripcion'], $data['vi2_ses5_video']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'video2 created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('video2_list'));

        }
    }

    return $app['twig']->render('video2/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('video2_create');



$app->match('/video2/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `video2` WHERE `vi2_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('video2_list'));
    }

    
    $initial_data = array(
		'vi2_nombre' => $row_sql['vi2_nombre'], 
		'vi2_vi1_id' => $row_sql['vi2_vi1_id'], 
		'vi2_ses1_nombre' => $row_sql['vi2_ses1_nombre'], 
		'vi2_ses1_descripcion' => $row_sql['vi2_ses1_descripcion'], 
		'vi2_ses1_video' => $row_sql['vi2_ses1_video'], 
		'vi2_ses2_nombre' => $row_sql['vi2_ses2_nombre'], 
		'vi2_ses2_descripcion' => $row_sql['vi2_ses2_descripcion'], 
		'vi2_ses2_video' => $row_sql['vi2_ses2_video'], 
		'vi2_ses3_nombre' => $row_sql['vi2_ses3_nombre'], 
		'vi2_ses3_descripcion' => $row_sql['vi2_ses3_descripcion'], 
		'vi2_ses3_video' => $row_sql['vi2_ses3_video'], 
		'vi2_ses4_nombre' => $row_sql['vi2_ses4_nombre'], 
		'vi2_ses4_descripcion' => $row_sql['vi2_ses4_descripcion'], 
		'vi2_ses4_video' => $row_sql['vi2_ses4_video'], 
		'vi2_ses5_nombre' => $row_sql['vi2_ses5_nombre'], 
		'vi2_ses5_descripcion' => $row_sql['vi2_ses5_descripcion'], 
		'vi2_ses5_video' => $row_sql['vi2_ses5_video'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('vi2_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_vi1_id', 'text', array('required' => true));
	$form = $form->add('vi2_ses1_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses1_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses1_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses2_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses2_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses2_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses3_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses3_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses3_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses4_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses4_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses4_video', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses5_nombre', 'text', array('required' => true));
	$form = $form->add('vi2_ses5_descripcion', 'textarea', array('required' => true));
	$form = $form->add('vi2_ses5_video', 'textarea', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `video2` SET `vi2_nombre` = ?, `vi2_vi1_id` = ?, `vi2_ses1_nombre` = ?, `vi2_ses1_descripcion` = ?, `vi2_ses1_video` = ?, `vi2_ses2_nombre` = ?, `vi2_ses2_descripcion` = ?, `vi2_ses2_video` = ?, `vi2_ses3_nombre` = ?, `vi2_ses3_descripcion` = ?, `vi2_ses3_video` = ?, `vi2_ses4_nombre` = ?, `vi2_ses4_descripcion` = ?, `vi2_ses4_video` = ?, `vi2_ses5_nombre` = ?, `vi2_ses5_descripcion` = ?, `vi2_ses5_video` = ? WHERE `vi2_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['vi2_nombre'], $data['vi2_vi1_id'], $data['vi2_ses1_nombre'], $data['vi2_ses1_descripcion'], $data['vi2_ses1_video'], $data['vi2_ses2_nombre'], $data['vi2_ses2_descripcion'], $data['vi2_ses2_video'], $data['vi2_ses3_nombre'], $data['vi2_ses3_descripcion'], $data['vi2_ses3_video'], $data['vi2_ses4_nombre'], $data['vi2_ses4_descripcion'], $data['vi2_ses4_video'], $data['vi2_ses5_nombre'], $data['vi2_ses5_descripcion'], $data['vi2_ses5_video'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'video2 edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('video2_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('video2/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('video2_edit');



$app->match('/video2/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `video2` WHERE `vi2_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `video2` WHERE `vi2_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'video2 deleted!',
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

    return $app->redirect($app['url_generator']->generate('video2_list'));

})
->bind('video2_delete');






