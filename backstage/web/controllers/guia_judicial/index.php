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

$app->match('/guia_judicial/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'gju_id', 
		'gju_cgj_id', 
		'gju_nombre', 
		'gju_domicilio', 
		'gju_titulo1', 
		'gju_texto1', 
		'gju_titulo2', 
		'gju_texto2', 
		'gju_titulo3', 
		'gju_texto3', 
		'gju_titulo4', 
		'gju_texto4', 
		'gju_titulo5', 
		'gju_texto5', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `guia_judicial`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `guia_judicial`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/guia_judicial/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . guia_judicial . " WHERE ".$idfldname." = ?";
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



$app->match('/guia_judicial', function () use ($app) {
    
	$table_columns = array(
		'gju_id', 
		'gju_cgj_id', 
		'gju_nombre', 
		'gju_domicilio', 
		'gju_titulo1', 
		'gju_texto1', 
		'gju_titulo2', 
		'gju_texto2', 
		'gju_titulo3', 
		'gju_texto3', 
		'gju_titulo4', 
		'gju_texto4', 
		'gju_titulo5', 
		'gju_texto5', 

    );

    $primary_key = "gju_id";	

    return $app['twig']->render('guia_judicial/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('guia_judicial_list');



$app->match('/guia_judicial/create', function () use ($app) {
    
    $initial_data = array(
		'gju_cgj_id' => '', 
		'gju_nombre' => '', 
		'gju_domicilio' => '', 
		'gju_titulo1' => '', 
		'gju_texto1' => '', 
		'gju_titulo2' => '', 
		'gju_texto2' => '', 
		'gju_titulo3' => '', 
		'gju_texto3' => '', 
		'gju_titulo4' => '', 
		'gju_texto4' => '', 
		'gju_titulo5' => '', 
		'gju_texto5' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('gju_cgj_id', 'text', array('required' => true));
	$form = $form->add('gju_nombre', 'text', array('required' => true));
	$form = $form->add('gju_domicilio', 'text', array('required' => false));
	$form = $form->add('gju_titulo1', 'text', array('required' => false));
	$form = $form->add('gju_texto1', 'text', array('required' => false));
	$form = $form->add('gju_titulo2', 'text', array('required' => false));
	$form = $form->add('gju_texto2', 'text', array('required' => false));
	$form = $form->add('gju_titulo3', 'text', array('required' => false));
	$form = $form->add('gju_texto3', 'text', array('required' => false));
	$form = $form->add('gju_titulo4', 'text', array('required' => false));
	$form = $form->add('gju_texto4', 'text', array('required' => false));
	$form = $form->add('gju_titulo5', 'text', array('required' => false));
	$form = $form->add('gju_texto5', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `guia_judicial` (`gju_cgj_id`, `gju_nombre`, `gju_domicilio`, `gju_titulo1`, `gju_texto1`, `gju_titulo2`, `gju_texto2`, `gju_titulo3`, `gju_texto3`, `gju_titulo4`, `gju_texto4`, `gju_titulo5`, `gju_texto5`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['gju_cgj_id'], $data['gju_nombre'], $data['gju_domicilio'], $data['gju_titulo1'], $data['gju_texto1'], $data['gju_titulo2'], $data['gju_texto2'], $data['gju_titulo3'], $data['gju_texto3'], $data['gju_titulo4'], $data['gju_texto4'], $data['gju_titulo5'], $data['gju_texto5']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'guia_judicial created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('guia_judicial_list'));

        }
    }

    return $app['twig']->render('guia_judicial/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('guia_judicial_create');



$app->match('/guia_judicial/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `guia_judicial` WHERE `gju_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('guia_judicial_list'));
    }

    
    $initial_data = array(
		'gju_cgj_id' => $row_sql['gju_cgj_id'], 
		'gju_nombre' => $row_sql['gju_nombre'], 
		'gju_domicilio' => $row_sql['gju_domicilio'], 
		'gju_titulo1' => $row_sql['gju_titulo1'], 
		'gju_texto1' => $row_sql['gju_texto1'], 
		'gju_titulo2' => $row_sql['gju_titulo2'], 
		'gju_texto2' => $row_sql['gju_texto2'], 
		'gju_titulo3' => $row_sql['gju_titulo3'], 
		'gju_texto3' => $row_sql['gju_texto3'], 
		'gju_titulo4' => $row_sql['gju_titulo4'], 
		'gju_texto4' => $row_sql['gju_texto4'], 
		'gju_titulo5' => $row_sql['gju_titulo5'], 
		'gju_texto5' => $row_sql['gju_texto5'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('gju_cgj_id', 'text', array('required' => true));
	$form = $form->add('gju_nombre', 'text', array('required' => true));
	$form = $form->add('gju_domicilio', 'text', array('required' => false));
	$form = $form->add('gju_titulo1', 'text', array('required' => false));
	$form = $form->add('gju_texto1', 'text', array('required' => false));
	$form = $form->add('gju_titulo2', 'text', array('required' => false));
	$form = $form->add('gju_texto2', 'text', array('required' => false));
	$form = $form->add('gju_titulo3', 'text', array('required' => false));
	$form = $form->add('gju_texto3', 'text', array('required' => false));
	$form = $form->add('gju_titulo4', 'text', array('required' => false));
	$form = $form->add('gju_texto4', 'text', array('required' => false));
	$form = $form->add('gju_titulo5', 'text', array('required' => false));
	$form = $form->add('gju_texto5', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `guia_judicial` SET `gju_cgj_id` = ?, `gju_nombre` = ?, `gju_domicilio` = ?, `gju_titulo1` = ?, `gju_texto1` = ?, `gju_titulo2` = ?, `gju_texto2` = ?, `gju_titulo3` = ?, `gju_texto3` = ?, `gju_titulo4` = ?, `gju_texto4` = ?, `gju_titulo5` = ?, `gju_texto5` = ? WHERE `gju_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['gju_cgj_id'], $data['gju_nombre'], $data['gju_domicilio'], $data['gju_titulo1'], $data['gju_texto1'], $data['gju_titulo2'], $data['gju_texto2'], $data['gju_titulo3'], $data['gju_texto3'], $data['gju_titulo4'], $data['gju_texto4'], $data['gju_titulo5'], $data['gju_texto5'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'guia_judicial edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('guia_judicial_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('guia_judicial/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('guia_judicial_edit');



$app->match('/guia_judicial/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `guia_judicial` WHERE `gju_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `guia_judicial` WHERE `gju_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'guia_judicial deleted!',
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

    return $app->redirect($app['url_generator']->generate('guia_judicial_list'));

})
->bind('guia_judicial_delete');






