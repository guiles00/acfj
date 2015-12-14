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

$app->match('/grupo_curso/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'gcu_id', 
		'gcu_nombre', 
		'gcu_orden', 
		'gcu_imagen', 
		'gcu_texto', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'tinyint(4)', 
		'varchar(255)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `grupo_curso`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `grupo_curso`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/grupo_curso/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . grupo_curso . " WHERE ".$idfldname." = ?";
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



$app->match('/grupo_curso', function () use ($app) {
    
	$table_columns = array(
		'gcu_id', 
		'gcu_nombre', 
		'gcu_orden', 
		'gcu_imagen', 
		'gcu_texto', 

    );

    $primary_key = "gcu_id";	

    return $app['twig']->render('grupo_curso/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('grupo_curso_list');



$app->match('/grupo_curso/create', function () use ($app) {
    
    $initial_data = array(
		'gcu_nombre' => '', 
		'gcu_orden' => '', 
		'gcu_imagen' => '', 
		'gcu_texto' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('gcu_nombre', 'text', array('required' => true));
	$form = $form->add('gcu_orden', 'text', array('required' => false));
	$form = $form->add('gcu_imagen', 'text', array('required' => false));
	$form = $form->add('gcu_texto', 'textarea', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `grupo_curso` (`gcu_nombre`, `gcu_orden`, `gcu_imagen`, `gcu_texto`) VALUES (?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['gcu_nombre'], $data['gcu_orden'], $data['gcu_imagen'], $data['gcu_texto']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'grupo_curso created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('grupo_curso_list'));

        }
    }

    return $app['twig']->render('grupo_curso/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('grupo_curso_create');



$app->match('/grupo_curso/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `grupo_curso` WHERE `gcu_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('grupo_curso_list'));
    }

    
    $initial_data = array(
		'gcu_nombre' => $row_sql['gcu_nombre'], 
		'gcu_orden' => $row_sql['gcu_orden'], 
		'gcu_imagen' => $row_sql['gcu_imagen'], 
		'gcu_texto' => $row_sql['gcu_texto'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('gcu_nombre', 'text', array('required' => true));
	$form = $form->add('gcu_orden', 'text', array('required' => false));
	$form = $form->add('gcu_imagen', 'text', array('required' => false));
	$form = $form->add('gcu_texto', 'textarea', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `grupo_curso` SET `gcu_nombre` = ?, `gcu_orden` = ?, `gcu_imagen` = ?, `gcu_texto` = ? WHERE `gcu_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['gcu_nombre'], $data['gcu_orden'], $data['gcu_imagen'], $data['gcu_texto'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'grupo_curso edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('grupo_curso_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('grupo_curso/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('grupo_curso_edit');



$app->match('/grupo_curso/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `grupo_curso` WHERE `gcu_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `grupo_curso` WHERE `gcu_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'grupo_curso deleted!',
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

    return $app->redirect($app['url_generator']->generate('grupo_curso_list'));

})
->bind('grupo_curso_delete');






