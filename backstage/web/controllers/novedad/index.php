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

$app->match('/novedad/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'nov_id', 
		'nov_gno_id', 
		'nov_fecha', 
		'nov_titulo', 
		'nov_copete', 
		'nov_texto', 
		'nov_foto1', 
		'nov_adjunto1', 
		'nov_mostrarWeb', 
		'nov_esDestacada', 
		'nov_esDestacadaHome', 
		'nov_adjunto1_desc', 
		'nov_adjunto2_desc', 
		'nov_adjunto2', 
		'nov_adjunto3_desc', 
		'nov_adjunto3', 
		'nov_html', 
		'nov_link', 
		'nov_afiche', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(20)', 
		'date', 
		'varchar(255)', 
		'text', 
		'text', 
		'varchar(255)', 
		'varchar(255)', 
		'char(2)', 
		'char(2)', 
		'char(2)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'text', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `novedad`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `novedad`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/novedad/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . novedad . " WHERE ".$idfldname." = ?";
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



$app->match('/novedad', function () use ($app) {
    
	$table_columns = array(
		'nov_id', 
		'nov_gno_id', 
		'nov_fecha', 
		'nov_titulo', 
		'nov_copete', 
		'nov_texto', 
		'nov_foto1', 
		'nov_adjunto1', 
		'nov_mostrarWeb', 
		'nov_esDestacada', 
		'nov_esDestacadaHome', 
		'nov_adjunto1_desc', 
		'nov_adjunto2_desc', 
		'nov_adjunto2', 
		'nov_adjunto3_desc', 
		'nov_adjunto3', 
		'nov_html', 
		'nov_link', 
		'nov_afiche', 

    );

    $primary_key = "nov_id";	

    return $app['twig']->render('novedad/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('novedad_list');



$app->match('/novedad/create', function () use ($app) {
    
    $initial_data = array(
		'nov_gno_id' => '', 
		'nov_fecha' => '', 
		'nov_titulo' => '', 
		'nov_copete' => '', 
		'nov_texto' => '', 
		'nov_foto1' => '', 
		'nov_adjunto1' => '', 
		'nov_mostrarWeb' => '', 
		'nov_esDestacada' => '', 
		'nov_esDestacadaHome' => '', 
		'nov_adjunto1_desc' => '', 
		'nov_adjunto2_desc' => '', 
		'nov_adjunto2' => '', 
		'nov_adjunto3_desc' => '', 
		'nov_adjunto3' => '', 
		'nov_html' => '', 
		'nov_link' => '', 
		'nov_afiche' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('nov_gno_id', 'text', array('required' => true));
	$form = $form->add('nov_fecha', 'text', array('required' => true));
	$form = $form->add('nov_titulo', 'text', array('required' => true));
	$form = $form->add('nov_copete', 'textarea', array('required' => false));
	$form = $form->add('nov_texto', 'textarea', array('required' => false));
	$form = $form->add('nov_foto1', 'text', array('required' => false));
	$form = $form->add('nov_adjunto1', 'text', array('required' => false));
	$form = $form->add('nov_mostrarWeb', 'text', array('required' => true));
	$form = $form->add('nov_esDestacada', 'text', array('required' => true));
	$form = $form->add('nov_esDestacadaHome', 'text', array('required' => true));
	$form = $form->add('nov_adjunto1_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto2_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto2', 'text', array('required' => false));
	$form = $form->add('nov_adjunto3_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto3', 'text', array('required' => false));
	$form = $form->add('nov_html', 'textarea', array('required' => false));
	$form = $form->add('nov_link', 'text', array('required' => false));
	$form = $form->add('nov_afiche', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `novedad` (`nov_gno_id`, `nov_fecha`, `nov_titulo`, `nov_copete`, `nov_texto`, `nov_foto1`, `nov_adjunto1`, `nov_mostrarWeb`, `nov_esDestacada`, `nov_esDestacadaHome`, `nov_adjunto1_desc`, `nov_adjunto2_desc`, `nov_adjunto2`, `nov_adjunto3_desc`, `nov_adjunto3`, `nov_html`, `nov_link`, `nov_afiche`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['nov_gno_id'], $data['nov_fecha'], $data['nov_titulo'], $data['nov_copete'], $data['nov_texto'], $data['nov_foto1'], $data['nov_adjunto1'], $data['nov_mostrarWeb'], $data['nov_esDestacada'], $data['nov_esDestacadaHome'], $data['nov_adjunto1_desc'], $data['nov_adjunto2_desc'], $data['nov_adjunto2'], $data['nov_adjunto3_desc'], $data['nov_adjunto3'], $data['nov_html'], $data['nov_link'], $data['nov_afiche']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'novedad created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('novedad_list'));

        }
    }

    return $app['twig']->render('novedad/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('novedad_create');



$app->match('/novedad/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `novedad` WHERE `nov_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('novedad_list'));
    }

    
    $initial_data = array(
		'nov_gno_id' => $row_sql['nov_gno_id'], 
		'nov_fecha' => $row_sql['nov_fecha'], 
		'nov_titulo' => $row_sql['nov_titulo'], 
		'nov_copete' => $row_sql['nov_copete'], 
		'nov_texto' => $row_sql['nov_texto'], 
		'nov_foto1' => $row_sql['nov_foto1'], 
		'nov_adjunto1' => $row_sql['nov_adjunto1'], 
		'nov_mostrarWeb' => $row_sql['nov_mostrarWeb'], 
		'nov_esDestacada' => $row_sql['nov_esDestacada'], 
		'nov_esDestacadaHome' => $row_sql['nov_esDestacadaHome'], 
		'nov_adjunto1_desc' => $row_sql['nov_adjunto1_desc'], 
		'nov_adjunto2_desc' => $row_sql['nov_adjunto2_desc'], 
		'nov_adjunto2' => $row_sql['nov_adjunto2'], 
		'nov_adjunto3_desc' => $row_sql['nov_adjunto3_desc'], 
		'nov_adjunto3' => $row_sql['nov_adjunto3'], 
		'nov_html' => $row_sql['nov_html'], 
		'nov_link' => $row_sql['nov_link'], 
		'nov_afiche' => $row_sql['nov_afiche'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('nov_gno_id', 'text', array('required' => true));
	$form = $form->add('nov_fecha', 'text', array('required' => true));
	$form = $form->add('nov_titulo', 'text', array('required' => true));
	$form = $form->add('nov_copete', 'textarea', array('required' => false));
	$form = $form->add('nov_texto', 'textarea', array('required' => false));
	$form = $form->add('nov_foto1', 'text', array('required' => false));
	$form = $form->add('nov_adjunto1', 'text', array('required' => false));
	$form = $form->add('nov_mostrarWeb', 'text', array('required' => true));
	$form = $form->add('nov_esDestacada', 'text', array('required' => true));
	$form = $form->add('nov_esDestacadaHome', 'text', array('required' => true));
	$form = $form->add('nov_adjunto1_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto2_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto2', 'text', array('required' => false));
	$form = $form->add('nov_adjunto3_desc', 'text', array('required' => false));
	$form = $form->add('nov_adjunto3', 'text', array('required' => false));
	$form = $form->add('nov_html', 'textarea', array('required' => false));
	$form = $form->add('nov_link', 'text', array('required' => false));
	$form = $form->add('nov_afiche', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `novedad` SET `nov_gno_id` = ?, `nov_fecha` = ?, `nov_titulo` = ?, `nov_copete` = ?, `nov_texto` = ?, `nov_foto1` = ?, `nov_adjunto1` = ?, `nov_mostrarWeb` = ?, `nov_esDestacada` = ?, `nov_esDestacadaHome` = ?, `nov_adjunto1_desc` = ?, `nov_adjunto2_desc` = ?, `nov_adjunto2` = ?, `nov_adjunto3_desc` = ?, `nov_adjunto3` = ?, `nov_html` = ?, `nov_link` = ?, `nov_afiche` = ? WHERE `nov_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['nov_gno_id'], $data['nov_fecha'], $data['nov_titulo'], $data['nov_copete'], $data['nov_texto'], $data['nov_foto1'], $data['nov_adjunto1'], $data['nov_mostrarWeb'], $data['nov_esDestacada'], $data['nov_esDestacadaHome'], $data['nov_adjunto1_desc'], $data['nov_adjunto2_desc'], $data['nov_adjunto2'], $data['nov_adjunto3_desc'], $data['nov_adjunto3'], $data['nov_html'], $data['nov_link'], $data['nov_afiche'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'novedad edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('novedad_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('novedad/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('novedad_edit');



$app->match('/novedad/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `novedad` WHERE `nov_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `novedad` WHERE `nov_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'novedad deleted!',
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

    return $app->redirect($app['url_generator']->generate('novedad_list'));

})
->bind('novedad_delete');






