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

$app->match('/beca/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'beca_id', 
		'nro_tramite', 
		'tipo_beca_id', 
		'alumno_id', 
		'estado_id', 
		'md5', 
		'domicilio_constituido', 
		'cargo_id', 
		'fuero_id', 
		'dependencia_id', 
		'universidad_id', 
		'universidad_otro', 
		'facultad_id', 
		'facultad_otro', 
		'titulo_id', 
		'titulo_otro', 
		'f_ingreso_caba', 
		'telefono_laboral', 
		'institucion_propuesta', 
		'tipo_actividad_id', 
		'actividad_nombre', 
		'fecha_inicio', 
		'fecha_fin', 
		'duracion', 
		'costo', 
		'monto', 
		'dictamen_por', 
		'sup_horaria', 
		'renovacion_id', 
		'observaciones', 
		'objetivo', 
		'vinculacion', 
		'timestamp', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'int(11)', 
		'varchar(255)', 
		'int(11)', 
		'varchar(255)', 
		'date', 
		'varchar(12)', 
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'date', 
		'date', 
		'int(11)', 
		'decimal(10,2)', 
		'decimal(10,2)', 
		'varchar(255)', 
		'int(11)', 
		'int(11)', 
		'text', 
		'text', 
		'text', 
		'timestamp', 

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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `beca`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `beca`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
    $rows_sql = $app['db']->fetchAll($find_sql, array());

    foreach($rows_sql as $row_key => $row_sql){
        for($i = 0; $i < count($table_columns); $i++){

			if($table_columns[$i] == 'cargo_id'){
			    $findexternal_sql = 'SELECT `car_id` FROM `cargo` WHERE `car_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['car_id'];
			}
			else if($table_columns[$i] == 'fuero_id'){
			    $findexternal_sql = 'SELECT `fuero_id` FROM `fuero` WHERE `fuero_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['fuero_id'];
			}
			else if($table_columns[$i] == 'dependencia_id'){
			    $findexternal_sql = 'SELECT `dep_id` FROM `dependencia` WHERE `dep_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['dep_id'];
			}
			else if($table_columns[$i] == 'universidad_id'){
			    $findexternal_sql = 'SELECT `universidad_id` FROM `universidad` WHERE `universidad_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['universidad_id'];
			}
			else if($table_columns[$i] == 'facultad_id'){
			    $findexternal_sql = 'SELECT `facultad_id` FROM `facultad` WHERE `facultad_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['facultad_id'];
			}
			else if($table_columns[$i] == 'titulo_id'){
			    $findexternal_sql = 'SELECT `titulo_id` FROM `titulo` WHERE `titulo_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['titulo_id'];
			}
			else if($table_columns[$i] == 'tipo_actividad_id'){
			    $findexternal_sql = 'SELECT `tac_id` FROM `tipo_actividad` WHERE `tac_id` = ?';
			    $findexternal_row = $app['db']->fetchAssoc($findexternal_sql, array($row_sql[$table_columns[$i]]));
			    $rows[$row_key][$table_columns[$i]] = $findexternal_row['tac_id'];
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
$app->match('/beca/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . beca . " WHERE ".$idfldname." = ?";
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



$app->match('/beca', function () use ($app) {
    
	$table_columns = array(
		'beca_id', 
		'nro_tramite', 
		'tipo_beca_id', 
		'alumno_id', 
		'estado_id', 
		'md5', 
		'domicilio_constituido', 
		'cargo_id', 
		'fuero_id', 
		'dependencia_id', 
		'universidad_id', 
		'universidad_otro', 
		'facultad_id', 
		'facultad_otro', 
		'titulo_id', 
		'titulo_otro', 
		'f_ingreso_caba', 
		'telefono_laboral', 
		'institucion_propuesta', 
		'tipo_actividad_id', 
		'actividad_nombre', 
		'fecha_inicio', 
		'fecha_fin', 
		'duracion', 
		'costo', 
		'monto', 
		'dictamen_por', 
		'sup_horaria', 
		'renovacion_id', 
		'observaciones', 
		'objetivo', 
		'vinculacion', 
		'timestamp', 

    );

    $primary_key = "beca_id";	

    return $app['twig']->render('beca/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('beca_list');



$app->match('/beca/create', function () use ($app) {
    
    $initial_data = array(
		'nro_tramite' => '', 
		'tipo_beca_id' => '', 
		'alumno_id' => '', 
		'estado_id' => '', 
		'md5' => '', 
		'domicilio_constituido' => '', 
		'cargo_id' => '', 
		'fuero_id' => '', 
		'dependencia_id' => '', 
		'universidad_id' => '', 
		'universidad_otro' => '', 
		'facultad_id' => '', 
		'facultad_otro' => '', 
		'titulo_id' => '', 
		'titulo_otro' => '', 
		'f_ingreso_caba' => '', 
		'telefono_laboral' => '', 
		'institucion_propuesta' => '', 
		'tipo_actividad_id' => '', 
		'actividad_nombre' => '', 
		'fecha_inicio' => '', 
		'fecha_fin' => '', 
		'duracion' => '', 
		'costo' => '', 
		'monto' => '', 
		'dictamen_por' => '', 
		'sup_horaria' => '', 
		'renovacion_id' => '', 
		'observaciones' => '', 
		'objetivo' => '', 
		'vinculacion' => '', 
		'timestamp' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$options = array();
	$findexternal_sql = 'SELECT `car_id`, `car_id` FROM `cargo`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['car_id']] = $findexternal_row['car_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('cargo_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('cargo_id', 'text', array('required' => true));
	}

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

	$options = array();
	$findexternal_sql = 'SELECT `dep_id`, `dep_id` FROM `dependencia`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['dep_id']] = $findexternal_row['dep_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('dependencia_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('dependencia_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `universidad_id`, `universidad_id` FROM `universidad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['universidad_id']] = $findexternal_row['universidad_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('universidad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('universidad_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `facultad_id`, `facultad_id` FROM `facultad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['facultad_id']] = $findexternal_row['facultad_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('facultad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('facultad_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `titulo_id`, `titulo_id` FROM `titulo`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['titulo_id']] = $findexternal_row['titulo_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('titulo_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('titulo_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `tac_id`, `tac_id` FROM `tipo_actividad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['tac_id']] = $findexternal_row['tac_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('tipo_actividad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('tipo_actividad_id', 'text', array('required' => true));
	}



	$form = $form->add('nro_tramite', 'text', array('required' => true));
	$form = $form->add('tipo_beca_id', 'text', array('required' => true));
	$form = $form->add('alumno_id', 'text', array('required' => true));
	$form = $form->add('estado_id', 'text', array('required' => true));
	$form = $form->add('md5', 'text', array('required' => true));
	$form = $form->add('domicilio_constituido', 'text', array('required' => true));
	$form = $form->add('universidad_otro', 'text', array('required' => true));
	$form = $form->add('facultad_otro', 'text', array('required' => true));
	$form = $form->add('titulo_otro', 'text', array('required' => true));
	$form = $form->add('f_ingreso_caba', 'text', array('required' => true));
	$form = $form->add('telefono_laboral', 'text', array('required' => true));
	$form = $form->add('institucion_propuesta', 'text', array('required' => true));
	$form = $form->add('actividad_nombre', 'text', array('required' => true));
	$form = $form->add('fecha_inicio', 'text', array('required' => true));
	$form = $form->add('fecha_fin', 'text', array('required' => true));
	$form = $form->add('duracion', 'text', array('required' => true));
	$form = $form->add('costo', 'text', array('required' => true));
	$form = $form->add('monto', 'text', array('required' => true));
	$form = $form->add('dictamen_por', 'text', array('required' => true));
	$form = $form->add('sup_horaria', 'text', array('required' => true));
	$form = $form->add('renovacion_id', 'text', array('required' => true));
	$form = $form->add('observaciones', 'textarea', array('required' => true));
	$form = $form->add('objetivo', 'textarea', array('required' => true));
	$form = $form->add('vinculacion', 'textarea', array('required' => true));
	$form = $form->add('timestamp', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `beca` (`nro_tramite`, `tipo_beca_id`, `alumno_id`, `estado_id`, `md5`, `domicilio_constituido`, `cargo_id`, `fuero_id`, `dependencia_id`, `universidad_id`, `universidad_otro`, `facultad_id`, `facultad_otro`, `titulo_id`, `titulo_otro`, `f_ingreso_caba`, `telefono_laboral`, `institucion_propuesta`, `tipo_actividad_id`, `actividad_nombre`, `fecha_inicio`, `fecha_fin`, `duracion`, `costo`, `monto`, `dictamen_por`, `sup_horaria`, `renovacion_id`, `observaciones`, `objetivo`, `vinculacion`, `timestamp`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['nro_tramite'], $data['tipo_beca_id'], $data['alumno_id'], $data['estado_id'], $data['md5'], $data['domicilio_constituido'], $data['cargo_id'], $data['fuero_id'], $data['dependencia_id'], $data['universidad_id'], $data['universidad_otro'], $data['facultad_id'], $data['facultad_otro'], $data['titulo_id'], $data['titulo_otro'], $data['f_ingreso_caba'], $data['telefono_laboral'], $data['institucion_propuesta'], $data['tipo_actividad_id'], $data['actividad_nombre'], $data['fecha_inicio'], $data['fecha_fin'], $data['duracion'], $data['costo'], $data['monto'], $data['dictamen_por'], $data['sup_horaria'], $data['renovacion_id'], $data['observaciones'], $data['objetivo'], $data['vinculacion'], $data['timestamp']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'beca created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('beca_list'));

        }
    }

    return $app['twig']->render('beca/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('beca_create');



$app->match('/beca/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `beca` WHERE `beca_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('beca_list'));
    }

    
    $initial_data = array(
		'nro_tramite' => $row_sql['nro_tramite'], 
		'tipo_beca_id' => $row_sql['tipo_beca_id'], 
		'alumno_id' => $row_sql['alumno_id'], 
		'estado_id' => $row_sql['estado_id'], 
		'md5' => $row_sql['md5'], 
		'domicilio_constituido' => $row_sql['domicilio_constituido'], 
		'cargo_id' => $row_sql['cargo_id'], 
		'fuero_id' => $row_sql['fuero_id'], 
		'dependencia_id' => $row_sql['dependencia_id'], 
		'universidad_id' => $row_sql['universidad_id'], 
		'universidad_otro' => $row_sql['universidad_otro'], 
		'facultad_id' => $row_sql['facultad_id'], 
		'facultad_otro' => $row_sql['facultad_otro'], 
		'titulo_id' => $row_sql['titulo_id'], 
		'titulo_otro' => $row_sql['titulo_otro'], 
		'f_ingreso_caba' => $row_sql['f_ingreso_caba'], 
		'telefono_laboral' => $row_sql['telefono_laboral'], 
		'institucion_propuesta' => $row_sql['institucion_propuesta'], 
		'tipo_actividad_id' => $row_sql['tipo_actividad_id'], 
		'actividad_nombre' => $row_sql['actividad_nombre'], 
		'fecha_inicio' => $row_sql['fecha_inicio'], 
		'fecha_fin' => $row_sql['fecha_fin'], 
		'duracion' => $row_sql['duracion'], 
		'costo' => $row_sql['costo'], 
		'monto' => $row_sql['monto'], 
		'dictamen_por' => $row_sql['dictamen_por'], 
		'sup_horaria' => $row_sql['sup_horaria'], 
		'renovacion_id' => $row_sql['renovacion_id'], 
		'observaciones' => $row_sql['observaciones'], 
		'objetivo' => $row_sql['objetivo'], 
		'vinculacion' => $row_sql['vinculacion'], 
		'timestamp' => $row_sql['timestamp'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);

	$options = array();
	$findexternal_sql = 'SELECT `car_id`, `car_id` FROM `cargo`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['car_id']] = $findexternal_row['car_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('cargo_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('cargo_id', 'text', array('required' => true));
	}

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

	$options = array();
	$findexternal_sql = 'SELECT `dep_id`, `dep_id` FROM `dependencia`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['dep_id']] = $findexternal_row['dep_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('dependencia_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('dependencia_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `universidad_id`, `universidad_id` FROM `universidad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['universidad_id']] = $findexternal_row['universidad_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('universidad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('universidad_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `facultad_id`, `facultad_id` FROM `facultad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['facultad_id']] = $findexternal_row['facultad_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('facultad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('facultad_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `titulo_id`, `titulo_id` FROM `titulo`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['titulo_id']] = $findexternal_row['titulo_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('titulo_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('titulo_id', 'text', array('required' => true));
	}

	$options = array();
	$findexternal_sql = 'SELECT `tac_id`, `tac_id` FROM `tipo_actividad`';
	$findexternal_rows = $app['db']->fetchAll($findexternal_sql, array());
	foreach($findexternal_rows as $findexternal_row){
	    $options[$findexternal_row['tac_id']] = $findexternal_row['tac_id'];
	}
	if(count($options) > 0){
	    $form = $form->add('tipo_actividad_id', 'choice', array(
	        'required' => true,
	        'choices' => $options,
	        'expanded' => false,
	        'constraints' => new Assert\Choice(array_keys($options))
	    ));
	}
	else{
	    $form = $form->add('tipo_actividad_id', 'text', array('required' => true));
	}


	$form = $form->add('nro_tramite', 'text', array('required' => true));
	$form = $form->add('tipo_beca_id', 'text', array('required' => true));
	$form = $form->add('alumno_id', 'text', array('required' => true));
	$form = $form->add('estado_id', 'text', array('required' => true));
	$form = $form->add('md5', 'text', array('required' => true));
	$form = $form->add('domicilio_constituido', 'text', array('required' => true));
	$form = $form->add('universidad_otro', 'text', array('required' => true));
	$form = $form->add('facultad_otro', 'text', array('required' => true));
	$form = $form->add('titulo_otro', 'text', array('required' => true));
	$form = $form->add('f_ingreso_caba', 'text', array('required' => true));
	$form = $form->add('telefono_laboral', 'text', array('required' => true));
	$form = $form->add('institucion_propuesta', 'text', array('required' => true));
	$form = $form->add('actividad_nombre', 'text', array('required' => true));
	$form = $form->add('fecha_inicio', 'text', array('required' => true));
	$form = $form->add('fecha_fin', 'text', array('required' => true));
	$form = $form->add('duracion', 'text', array('required' => true));
	$form = $form->add('costo', 'text', array('required' => true));
	$form = $form->add('monto', 'text', array('required' => true));
	$form = $form->add('dictamen_por', 'text', array('required' => true));
	$form = $form->add('sup_horaria', 'text', array('required' => true));
	$form = $form->add('renovacion_id', 'text', array('required' => true));
	$form = $form->add('observaciones', 'textarea', array('required' => true));
	$form = $form->add('objetivo', 'textarea', array('required' => true));
	$form = $form->add('vinculacion', 'textarea', array('required' => true));
	$form = $form->add('timestamp', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `beca` SET `nro_tramite` = ?, `tipo_beca_id` = ?, `alumno_id` = ?, `estado_id` = ?, `md5` = ?, `domicilio_constituido` = ?, `cargo_id` = ?, `fuero_id` = ?, `dependencia_id` = ?, `universidad_id` = ?, `universidad_otro` = ?, `facultad_id` = ?, `facultad_otro` = ?, `titulo_id` = ?, `titulo_otro` = ?, `f_ingreso_caba` = ?, `telefono_laboral` = ?, `institucion_propuesta` = ?, `tipo_actividad_id` = ?, `actividad_nombre` = ?, `fecha_inicio` = ?, `fecha_fin` = ?, `duracion` = ?, `costo` = ?, `monto` = ?, `dictamen_por` = ?, `sup_horaria` = ?, `renovacion_id` = ?, `observaciones` = ?, `objetivo` = ?, `vinculacion` = ?, `timestamp` = ? WHERE `beca_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['nro_tramite'], $data['tipo_beca_id'], $data['alumno_id'], $data['estado_id'], $data['md5'], $data['domicilio_constituido'], $data['cargo_id'], $data['fuero_id'], $data['dependencia_id'], $data['universidad_id'], $data['universidad_otro'], $data['facultad_id'], $data['facultad_otro'], $data['titulo_id'], $data['titulo_otro'], $data['f_ingreso_caba'], $data['telefono_laboral'], $data['institucion_propuesta'], $data['tipo_actividad_id'], $data['actividad_nombre'], $data['fecha_inicio'], $data['fecha_fin'], $data['duracion'], $data['costo'], $data['monto'], $data['dictamen_por'], $data['sup_horaria'], $data['renovacion_id'], $data['observaciones'], $data['objetivo'], $data['vinculacion'], $data['timestamp'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'beca edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('beca_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('beca/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('beca_edit');



$app->match('/beca/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `beca` WHERE `beca_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `beca` WHERE `beca_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'beca deleted!',
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

    return $app->redirect($app['url_generator']->generate('beca_list'));

})
->bind('beca_delete');






