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

$app->match('/banner/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'id', 
		'idTipoBanner', 
		'orden', 
		'nombre', 
		'banner', 
		'codigo_fuente', 
		'url', 
		'target', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'tinyint(4)', 
		'varchar(255)', 
		'varchar(255)', 
		'text', 
		'varchar(255)', 
		'tinyint(4)', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `banner`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `banner`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/banner/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . banner . " WHERE ".$idfldname." = ?";
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



$app->match('/banner', function () use ($app) {
    
	$table_columns = array(
		'id', 
		'idTipoBanner', 
		'orden', 
		'nombre', 
		'banner', 
		'codigo_fuente', 
		'url', 
		'target', 

    );

    $primary_key = "id";	

    return $app['twig']->render('banner/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('banner_list');



$app->match('/banner/create', function () use ($app) {
    
    $initial_data = array(
		'idTipoBanner' => '', 
		'orden' => '', 
		'nombre' => '', 
		'banner' => '', 
		'codigo_fuente' => '', 
		'url' => '', 
		'target' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('idTipoBanner', 'text', array('required' => true));
	$form = $form->add('orden', 'text', array('required' => true));
	$form = $form->add('nombre', 'text', array('required' => true));
	$form = $form->add('banner', 'text', array('required' => false));
	$form = $form->add('codigo_fuente', 'textarea', array('required' => false));
	$form = $form->add('url', 'text', array('required' => false));
	$form = $form->add('target', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `banner` (`idTipoBanner`, `orden`, `nombre`, `banner`, `codigo_fuente`, `url`, `target`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['idTipoBanner'], $data['orden'], $data['nombre'], $data['banner'], $data['codigo_fuente'], $data['url'], $data['target']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'banner created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('banner_list'));

        }
    }

    return $app['twig']->render('banner/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('banner_create');



$app->match('/banner/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `banner` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('banner_list'));
    }

    
    $initial_data = array(
		'idTipoBanner' => $row_sql['idTipoBanner'], 
		'orden' => $row_sql['orden'], 
		'nombre' => $row_sql['nombre'], 
		'banner' => $row_sql['banner'], 
		'codigo_fuente' => $row_sql['codigo_fuente'], 
		'url' => $row_sql['url'], 
		'target' => $row_sql['target'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('idTipoBanner', 'text', array('required' => true));
	$form = $form->add('orden', 'text', array('required' => true));
	$form = $form->add('nombre', 'text', array('required' => true));
	$form = $form->add('banner', 'text', array('required' => false));
	$form = $form->add('codigo_fuente', 'textarea', array('required' => false));
	$form = $form->add('url', 'text', array('required' => false));
	$form = $form->add('target', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `banner` SET `idTipoBanner` = ?, `orden` = ?, `nombre` = ?, `banner` = ?, `codigo_fuente` = ?, `url` = ?, `target` = ? WHERE `id` = ?";
            $app['db']->executeUpdate($update_query, array($data['idTipoBanner'], $data['orden'], $data['nombre'], $data['banner'], $data['codigo_fuente'], $data['url'], $data['target'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'banner edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('banner_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('banner/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('banner_edit');



$app->match('/banner/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `banner` WHERE `id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `banner` WHERE `id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'banner deleted!',
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

    return $app->redirect($app['url_generator']->generate('banner_list'));

})
->bind('banner_delete');






