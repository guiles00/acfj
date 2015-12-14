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

$app->match('/multimedia/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'mul_id', 
		'mul_fecha', 
		'mul_visible', 
		'mul_tac_id', 
		'mul_tem_id', 
		'mul_titulo', 
		'mul_foto1', 
		'mul_copete', 
		'mul_descripcion', 
		'mul_archivo1', 
		'mul_archivo2', 
		'mul_archivo3', 
		'mul_archivo4', 
		'mul_archivo5', 
		'mul_archivo6', 
		'mul_archivo7', 
		'mul_archivo8', 
		'mul_archivo9', 
		'mul_archivo10', 
		'mul_link1', 
		'mul_link2', 
		'mul_link3', 
		'mul_link4', 
		'mul_link5', 
		'mul_link6', 
		'mul_link7', 
		'mul_link8', 
		'mul_link9', 
		'mul_link10', 
		'mul_archivo1_desc', 
		'mul_archivo2_desc', 
		'mul_archivo3_desc', 
		'mul_archivo4_desc', 
		'mul_archivo5_desc', 
		'mul_archivo6_desc', 
		'mul_archivo7_desc', 
		'mul_archivo8_desc', 
		'mul_archivo9_desc', 
		'mul_archivo10_desc', 
		'mul_link1_desc', 
		'mul_link2_desc', 
		'mul_link3_desc', 
		'mul_link4_desc', 
		'mul_link5_desc', 
		'mul_link6_desc', 
		'mul_link7_desc', 
		'mul_link8_desc', 
		'mul_link9_desc', 
		'mul_link10_desc', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'date', 
		'char(2)', 
		'int(11)', 
		'int(11)', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `multimedia`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `multimedia`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/multimedia/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . multimedia . " WHERE ".$idfldname." = ?";
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



$app->match('/multimedia', function () use ($app) {
    
	$table_columns = array(
		'mul_id', 
		'mul_fecha', 
		'mul_visible', 
		'mul_tac_id', 
		'mul_tem_id', 
		'mul_titulo', 
		'mul_foto1', 
		'mul_copete', 
		'mul_descripcion', 
		'mul_archivo1', 
		'mul_archivo2', 
		'mul_archivo3', 
		'mul_archivo4', 
		'mul_archivo5', 
		'mul_archivo6', 
		'mul_archivo7', 
		'mul_archivo8', 
		'mul_archivo9', 
		'mul_archivo10', 
		'mul_link1', 
		'mul_link2', 
		'mul_link3', 
		'mul_link4', 
		'mul_link5', 
		'mul_link6', 
		'mul_link7', 
		'mul_link8', 
		'mul_link9', 
		'mul_link10', 
		'mul_archivo1_desc', 
		'mul_archivo2_desc', 
		'mul_archivo3_desc', 
		'mul_archivo4_desc', 
		'mul_archivo5_desc', 
		'mul_archivo6_desc', 
		'mul_archivo7_desc', 
		'mul_archivo8_desc', 
		'mul_archivo9_desc', 
		'mul_archivo10_desc', 
		'mul_link1_desc', 
		'mul_link2_desc', 
		'mul_link3_desc', 
		'mul_link4_desc', 
		'mul_link5_desc', 
		'mul_link6_desc', 
		'mul_link7_desc', 
		'mul_link8_desc', 
		'mul_link9_desc', 
		'mul_link10_desc', 

    );

    $primary_key = "mul_id";	

    return $app['twig']->render('multimedia/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('multimedia_list');



$app->match('/multimedia/create', function () use ($app) {
    
    $initial_data = array(
		'mul_fecha' => '', 
		'mul_visible' => '', 
		'mul_tac_id' => '', 
		'mul_tem_id' => '', 
		'mul_titulo' => '', 
		'mul_foto1' => '', 
		'mul_copete' => '', 
		'mul_descripcion' => '', 
		'mul_archivo1' => '', 
		'mul_archivo2' => '', 
		'mul_archivo3' => '', 
		'mul_archivo4' => '', 
		'mul_archivo5' => '', 
		'mul_archivo6' => '', 
		'mul_archivo7' => '', 
		'mul_archivo8' => '', 
		'mul_archivo9' => '', 
		'mul_archivo10' => '', 
		'mul_link1' => '', 
		'mul_link2' => '', 
		'mul_link3' => '', 
		'mul_link4' => '', 
		'mul_link5' => '', 
		'mul_link6' => '', 
		'mul_link7' => '', 
		'mul_link8' => '', 
		'mul_link9' => '', 
		'mul_link10' => '', 
		'mul_archivo1_desc' => '', 
		'mul_archivo2_desc' => '', 
		'mul_archivo3_desc' => '', 
		'mul_archivo4_desc' => '', 
		'mul_archivo5_desc' => '', 
		'mul_archivo6_desc' => '', 
		'mul_archivo7_desc' => '', 
		'mul_archivo8_desc' => '', 
		'mul_archivo9_desc' => '', 
		'mul_archivo10_desc' => '', 
		'mul_link1_desc' => '', 
		'mul_link2_desc' => '', 
		'mul_link3_desc' => '', 
		'mul_link4_desc' => '', 
		'mul_link5_desc' => '', 
		'mul_link6_desc' => '', 
		'mul_link7_desc' => '', 
		'mul_link8_desc' => '', 
		'mul_link9_desc' => '', 
		'mul_link10_desc' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('mul_fecha', 'text', array('required' => true));
	$form = $form->add('mul_visible', 'text', array('required' => true));
	$form = $form->add('mul_tac_id', 'text', array('required' => true));
	$form = $form->add('mul_tem_id', 'text', array('required' => true));
	$form = $form->add('mul_titulo', 'text', array('required' => true));
	$form = $form->add('mul_foto1', 'text', array('required' => false));
	$form = $form->add('mul_copete', 'textarea', array('required' => false));
	$form = $form->add('mul_descripcion', 'textarea', array('required' => false));
	$form = $form->add('mul_archivo1', 'text', array('required' => false));
	$form = $form->add('mul_archivo2', 'text', array('required' => false));
	$form = $form->add('mul_archivo3', 'text', array('required' => false));
	$form = $form->add('mul_archivo4', 'text', array('required' => false));
	$form = $form->add('mul_archivo5', 'text', array('required' => false));
	$form = $form->add('mul_archivo6', 'text', array('required' => false));
	$form = $form->add('mul_archivo7', 'text', array('required' => false));
	$form = $form->add('mul_archivo8', 'text', array('required' => false));
	$form = $form->add('mul_archivo9', 'text', array('required' => false));
	$form = $form->add('mul_archivo10', 'text', array('required' => false));
	$form = $form->add('mul_link1', 'text', array('required' => false));
	$form = $form->add('mul_link2', 'text', array('required' => false));
	$form = $form->add('mul_link3', 'text', array('required' => false));
	$form = $form->add('mul_link4', 'text', array('required' => false));
	$form = $form->add('mul_link5', 'text', array('required' => false));
	$form = $form->add('mul_link6', 'text', array('required' => false));
	$form = $form->add('mul_link7', 'text', array('required' => false));
	$form = $form->add('mul_link8', 'text', array('required' => false));
	$form = $form->add('mul_link9', 'text', array('required' => false));
	$form = $form->add('mul_link10', 'text', array('required' => false));
	$form = $form->add('mul_archivo1_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo2_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo3_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo4_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo5_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo6_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo7_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo8_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo9_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo10_desc', 'text', array('required' => false));
	$form = $form->add('mul_link1_desc', 'text', array('required' => false));
	$form = $form->add('mul_link2_desc', 'text', array('required' => false));
	$form = $form->add('mul_link3_desc', 'text', array('required' => false));
	$form = $form->add('mul_link4_desc', 'text', array('required' => false));
	$form = $form->add('mul_link5_desc', 'text', array('required' => false));
	$form = $form->add('mul_link6_desc', 'text', array('required' => false));
	$form = $form->add('mul_link7_desc', 'text', array('required' => false));
	$form = $form->add('mul_link8_desc', 'text', array('required' => false));
	$form = $form->add('mul_link9_desc', 'text', array('required' => false));
	$form = $form->add('mul_link10_desc', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `multimedia` (`mul_fecha`, `mul_visible`, `mul_tac_id`, `mul_tem_id`, `mul_titulo`, `mul_foto1`, `mul_copete`, `mul_descripcion`, `mul_archivo1`, `mul_archivo2`, `mul_archivo3`, `mul_archivo4`, `mul_archivo5`, `mul_archivo6`, `mul_archivo7`, `mul_archivo8`, `mul_archivo9`, `mul_archivo10`, `mul_link1`, `mul_link2`, `mul_link3`, `mul_link4`, `mul_link5`, `mul_link6`, `mul_link7`, `mul_link8`, `mul_link9`, `mul_link10`, `mul_archivo1_desc`, `mul_archivo2_desc`, `mul_archivo3_desc`, `mul_archivo4_desc`, `mul_archivo5_desc`, `mul_archivo6_desc`, `mul_archivo7_desc`, `mul_archivo8_desc`, `mul_archivo9_desc`, `mul_archivo10_desc`, `mul_link1_desc`, `mul_link2_desc`, `mul_link3_desc`, `mul_link4_desc`, `mul_link5_desc`, `mul_link6_desc`, `mul_link7_desc`, `mul_link8_desc`, `mul_link9_desc`, `mul_link10_desc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['mul_fecha'], $data['mul_visible'], $data['mul_tac_id'], $data['mul_tem_id'], $data['mul_titulo'], $data['mul_foto1'], $data['mul_copete'], $data['mul_descripcion'], $data['mul_archivo1'], $data['mul_archivo2'], $data['mul_archivo3'], $data['mul_archivo4'], $data['mul_archivo5'], $data['mul_archivo6'], $data['mul_archivo7'], $data['mul_archivo8'], $data['mul_archivo9'], $data['mul_archivo10'], $data['mul_link1'], $data['mul_link2'], $data['mul_link3'], $data['mul_link4'], $data['mul_link5'], $data['mul_link6'], $data['mul_link7'], $data['mul_link8'], $data['mul_link9'], $data['mul_link10'], $data['mul_archivo1_desc'], $data['mul_archivo2_desc'], $data['mul_archivo3_desc'], $data['mul_archivo4_desc'], $data['mul_archivo5_desc'], $data['mul_archivo6_desc'], $data['mul_archivo7_desc'], $data['mul_archivo8_desc'], $data['mul_archivo9_desc'], $data['mul_archivo10_desc'], $data['mul_link1_desc'], $data['mul_link2_desc'], $data['mul_link3_desc'], $data['mul_link4_desc'], $data['mul_link5_desc'], $data['mul_link6_desc'], $data['mul_link7_desc'], $data['mul_link8_desc'], $data['mul_link9_desc'], $data['mul_link10_desc']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'multimedia created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('multimedia_list'));

        }
    }

    return $app['twig']->render('multimedia/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('multimedia_create');



$app->match('/multimedia/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `multimedia` WHERE `mul_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('multimedia_list'));
    }

    
    $initial_data = array(
		'mul_fecha' => $row_sql['mul_fecha'], 
		'mul_visible' => $row_sql['mul_visible'], 
		'mul_tac_id' => $row_sql['mul_tac_id'], 
		'mul_tem_id' => $row_sql['mul_tem_id'], 
		'mul_titulo' => $row_sql['mul_titulo'], 
		'mul_foto1' => $row_sql['mul_foto1'], 
		'mul_copete' => $row_sql['mul_copete'], 
		'mul_descripcion' => $row_sql['mul_descripcion'], 
		'mul_archivo1' => $row_sql['mul_archivo1'], 
		'mul_archivo2' => $row_sql['mul_archivo2'], 
		'mul_archivo3' => $row_sql['mul_archivo3'], 
		'mul_archivo4' => $row_sql['mul_archivo4'], 
		'mul_archivo5' => $row_sql['mul_archivo5'], 
		'mul_archivo6' => $row_sql['mul_archivo6'], 
		'mul_archivo7' => $row_sql['mul_archivo7'], 
		'mul_archivo8' => $row_sql['mul_archivo8'], 
		'mul_archivo9' => $row_sql['mul_archivo9'], 
		'mul_archivo10' => $row_sql['mul_archivo10'], 
		'mul_link1' => $row_sql['mul_link1'], 
		'mul_link2' => $row_sql['mul_link2'], 
		'mul_link3' => $row_sql['mul_link3'], 
		'mul_link4' => $row_sql['mul_link4'], 
		'mul_link5' => $row_sql['mul_link5'], 
		'mul_link6' => $row_sql['mul_link6'], 
		'mul_link7' => $row_sql['mul_link7'], 
		'mul_link8' => $row_sql['mul_link8'], 
		'mul_link9' => $row_sql['mul_link9'], 
		'mul_link10' => $row_sql['mul_link10'], 
		'mul_archivo1_desc' => $row_sql['mul_archivo1_desc'], 
		'mul_archivo2_desc' => $row_sql['mul_archivo2_desc'], 
		'mul_archivo3_desc' => $row_sql['mul_archivo3_desc'], 
		'mul_archivo4_desc' => $row_sql['mul_archivo4_desc'], 
		'mul_archivo5_desc' => $row_sql['mul_archivo5_desc'], 
		'mul_archivo6_desc' => $row_sql['mul_archivo6_desc'], 
		'mul_archivo7_desc' => $row_sql['mul_archivo7_desc'], 
		'mul_archivo8_desc' => $row_sql['mul_archivo8_desc'], 
		'mul_archivo9_desc' => $row_sql['mul_archivo9_desc'], 
		'mul_archivo10_desc' => $row_sql['mul_archivo10_desc'], 
		'mul_link1_desc' => $row_sql['mul_link1_desc'], 
		'mul_link2_desc' => $row_sql['mul_link2_desc'], 
		'mul_link3_desc' => $row_sql['mul_link3_desc'], 
		'mul_link4_desc' => $row_sql['mul_link4_desc'], 
		'mul_link5_desc' => $row_sql['mul_link5_desc'], 
		'mul_link6_desc' => $row_sql['mul_link6_desc'], 
		'mul_link7_desc' => $row_sql['mul_link7_desc'], 
		'mul_link8_desc' => $row_sql['mul_link8_desc'], 
		'mul_link9_desc' => $row_sql['mul_link9_desc'], 
		'mul_link10_desc' => $row_sql['mul_link10_desc'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('mul_fecha', 'text', array('required' => true));
	$form = $form->add('mul_visible', 'text', array('required' => true));
	$form = $form->add('mul_tac_id', 'text', array('required' => true));
	$form = $form->add('mul_tem_id', 'text', array('required' => true));
	$form = $form->add('mul_titulo', 'text', array('required' => true));
	$form = $form->add('mul_foto1', 'text', array('required' => false));
	$form = $form->add('mul_copete', 'textarea', array('required' => false));
	$form = $form->add('mul_descripcion', 'textarea', array('required' => false));
	$form = $form->add('mul_archivo1', 'text', array('required' => false));
	$form = $form->add('mul_archivo2', 'text', array('required' => false));
	$form = $form->add('mul_archivo3', 'text', array('required' => false));
	$form = $form->add('mul_archivo4', 'text', array('required' => false));
	$form = $form->add('mul_archivo5', 'text', array('required' => false));
	$form = $form->add('mul_archivo6', 'text', array('required' => false));
	$form = $form->add('mul_archivo7', 'text', array('required' => false));
	$form = $form->add('mul_archivo8', 'text', array('required' => false));
	$form = $form->add('mul_archivo9', 'text', array('required' => false));
	$form = $form->add('mul_archivo10', 'text', array('required' => false));
	$form = $form->add('mul_link1', 'text', array('required' => false));
	$form = $form->add('mul_link2', 'text', array('required' => false));
	$form = $form->add('mul_link3', 'text', array('required' => false));
	$form = $form->add('mul_link4', 'text', array('required' => false));
	$form = $form->add('mul_link5', 'text', array('required' => false));
	$form = $form->add('mul_link6', 'text', array('required' => false));
	$form = $form->add('mul_link7', 'text', array('required' => false));
	$form = $form->add('mul_link8', 'text', array('required' => false));
	$form = $form->add('mul_link9', 'text', array('required' => false));
	$form = $form->add('mul_link10', 'text', array('required' => false));
	$form = $form->add('mul_archivo1_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo2_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo3_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo4_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo5_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo6_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo7_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo8_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo9_desc', 'text', array('required' => false));
	$form = $form->add('mul_archivo10_desc', 'text', array('required' => false));
	$form = $form->add('mul_link1_desc', 'text', array('required' => false));
	$form = $form->add('mul_link2_desc', 'text', array('required' => false));
	$form = $form->add('mul_link3_desc', 'text', array('required' => false));
	$form = $form->add('mul_link4_desc', 'text', array('required' => false));
	$form = $form->add('mul_link5_desc', 'text', array('required' => false));
	$form = $form->add('mul_link6_desc', 'text', array('required' => false));
	$form = $form->add('mul_link7_desc', 'text', array('required' => false));
	$form = $form->add('mul_link8_desc', 'text', array('required' => false));
	$form = $form->add('mul_link9_desc', 'text', array('required' => false));
	$form = $form->add('mul_link10_desc', 'text', array('required' => false));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `multimedia` SET `mul_fecha` = ?, `mul_visible` = ?, `mul_tac_id` = ?, `mul_tem_id` = ?, `mul_titulo` = ?, `mul_foto1` = ?, `mul_copete` = ?, `mul_descripcion` = ?, `mul_archivo1` = ?, `mul_archivo2` = ?, `mul_archivo3` = ?, `mul_archivo4` = ?, `mul_archivo5` = ?, `mul_archivo6` = ?, `mul_archivo7` = ?, `mul_archivo8` = ?, `mul_archivo9` = ?, `mul_archivo10` = ?, `mul_link1` = ?, `mul_link2` = ?, `mul_link3` = ?, `mul_link4` = ?, `mul_link5` = ?, `mul_link6` = ?, `mul_link7` = ?, `mul_link8` = ?, `mul_link9` = ?, `mul_link10` = ?, `mul_archivo1_desc` = ?, `mul_archivo2_desc` = ?, `mul_archivo3_desc` = ?, `mul_archivo4_desc` = ?, `mul_archivo5_desc` = ?, `mul_archivo6_desc` = ?, `mul_archivo7_desc` = ?, `mul_archivo8_desc` = ?, `mul_archivo9_desc` = ?, `mul_archivo10_desc` = ?, `mul_link1_desc` = ?, `mul_link2_desc` = ?, `mul_link3_desc` = ?, `mul_link4_desc` = ?, `mul_link5_desc` = ?, `mul_link6_desc` = ?, `mul_link7_desc` = ?, `mul_link8_desc` = ?, `mul_link9_desc` = ?, `mul_link10_desc` = ? WHERE `mul_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['mul_fecha'], $data['mul_visible'], $data['mul_tac_id'], $data['mul_tem_id'], $data['mul_titulo'], $data['mul_foto1'], $data['mul_copete'], $data['mul_descripcion'], $data['mul_archivo1'], $data['mul_archivo2'], $data['mul_archivo3'], $data['mul_archivo4'], $data['mul_archivo5'], $data['mul_archivo6'], $data['mul_archivo7'], $data['mul_archivo8'], $data['mul_archivo9'], $data['mul_archivo10'], $data['mul_link1'], $data['mul_link2'], $data['mul_link3'], $data['mul_link4'], $data['mul_link5'], $data['mul_link6'], $data['mul_link7'], $data['mul_link8'], $data['mul_link9'], $data['mul_link10'], $data['mul_archivo1_desc'], $data['mul_archivo2_desc'], $data['mul_archivo3_desc'], $data['mul_archivo4_desc'], $data['mul_archivo5_desc'], $data['mul_archivo6_desc'], $data['mul_archivo7_desc'], $data['mul_archivo8_desc'], $data['mul_archivo9_desc'], $data['mul_archivo10_desc'], $data['mul_link1_desc'], $data['mul_link2_desc'], $data['mul_link3_desc'], $data['mul_link4_desc'], $data['mul_link5_desc'], $data['mul_link6_desc'], $data['mul_link7_desc'], $data['mul_link8_desc'], $data['mul_link9_desc'], $data['mul_link10_desc'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'multimedia edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('multimedia_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('multimedia/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('multimedia_edit');



$app->match('/multimedia/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `multimedia` WHERE `mul_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `multimedia` WHERE `mul_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'multimedia deleted!',
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

    return $app->redirect($app['url_generator']->generate('multimedia_list'));

})
->bind('multimedia_delete');






