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

$app->match('/dependencia/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'dep_id', 
		'dep_nombre', 
		'fuero_id', 
		'orden', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'int(11)', 
		'int(11)', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `dependencia`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `dependencia`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
        for($i = 0; $i < count($table_columns); $i++){

			if($table_columns[$i] == 'fuero_id'){
			    $findexternal_sql = 'SELECT `fuero_id` FROM `fuero` WHERE `fuero_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['fuero_id'];
			}
			else{
			    $rows[$row_key][$table_columns[$i]] = $row_sql[$table_columns[$i]];
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
$app->match('/dependencia/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . dependencia . " WHERE ".$idfldname." = ?";
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



$app->match('/dependencia', function () use ($app) {
    
	$table_columns = array(
		'dep_id', 
		'dep_nombre', 
		'fuero_id', 
		'orden', 

    );

    $primary_key = "dep_id";	

    return $app['twig']->render('dependencia/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('dependencia_list');



$app->match('/dependencia/create', function () use ($app) {
    
    $initial_data = array(
		'dep_nombre' => '', 
		'fuero_id' => '', 
		'orden' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$options = array();
	$findexternal_sql = 'SELECT `fuero_id`, `fuero_id` FROM `fuero`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['fuero_id']] = $findexternal_row['fuero_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('fuero_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('fuero_id', 'text', array('required' => true));
	}



	$form = $form->add('dep_nombre', 'text', array('required' => true));
	$form = $form->add('orden', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `dependencia` (`dep_nombre`, `fuero_id`, `orden`) VALUES (?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['dep_nombre'], $data['fuero_id'], $data['orden']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'dependencia created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('dependencia_list'));

        }
    }

    return $app['twig']->render('dependencia/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('dependencia_create');



$app->match('/dependencia/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `dependencia` WHERE `dep_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('dependencia_list'));
    }

    
    $initial_data = array(
		'dep_nombre' => $row_sql['dep_nombre'], 
		'fuero_id' => $row_sql['fuero_id'], 
		'orden' => $row_sql['orden'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$options = array();
	$findexternal_sql = 'SELECT `fuero_id`, `fuero_id` FROM `fuero`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['fuero_id']] = $findexternal_row['fuero_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('fuero_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('fuero_id', 'text', array('required' => true));
	}


	$form = $form->add('dep_nombre', 'text', array('required' => true));
	$form = $form->add('orden', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `dependencia` SET `dep_nombre` = ?, `fuero_id` = ?, `orden` = ? WHERE `dep_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['dep_nombre'], $data['fuero_id'], $data['orden'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'dependencia edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('dependencia_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('dependencia/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('dependencia_edit');



$app->match('/dependencia/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `dependencia` WHERE `dep_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `dependencia` WHERE `dep_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'dependencia deleted!',
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

    return $app->redirect($app['url_generator']->generate('dependencia_list'));

})
->bind('dependencia_delete');






