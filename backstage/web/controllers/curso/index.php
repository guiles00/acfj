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

$app->match('/curso/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'cur_id', 
		'cur_gcu3_id', 
		'cur_fechaInicio', 
		'cur_fechaFin', 
		'cur_titulo', 
		'cur_mostrarWeb', 
		'cur_tcu_id', 
		'cur_resolucion', 
		'cur_anexo', 
		'cur_mostrarPreinscripcion', 
		'cur_imagen', 
		'cur_descripcion', 
		'cur_dirigido', 
		'cur_vacantes', 
		'cur_regimen_aprobacion', 
		'cur_doc_id_director', 
		'cur_doc_id_coordinador', 
		'cur_observaciones', 
		'cur_fecha', 
		'cur_duracion', 
		'cur_doc_id_moderador', 
		'cur_esDestacado', 
		'cur_destinatario', 
		'cur_horarios', 
		'cur_ecu_id', 
		'cur_forzarCalendario', 
		'cur_certificado', 
		'cur_mostrarVacantesCubiertas', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'date', 
		'date', 
		'varchar(255)', 
		'char(2)', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'char(2)', 
		'varchar(255)', 
		'text', 
		'varchar(255)', 
		'int(11)', 
		'char(2)', 
		'int(11)', 
		'int(11)', 
		'text', 
		'varchar(255)', 
		'varchar(255)', 
		'int(11)', 
		'char(2)', 
		'text', 
		'varchar(255)', 
		'int(11)', 
		'char(2)', 
		'char(2)', 
		'char(2)', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `curso`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `curso`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/curso/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . curso . " WHERE ".$idfldname." = ?";
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



$app->match('/curso', function () use ($app) {
    
	$table_columns = array(
		'cur_id', 
		'cur_gcu3_id', 
		'cur_fechaInicio', 
		'cur_fechaFin', 
		'cur_titulo', 
		'cur_mostrarWeb', 
		'cur_tcu_id', 
		'cur_resolucion', 
		'cur_anexo', 
		'cur_mostrarPreinscripcion', 
		'cur_imagen', 
		'cur_descripcion', 
		'cur_dirigido', 
		'cur_vacantes', 
		'cur_regimen_aprobacion', 
		'cur_doc_id_director', 
		'cur_doc_id_coordinador', 
		'cur_observaciones', 
		'cur_fecha', 
		'cur_duracion', 
		'cur_doc_id_moderador', 
		'cur_esDestacado', 
		'cur_destinatario', 
		'cur_horarios', 
		'cur_ecu_id', 
		'cur_forzarCalendario', 
		'cur_certificado', 
		'cur_mostrarVacantesCubiertas', 

    );

    $primary_key = "cur_id";	

    return $app['twig']->render('curso/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('curso_list');



$app->match('/curso/create', function () use ($app) {
    
    $initial_data = array(
		'cur_gcu3_id' => '', 
		'cur_fechaInicio' => '', 
		'cur_fechaFin' => '', 
		'cur_titulo' => '', 
		'cur_mostrarWeb' => '', 
		'cur_tcu_id' => '', 
		'cur_resolucion' => '', 
		'cur_anexo' => '', 
		'cur_mostrarPreinscripcion' => '', 
		'cur_imagen' => '', 
		'cur_descripcion' => '', 
		'cur_dirigido' => '', 
		'cur_vacantes' => '', 
		'cur_regimen_aprobacion' => '', 
		'cur_doc_id_director' => '', 
		'cur_doc_id_coordinador' => '', 
		'cur_observaciones' => '', 
		'cur_fecha' => '', 
		'cur_duracion' => '', 
		'cur_doc_id_moderador' => '', 
		'cur_esDestacado' => '', 
		'cur_destinatario' => '', 
		'cur_horarios' => '', 
		'cur_ecu_id' => '', 
		'cur_forzarCalendario' => '', 
		'cur_certificado' => '', 
		'cur_mostrarVacantesCubiertas' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('cur_gcu3_id', 'text', array('required' => true));
	$form = $form->add('cur_fechaInicio', 'text', array('required' => true));
	$form = $form->add('cur_fechaFin', 'text', array('required' => true));
	$form = $form->add('cur_titulo', 'text', array('required' => true));
	$form = $form->add('cur_mostrarWeb', 'text', array('required' => true));
	$form = $form->add('cur_tcu_id', 'text', array('required' => false));
	$form = $form->add('cur_resolucion', 'text', array('required' => false));
	$form = $form->add('cur_anexo', 'text', array('required' => false));
	$form = $form->add('cur_mostrarPreinscripcion', 'text', array('required' => true));
	$form = $form->add('cur_imagen', 'text', array('required' => false));
	$form = $form->add('cur_descripcion', 'textarea', array('required' => false));
	$form = $form->add('cur_dirigido', 'text', array('required' => false));
	$form = $form->add('cur_vacantes', 'text', array('required' => false));
	$form = $form->add('cur_regimen_aprobacion', 'text', array('required' => true));
	$form = $form->add('cur_doc_id_director', 'text', array('required' => false));
	$form = $form->add('cur_doc_id_coordinador', 'text', array('required' => false));
	$form = $form->add('cur_observaciones', 'textarea', array('required' => false));
	$form = $form->add('cur_fecha', 'text', array('required' => false));
	$form = $form->add('cur_duracion', 'text', array('required' => false));
	$form = $form->add('cur_doc_id_moderador', 'text', array('required' => false));
	$form = $form->add('cur_esDestacado', 'text', array('required' => true));
	$form = $form->add('cur_destinatario', 'textarea', array('required' => false));
	$form = $form->add('cur_horarios', 'text', array('required' => false));
	$form = $form->add('cur_ecu_id', 'text', array('required' => true));
	$form = $form->add('cur_forzarCalendario', 'text', array('required' => true));
	$form = $form->add('cur_certificado', 'text', array('required' => true));
	$form = $form->add('cur_mostrarVacantesCubiertas', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `curso` (`cur_gcu3_id`, `cur_fechaInicio`, `cur_fechaFin`, `cur_titulo`, `cur_mostrarWeb`, `cur_tcu_id`, `cur_resolucion`, `cur_anexo`, `cur_mostrarPreinscripcion`, `cur_imagen`, `cur_descripcion`, `cur_dirigido`, `cur_vacantes`, `cur_regimen_aprobacion`, `cur_doc_id_director`, `cur_doc_id_coordinador`, `cur_observaciones`, `cur_fecha`, `cur_duracion`, `cur_doc_id_moderador`, `cur_esDestacado`, `cur_destinatario`, `cur_horarios`, `cur_ecu_id`, `cur_forzarCalendario`, `cur_certificado`, `cur_mostrarVacantesCubiertas`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['cur_gcu3_id'], $data['cur_fechaInicio'], $data['cur_fechaFin'], $data['cur_titulo'], $data['cur_mostrarWeb'], $data['cur_tcu_id'], $data['cur_resolucion'], $data['cur_anexo'], $data['cur_mostrarPreinscripcion'], $data['cur_imagen'], $data['cur_descripcion'], $data['cur_dirigido'], $data['cur_vacantes'], $data['cur_regimen_aprobacion'], $data['cur_doc_id_director'], $data['cur_doc_id_coordinador'], $data['cur_observaciones'], $data['cur_fecha'], $data['cur_duracion'], $data['cur_doc_id_moderador'], $data['cur_esDestacado'], $data['cur_destinatario'], $data['cur_horarios'], $data['cur_ecu_id'], $data['cur_forzarCalendario'], $data['cur_certificado'], $data['cur_mostrarVacantesCubiertas']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'curso created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('curso_list'));

        }
    }

    return $app['twig']->render('curso/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('curso_create');



$app->match('/curso/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `curso` WHERE `cur_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('curso_list'));
    }

    
    $initial_data = array(
		'cur_gcu3_id' => $row_sql['cur_gcu3_id'], 
		'cur_fechaInicio' => $row_sql['cur_fechaInicio'], 
		'cur_fechaFin' => $row_sql['cur_fechaFin'], 
		'cur_titulo' => $row_sql['cur_titulo'], 
		'cur_mostrarWeb' => $row_sql['cur_mostrarWeb'], 
		'cur_tcu_id' => $row_sql['cur_tcu_id'], 
		'cur_resolucion' => $row_sql['cur_resolucion'], 
		'cur_anexo' => $row_sql['cur_anexo'], 
		'cur_mostrarPreinscripcion' => $row_sql['cur_mostrarPreinscripcion'], 
		'cur_imagen' => $row_sql['cur_imagen'], 
		'cur_descripcion' => $row_sql['cur_descripcion'], 
		'cur_dirigido' => $row_sql['cur_dirigido'], 
		'cur_vacantes' => $row_sql['cur_vacantes'], 
		'cur_regimen_aprobacion' => $row_sql['cur_regimen_aprobacion'], 
		'cur_doc_id_director' => $row_sql['cur_doc_id_director'], 
		'cur_doc_id_coordinador' => $row_sql['cur_doc_id_coordinador'], 
		'cur_observaciones' => $row_sql['cur_observaciones'], 
		'cur_fecha' => $row_sql['cur_fecha'], 
		'cur_duracion' => $row_sql['cur_duracion'], 
		'cur_doc_id_moderador' => $row_sql['cur_doc_id_moderador'], 
		'cur_esDestacado' => $row_sql['cur_esDestacado'], 
		'cur_destinatario' => $row_sql['cur_destinatario'], 
		'cur_horarios' => $row_sql['cur_horarios'], 
		'cur_ecu_id' => $row_sql['cur_ecu_id'], 
		'cur_forzarCalendario' => $row_sql['cur_forzarCalendario'], 
		'cur_certificado' => $row_sql['cur_certificado'], 
		'cur_mostrarVacantesCubiertas' => $row_sql['cur_mostrarVacantesCubiertas'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('cur_gcu3_id', 'text', array('required' => true));
	$form = $form->add('cur_fechaInicio', 'text', array('required' => true));
	$form = $form->add('cur_fechaFin', 'text', array('required' => true));
	$form = $form->add('cur_titulo', 'text', array('required' => true));
	$form = $form->add('cur_mostrarWeb', 'text', array('required' => true));
	$form = $form->add('cur_tcu_id', 'text', array('required' => false));
	$form = $form->add('cur_resolucion', 'text', array('required' => false));
	$form = $form->add('cur_anexo', 'text', array('required' => false));
	$form = $form->add('cur_mostrarPreinscripcion', 'text', array('required' => true));
	$form = $form->add('cur_imagen', 'text', array('required' => false));
	$form = $form->add('cur_descripcion', 'textarea', array('required' => false));
	$form = $form->add('cur_dirigido', 'text', array('required' => false));
	$form = $form->add('cur_vacantes', 'text', array('required' => false));
	$form = $form->add('cur_regimen_aprobacion', 'text', array('required' => true));
	$form = $form->add('cur_doc_id_director', 'text', array('required' => false));
	$form = $form->add('cur_doc_id_coordinador', 'text', array('required' => false));
	$form = $form->add('cur_observaciones', 'textarea', array('required' => false));
	$form = $form->add('cur_fecha', 'text', array('required' => false));
	$form = $form->add('cur_duracion', 'text', array('required' => false));
	$form = $form->add('cur_doc_id_moderador', 'text', array('required' => false));
	$form = $form->add('cur_esDestacado', 'text', array('required' => true));
	$form = $form->add('cur_destinatario', 'textarea', array('required' => false));
	$form = $form->add('cur_horarios', 'text', array('required' => false));
	$form = $form->add('cur_ecu_id', 'text', array('required' => true));
	$form = $form->add('cur_forzarCalendario', 'text', array('required' => true));
	$form = $form->add('cur_certificado', 'text', array('required' => true));
	$form = $form->add('cur_mostrarVacantesCubiertas', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `curso` SET `cur_gcu3_id` = ?, `cur_fechaInicio` = ?, `cur_fechaFin` = ?, `cur_titulo` = ?, `cur_mostrarWeb` = ?, `cur_tcu_id` = ?, `cur_resolucion` = ?, `cur_anexo` = ?, `cur_mostrarPreinscripcion` = ?, `cur_imagen` = ?, `cur_descripcion` = ?, `cur_dirigido` = ?, `cur_vacantes` = ?, `cur_regimen_aprobacion` = ?, `cur_doc_id_director` = ?, `cur_doc_id_coordinador` = ?, `cur_observaciones` = ?, `cur_fecha` = ?, `cur_duracion` = ?, `cur_doc_id_moderador` = ?, `cur_esDestacado` = ?, `cur_destinatario` = ?, `cur_horarios` = ?, `cur_ecu_id` = ?, `cur_forzarCalendario` = ?, `cur_certificado` = ?, `cur_mostrarVacantesCubiertas` = ? WHERE `cur_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['cur_gcu3_id'], $data['cur_fechaInicio'], $data['cur_fechaFin'], $data['cur_titulo'], $data['cur_mostrarWeb'], $data['cur_tcu_id'], $data['cur_resolucion'], $data['cur_anexo'], $data['cur_mostrarPreinscripcion'], $data['cur_imagen'], $data['cur_descripcion'], $data['cur_dirigido'], $data['cur_vacantes'], $data['cur_regimen_aprobacion'], $data['cur_doc_id_director'], $data['cur_doc_id_coordinador'], $data['cur_observaciones'], $data['cur_fecha'], $data['cur_duracion'], $data['cur_doc_id_moderador'], $data['cur_esDestacado'], $data['cur_destinatario'], $data['cur_horarios'], $data['cur_ecu_id'], $data['cur_forzarCalendario'], $data['cur_certificado'], $data['cur_mostrarVacantesCubiertas'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'curso edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('curso_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('curso/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('curso_edit');



$app->match('/curso/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `curso` WHERE `cur_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `curso` WHERE `cur_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'curso deleted!',
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

    return $app->redirect($app['url_generator']->generate('curso_list'));

})
->bind('curso_delete');






