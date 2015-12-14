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

$app->match('/multimedia_sesion/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'mse_id', 
		'mse_mul_id', 
		'mse_fecha', 
		'mse_curso', 
		'mse_sesion', 
		'mse_video', 
		'mse_texto', 
		'mse_archivo1', 
		'mse_link1', 
		'mse_archivo1_desc', 
		'mse_link1_desc', 
		'mse_archivo2', 
		'mse_link2', 
		'mse_archivo2_desc', 
		'mse_link2_desc', 
		'mse_archivo3', 
		'mse_link3', 
		'mse_archivo3_desc', 
		'mse_link3_desc', 
		'mse_archivo4', 
		'mse_link4', 
		'mse_archivo4_desc', 
		'mse_link4_desc', 
		'mse_archivo5', 
		'mse_link5', 
		'mse_archivo5_desc', 
		'mse_link5_desc', 
		'mse_archivo6', 
		'mse_link6', 
		'mse_archivo6_desc', 
		'mse_link6_desc', 
		'mse_archivo7', 
		'mse_link7', 
		'mse_archivo7_desc', 
		'mse_link7_desc', 
		'mse_archivo8', 
		'mse_link8', 
		'mse_archivo8_desc', 
		'mse_link8_desc', 
		'mse_archivo9', 
		'mse_link9', 
		'mse_archivo9_desc', 
		'mse_link9_desc', 
		'mse_archivo10', 
		'mse_link10', 
		'mse_archivo10_desc', 
		'mse_link10_desc', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'date', 
		'varchar(255)', 
		'varchar(255)', 
		'text', 
		'text', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `multimedia_sesion`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `multimedia_sesion`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/multimedia_sesion/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . multimedia_sesion . " WHERE ".$idfldname." = ?";
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



$app->match('/multimedia_sesion', function () use ($app) {
    
	$table_columns = array(
		'mse_id', 
		'mse_mul_id', 
		'mse_fecha', 
		'mse_curso', 
		'mse_sesion', 
		'mse_video', 
		'mse_texto', 
		'mse_archivo1', 
		'mse_link1', 
		'mse_archivo1_desc', 
		'mse_link1_desc', 
		'mse_archivo2', 
		'mse_link2', 
		'mse_archivo2_desc', 
		'mse_link2_desc', 
		'mse_archivo3', 
		'mse_link3', 
		'mse_archivo3_desc', 
		'mse_link3_desc', 
		'mse_archivo4', 
		'mse_link4', 
		'mse_archivo4_desc', 
		'mse_link4_desc', 
		'mse_archivo5', 
		'mse_link5', 
		'mse_archivo5_desc', 
		'mse_link5_desc', 
		'mse_archivo6', 
		'mse_link6', 
		'mse_archivo6_desc', 
		'mse_link6_desc', 
		'mse_archivo7', 
		'mse_link7', 
		'mse_archivo7_desc', 
		'mse_link7_desc', 
		'mse_archivo8', 
		'mse_link8', 
		'mse_archivo8_desc', 
		'mse_link8_desc', 
		'mse_archivo9', 
		'mse_link9', 
		'mse_archivo9_desc', 
		'mse_link9_desc', 
		'mse_archivo10', 
		'mse_link10', 
		'mse_archivo10_desc', 
		'mse_link10_desc', 

    );

    $primary_key = "mse_id";	

    return $app['twig']->render('multimedia_sesion/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('multimedia_sesion_list');



$app->match('/multimedia_sesion/create', function () use ($app) {
    
    $initial_data = array(
		'mse_mul_id' => '', 
		'mse_fecha' => '', 
		'mse_curso' => '', 
		'mse_sesion' => '', 
		'mse_video' => '', 
		'mse_texto' => '', 
		'mse_archivo1' => '', 
		'mse_link1' => '', 
		'mse_archivo1_desc' => '', 
		'mse_link1_desc' => '', 
		'mse_archivo2' => '', 
		'mse_link2' => '', 
		'mse_archivo2_desc' => '', 
		'mse_link2_desc' => '', 
		'mse_archivo3' => '', 
		'mse_link3' => '', 
		'mse_archivo3_desc' => '', 
		'mse_link3_desc' => '', 
		'mse_archivo4' => '', 
		'mse_link4' => '', 
		'mse_archivo4_desc' => '', 
		'mse_link4_desc' => '', 
		'mse_archivo5' => '', 
		'mse_link5' => '', 
		'mse_archivo5_desc' => '', 
		'mse_link5_desc' => '', 
		'mse_archivo6' => '', 
		'mse_link6' => '', 
		'mse_archivo6_desc' => '', 
		'mse_link6_desc' => '', 
		'mse_archivo7' => '', 
		'mse_link7' => '', 
		'mse_archivo7_desc' => '', 
		'mse_link7_desc' => '', 
		'mse_archivo8' => '', 
		'mse_link8' => '', 
		'mse_archivo8_desc' => '', 
		'mse_link8_desc' => '', 
		'mse_archivo9' => '', 
		'mse_link9' => '', 
		'mse_archivo9_desc' => '', 
		'mse_link9_desc' => '', 
		'mse_archivo10' => '', 
		'mse_link10' => '', 
		'mse_archivo10_desc' => '', 
		'mse_link10_desc' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('mse_mul_id', 'text', array('required' => true));
	$form = $form->add('mse_fecha', 'text', array('required' => true));
	$form = $form->add('mse_curso', 'text', array('required' => true));
	$form = $form->add('mse_sesion', 'text', array('required' => true));
	$form = $form->add('mse_video', 'textarea', array('required' => false));
	$form = $form->add('mse_texto', 'textarea', array('required' => false));
	$form = $form->add('mse_archivo1', 'text', array('required' => false));
	$form = $form->add('mse_link1', 'text', array('required' => false));
	$form = $form->add('mse_archivo1_desc', 'text', array('required' => false));
	$form = $form->add('mse_link1_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo2', 'text', array('required' => false));
	$form = $form->add('mse_link2', 'text', array('required' => false));
	$form = $form->add('mse_archivo2_desc', 'text', array('required' => false));
	$form = $form->add('mse_link2_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo3', 'text', array('required' => false));
	$form = $form->add('mse_link3', 'text', array('required' => false));
	$form = $form->add('mse_archivo3_desc', 'text', array('required' => false));
	$form = $form->add('mse_link3_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo4', 'text', array('required' => false));
	$form = $form->add('mse_link4', 'text', array('required' => false));
	$form = $form->add('mse_archivo4_desc', 'text', array('required' => false));
	$form = $form->add('mse_link4_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo5', 'text', array('required' => false));
	$form = $form->add('mse_link5', 'text', array('required' => false));
	$form = $form->add('mse_archivo5_desc', 'text', array('required' => false));
	$form = $form->add('mse_link5_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo6', 'text', array('required' => false));
	$form = $form->add('mse_link6', 'text', array('required' => false));
	$form = $form->add('mse_archivo6_desc', 'text', array('required' => false));
	$form = $form->add('mse_link6_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo7', 'text', array('required' => false));
	$form = $form->add('mse_link7', 'text', array('required' => false));
	$form = $form->add('mse_archivo7_desc', 'text', array('required' => false));
	$form = $form->add('mse_link7_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo8', 'text', array('required' => false));
	$form = $form->add('mse_link8', 'text', array('required' => false));
	$form = $form->add('mse_archivo8_desc', 'text', array('required' => false));
	$form = $form->add('mse_link8_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo9', 'text', array('required' => false));
	$form = $form->add('mse_link9', 'text', array('required' => false));
	$form = $form->add('mse_archivo9_desc', 'text', array('required' => false));
	$form = $form->add('mse_link9_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo10', 'text', array('required' => false));
	$form = $form->add('mse_link10', 'text', array('required' => false));
	$form = $form->add('mse_archivo10_desc', 'text', array('required' => false));
	$form = $form->add('mse_link10_desc', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `multimedia_sesion` (`mse_mul_id`, `mse_fecha`, `mse_curso`, `mse_sesion`, `mse_video`, `mse_texto`, `mse_archivo1`, `mse_link1`, `mse_archivo1_desc`, `mse_link1_desc`, `mse_archivo2`, `mse_link2`, `mse_archivo2_desc`, `mse_link2_desc`, `mse_archivo3`, `mse_link3`, `mse_archivo3_desc`, `mse_link3_desc`, `mse_archivo4`, `mse_link4`, `mse_archivo4_desc`, `mse_link4_desc`, `mse_archivo5`, `mse_link5`, `mse_archivo5_desc`, `mse_link5_desc`, `mse_archivo6`, `mse_link6`, `mse_archivo6_desc`, `mse_link6_desc`, `mse_archivo7`, `mse_link7`, `mse_archivo7_desc`, `mse_link7_desc`, `mse_archivo8`, `mse_link8`, `mse_archivo8_desc`, `mse_link8_desc`, `mse_archivo9`, `mse_link9`, `mse_archivo9_desc`, `mse_link9_desc`, `mse_archivo10`, `mse_link10`, `mse_archivo10_desc`, `mse_link10_desc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['mse_mul_id'], $data['mse_fecha'], $data['mse_curso'], $data['mse_sesion'], $data['mse_video'], $data['mse_texto'], $data['mse_archivo1'], $data['mse_link1'], $data['mse_archivo1_desc'], $data['mse_link1_desc'], $data['mse_archivo2'], $data['mse_link2'], $data['mse_archivo2_desc'], $data['mse_link2_desc'], $data['mse_archivo3'], $data['mse_link3'], $data['mse_archivo3_desc'], $data['mse_link3_desc'], $data['mse_archivo4'], $data['mse_link4'], $data['mse_archivo4_desc'], $data['mse_link4_desc'], $data['mse_archivo5'], $data['mse_link5'], $data['mse_archivo5_desc'], $data['mse_link5_desc'], $data['mse_archivo6'], $data['mse_link6'], $data['mse_archivo6_desc'], $data['mse_link6_desc'], $data['mse_archivo7'], $data['mse_link7'], $data['mse_archivo7_desc'], $data['mse_link7_desc'], $data['mse_archivo8'], $data['mse_link8'], $data['mse_archivo8_desc'], $data['mse_link8_desc'], $data['mse_archivo9'], $data['mse_link9'], $data['mse_archivo9_desc'], $data['mse_link9_desc'], $data['mse_archivo10'], $data['mse_link10'], $data['mse_archivo10_desc'], $data['mse_link10_desc']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'multimedia_sesion created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('multimedia_sesion_list'));

        }
    }

    return $app['twig']->render('multimedia_sesion/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('multimedia_sesion_create');



$app->match('/multimedia_sesion/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `multimedia_sesion` WHERE `mse_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('multimedia_sesion_list'));
    }

    
    $initial_data = array(
		'mse_mul_id' => $row_sql['mse_mul_id'], 
		'mse_fecha' => $row_sql['mse_fecha'], 
		'mse_curso' => $row_sql['mse_curso'], 
		'mse_sesion' => $row_sql['mse_sesion'], 
		'mse_video' => $row_sql['mse_video'], 
		'mse_texto' => $row_sql['mse_texto'], 
		'mse_archivo1' => $row_sql['mse_archivo1'], 
		'mse_link1' => $row_sql['mse_link1'], 
		'mse_archivo1_desc' => $row_sql['mse_archivo1_desc'], 
		'mse_link1_desc' => $row_sql['mse_link1_desc'], 
		'mse_archivo2' => $row_sql['mse_archivo2'], 
		'mse_link2' => $row_sql['mse_link2'], 
		'mse_archivo2_desc' => $row_sql['mse_archivo2_desc'], 
		'mse_link2_desc' => $row_sql['mse_link2_desc'], 
		'mse_archivo3' => $row_sql['mse_archivo3'], 
		'mse_link3' => $row_sql['mse_link3'], 
		'mse_archivo3_desc' => $row_sql['mse_archivo3_desc'], 
		'mse_link3_desc' => $row_sql['mse_link3_desc'], 
		'mse_archivo4' => $row_sql['mse_archivo4'], 
		'mse_link4' => $row_sql['mse_link4'], 
		'mse_archivo4_desc' => $row_sql['mse_archivo4_desc'], 
		'mse_link4_desc' => $row_sql['mse_link4_desc'], 
		'mse_archivo5' => $row_sql['mse_archivo5'], 
		'mse_link5' => $row_sql['mse_link5'], 
		'mse_archivo5_desc' => $row_sql['mse_archivo5_desc'], 
		'mse_link5_desc' => $row_sql['mse_link5_desc'], 
		'mse_archivo6' => $row_sql['mse_archivo6'], 
		'mse_link6' => $row_sql['mse_link6'], 
		'mse_archivo6_desc' => $row_sql['mse_archivo6_desc'], 
		'mse_link6_desc' => $row_sql['mse_link6_desc'], 
		'mse_archivo7' => $row_sql['mse_archivo7'], 
		'mse_link7' => $row_sql['mse_link7'], 
		'mse_archivo7_desc' => $row_sql['mse_archivo7_desc'], 
		'mse_link7_desc' => $row_sql['mse_link7_desc'], 
		'mse_archivo8' => $row_sql['mse_archivo8'], 
		'mse_link8' => $row_sql['mse_link8'], 
		'mse_archivo8_desc' => $row_sql['mse_archivo8_desc'], 
		'mse_link8_desc' => $row_sql['mse_link8_desc'], 
		'mse_archivo9' => $row_sql['mse_archivo9'], 
		'mse_link9' => $row_sql['mse_link9'], 
		'mse_archivo9_desc' => $row_sql['mse_archivo9_desc'], 
		'mse_link9_desc' => $row_sql['mse_link9_desc'], 
		'mse_archivo10' => $row_sql['mse_archivo10'], 
		'mse_link10' => $row_sql['mse_link10'], 
		'mse_archivo10_desc' => $row_sql['mse_archivo10_desc'], 
		'mse_link10_desc' => $row_sql['mse_link10_desc'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('mse_mul_id', 'text', array('required' => true));
	$form = $form->add('mse_fecha', 'text', array('required' => true));
	$form = $form->add('mse_curso', 'text', array('required' => true));
	$form = $form->add('mse_sesion', 'text', array('required' => true));
	$form = $form->add('mse_video', 'textarea', array('required' => false));
	$form = $form->add('mse_texto', 'textarea', array('required' => false));
	$form = $form->add('mse_archivo1', 'text', array('required' => false));
	$form = $form->add('mse_link1', 'text', array('required' => false));
	$form = $form->add('mse_archivo1_desc', 'text', array('required' => false));
	$form = $form->add('mse_link1_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo2', 'text', array('required' => false));
	$form = $form->add('mse_link2', 'text', array('required' => false));
	$form = $form->add('mse_archivo2_desc', 'text', array('required' => false));
	$form = $form->add('mse_link2_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo3', 'text', array('required' => false));
	$form = $form->add('mse_link3', 'text', array('required' => false));
	$form = $form->add('mse_archivo3_desc', 'text', array('required' => false));
	$form = $form->add('mse_link3_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo4', 'text', array('required' => false));
	$form = $form->add('mse_link4', 'text', array('required' => false));
	$form = $form->add('mse_archivo4_desc', 'text', array('required' => false));
	$form = $form->add('mse_link4_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo5', 'text', array('required' => false));
	$form = $form->add('mse_link5', 'text', array('required' => false));
	$form = $form->add('mse_archivo5_desc', 'text', array('required' => false));
	$form = $form->add('mse_link5_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo6', 'text', array('required' => false));
	$form = $form->add('mse_link6', 'text', array('required' => false));
	$form = $form->add('mse_archivo6_desc', 'text', array('required' => false));
	$form = $form->add('mse_link6_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo7', 'text', array('required' => false));
	$form = $form->add('mse_link7', 'text', array('required' => false));
	$form = $form->add('mse_archivo7_desc', 'text', array('required' => false));
	$form = $form->add('mse_link7_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo8', 'text', array('required' => false));
	$form = $form->add('mse_link8', 'text', array('required' => false));
	$form = $form->add('mse_archivo8_desc', 'text', array('required' => false));
	$form = $form->add('mse_link8_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo9', 'text', array('required' => false));
	$form = $form->add('mse_link9', 'text', array('required' => false));
	$form = $form->add('mse_archivo9_desc', 'text', array('required' => false));
	$form = $form->add('mse_link9_desc', 'text', array('required' => false));
	$form = $form->add('mse_archivo10', 'text', array('required' => false));
	$form = $form->add('mse_link10', 'text', array('required' => false));
	$form = $form->add('mse_archivo10_desc', 'text', array('required' => false));
	$form = $form->add('mse_link10_desc', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `multimedia_sesion` SET `mse_mul_id` = ?, `mse_fecha` = ?, `mse_curso` = ?, `mse_sesion` = ?, `mse_video` = ?, `mse_texto` = ?, `mse_archivo1` = ?, `mse_link1` = ?, `mse_archivo1_desc` = ?, `mse_link1_desc` = ?, `mse_archivo2` = ?, `mse_link2` = ?, `mse_archivo2_desc` = ?, `mse_link2_desc` = ?, `mse_archivo3` = ?, `mse_link3` = ?, `mse_archivo3_desc` = ?, `mse_link3_desc` = ?, `mse_archivo4` = ?, `mse_link4` = ?, `mse_archivo4_desc` = ?, `mse_link4_desc` = ?, `mse_archivo5` = ?, `mse_link5` = ?, `mse_archivo5_desc` = ?, `mse_link5_desc` = ?, `mse_archivo6` = ?, `mse_link6` = ?, `mse_archivo6_desc` = ?, `mse_link6_desc` = ?, `mse_archivo7` = ?, `mse_link7` = ?, `mse_archivo7_desc` = ?, `mse_link7_desc` = ?, `mse_archivo8` = ?, `mse_link8` = ?, `mse_archivo8_desc` = ?, `mse_link8_desc` = ?, `mse_archivo9` = ?, `mse_link9` = ?, `mse_archivo9_desc` = ?, `mse_link9_desc` = ?, `mse_archivo10` = ?, `mse_link10` = ?, `mse_archivo10_desc` = ?, `mse_link10_desc` = ? WHERE `mse_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['mse_mul_id'], $data['mse_fecha'], $data['mse_curso'], $data['mse_sesion'], $data['mse_video'], $data['mse_texto'], $data['mse_archivo1'], $data['mse_link1'], $data['mse_archivo1_desc'], $data['mse_link1_desc'], $data['mse_archivo2'], $data['mse_link2'], $data['mse_archivo2_desc'], $data['mse_link2_desc'], $data['mse_archivo3'], $data['mse_link3'], $data['mse_archivo3_desc'], $data['mse_link3_desc'], $data['mse_archivo4'], $data['mse_link4'], $data['mse_archivo4_desc'], $data['mse_link4_desc'], $data['mse_archivo5'], $data['mse_link5'], $data['mse_archivo5_desc'], $data['mse_link5_desc'], $data['mse_archivo6'], $data['mse_link6'], $data['mse_archivo6_desc'], $data['mse_link6_desc'], $data['mse_archivo7'], $data['mse_link7'], $data['mse_archivo7_desc'], $data['mse_link7_desc'], $data['mse_archivo8'], $data['mse_link8'], $data['mse_archivo8_desc'], $data['mse_link8_desc'], $data['mse_archivo9'], $data['mse_link9'], $data['mse_archivo9_desc'], $data['mse_link9_desc'], $data['mse_archivo10'], $data['mse_link10'], $data['mse_archivo10_desc'], $data['mse_link10_desc'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'multimedia_sesion edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('multimedia_sesion_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('multimedia_sesion/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('multimedia_sesion_edit');



$app->match('/multimedia_sesion/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `multimedia_sesion` WHERE `mse_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `multimedia_sesion` WHERE `mse_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'multimedia_sesion deleted!',
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

    return $app->redirect($app['url_generator']->generate('multimedia_sesion_list'));

})
->bind('multimedia_sesion_delete');






