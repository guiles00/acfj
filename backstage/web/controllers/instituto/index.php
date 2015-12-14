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

$app->match('/instituto/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'ins_id', 
		'ins_nombre', 
		'ins_foto1', 
		'ins_ejes', 
		'ins_jurados', 
		'ins_ganadores', 
		'ins_fecha', 
		'ins_tin_id', 
		'ins_archivo', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'text', 
		'text', 
		'text', 
		'date', 
		'int(11)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `instituto`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `instituto`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/instituto/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . instituto . " WHERE ".$idfldname." = ?";
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



$app->match('/instituto', function () use ($app) {
    
	$table_columns = array(
		'ins_id', 
		'ins_nombre', 
		'ins_foto1', 
		'ins_ejes', 
		'ins_jurados', 
		'ins_ganadores', 
		'ins_fecha', 
		'ins_tin_id', 
		'ins_archivo', 

    );

    $primary_key = "ins_id";	

    return $app['twig']->render('instituto/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('instituto_list');



$app->match('/instituto/create', function () use ($app) {
    
    $initial_data = array(
		'ins_nombre' => '', 
		'ins_foto1' => '', 
		'ins_ejes' => '', 
		'ins_jurados' => '', 
		'ins_ganadores' => '', 
		'ins_fecha' => '', 
		'ins_tin_id' => '', 
		'ins_archivo' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('ins_nombre', 'text', array('required' => true));
	$form = $form->add('ins_foto1', 'text', array('required' => false));
	$form = $form->add('ins_ejes', 'textarea', array('required' => false));
	$form = $form->add('ins_jurados', 'textarea', array('required' => false));
	$form = $form->add('ins_ganadores', 'textarea', array('required' => false));
	$form = $form->add('ins_fecha', 'text', array('required' => true));
	$form = $form->add('ins_tin_id', 'text', array('required' => true));
	$form = $form->add('ins_archivo', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `instituto` (`ins_nombre`, `ins_foto1`, `ins_ejes`, `ins_jurados`, `ins_ganadores`, `ins_fecha`, `ins_tin_id`, `ins_archivo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['ins_nombre'], $data['ins_foto1'], $data['ins_ejes'], $data['ins_jurados'], $data['ins_ganadores'], $data['ins_fecha'], $data['ins_tin_id'], $data['ins_archivo']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'instituto created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('instituto_list'));

        }
    }

    return $app['twig']->render('instituto/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('instituto_create');



$app->match('/instituto/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `instituto` WHERE `ins_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('instituto_list'));
    }

    
    $initial_data = array(
		'ins_nombre' => $row_sql['ins_nombre'], 
		'ins_foto1' => $row_sql['ins_foto1'], 
		'ins_ejes' => $row_sql['ins_ejes'], 
		'ins_jurados' => $row_sql['ins_jurados'], 
		'ins_ganadores' => $row_sql['ins_ganadores'], 
		'ins_fecha' => $row_sql['ins_fecha'], 
		'ins_tin_id' => $row_sql['ins_tin_id'], 
		'ins_archivo' => $row_sql['ins_archivo'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('ins_nombre', 'text', array('required' => true));
	$form = $form->add('ins_foto1', 'text', array('required' => false));
	$form = $form->add('ins_ejes', 'textarea', array('required' => false));
	$form = $form->add('ins_jurados', 'textarea', array('required' => false));
	$form = $form->add('ins_ganadores', 'textarea', array('required' => false));
	$form = $form->add('ins_fecha', 'text', array('required' => true));
	$form = $form->add('ins_tin_id', 'text', array('required' => true));
	$form = $form->add('ins_archivo', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `instituto` SET `ins_nombre` = ?, `ins_foto1` = ?, `ins_ejes` = ?, `ins_jurados` = ?, `ins_ganadores` = ?, `ins_fecha` = ?, `ins_tin_id` = ?, `ins_archivo` = ? WHERE `ins_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['ins_nombre'], $data['ins_foto1'], $data['ins_ejes'], $data['ins_jurados'], $data['ins_ganadores'], $data['ins_fecha'], $data['ins_tin_id'], $data['ins_archivo'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'instituto edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('instituto_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('instituto/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('instituto_edit');



$app->match('/instituto/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `instituto` WHERE `ins_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `instituto` WHERE `ins_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'instituto deleted!',
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

    return $app->redirect($app['url_generator']->generate('instituto_list'));

})
->bind('instituto_delete');






