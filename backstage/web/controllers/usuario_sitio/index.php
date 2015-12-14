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

$app->match('/usuario_sitio/list', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {  
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
		'usi_id', 
		'usi_legajo', 
		'usi_email', 
		'usi_clave', 
		'usi_nombre', 
		'usi_telefono', 
		'usi_activado', 
		'usi_celular', 
		'usi_cp', 
		'usi_dni', 
		'usi_direccion', 
		'usi_are_id', 
		'usi_dep_id', 
		'usi_dep_otro', 
		'usi_fuero_id', 
		'usi_car_id', 
		'usi_validado', 
		'usi_obligar_clave', 
		'usi_actualizar_datos', 
		'usi_cargo_otro', 
		'usi_area_otro', 
		'usi_fuero_otro', 
		'usi_genero', 
		'usi_fecha_nacimiento', 
		'usi_tel_particular', 
		'usi_fecha_alta', 
		'updated_at', 
		'created_at', 

    );
    
    $table_columns_type = array(
		'int(11)', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'char(2)', 
		'varchar(255)', 
		'varchar(10)', 
		'varchar(10)', 
		'text', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'int(11)', 
		'int(11)', 
		'char(2)', 
		'char(2)', 
		'int(11)', 
		'varchar(255)', 
		'varchar(255)', 
		'varchar(255)', 
		'int(11)', 
		'date', 
		'varchar(24)', 
		'datetime', 
		'timestamp', 
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
    
    $recordsTotal = $app['db']->executeQuery("SELECT * FROM `usuario_sitio`" . $whereClause . $orderClause)->rowCount();
    
    $find_sql = "SELECT * FROM `usuario_sitio`". $whereClause . $orderClause . " LIMIT ". $index . "," . $rowsPerPage;
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
$app->match('/usuario_sitio/download', function (Symfony\Component\HttpFoundation\Request $request) use ($app) { 
    
    // menu
    $rowid = $request->get('id');
    $idfldname = $request->get('idfld');
    $fieldname = $request->get('fldname');
    
    if( !$rowid || !$fieldname ) die("Invalid data");
    
    $find_sql = "SELECT " . $fieldname . " FROM " . usuario_sitio . " WHERE ".$idfldname." = ?";
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



$app->match('/usuario_sitio', function () use ($app) {
    
	$table_columns = array(
		'usi_id', 
		'usi_legajo', 
		'usi_email', 
		'usi_clave', 
		'usi_nombre', 
		'usi_telefono', 
		'usi_activado', 
		'usi_celular', 
		'usi_cp', 
		'usi_dni', 
		'usi_direccion', 
		'usi_are_id', 
		'usi_dep_id', 
		'usi_dep_otro', 
		'usi_fuero_id', 
		'usi_car_id', 
		'usi_validado', 
		'usi_obligar_clave', 
		'usi_actualizar_datos', 
		'usi_cargo_otro', 
		'usi_area_otro', 
		'usi_fuero_otro', 
		'usi_genero', 
		'usi_fecha_nacimiento', 
		'usi_tel_particular', 
		'usi_fecha_alta', 
		'updated_at', 
		'created_at', 

    );

    $primary_key = "usi_id";	

    return $app['twig']->render('usuario_sitio/list.html.twig', array(
    	"table_columns" => $table_columns,
        "primary_key" => $primary_key
    ));
        
})
->bind('usuario_sitio_list');



$app->match('/usuario_sitio/create', function () use ($app) {
    
    $initial_data = array(
		'usi_legajo' => '', 
		'usi_email' => '', 
		'usi_clave' => '', 
		'usi_nombre' => '', 
		'usi_telefono' => '', 
		'usi_activado' => '', 
		'usi_celular' => '', 
		'usi_cp' => '', 
		'usi_dni' => '', 
		'usi_direccion' => '', 
		'usi_are_id' => '', 
		'usi_dep_id' => '', 
		'usi_dep_otro' => '', 
		'usi_fuero_id' => '', 
		'usi_car_id' => '', 
		'usi_validado' => '', 
		'usi_obligar_clave' => '', 
		'usi_actualizar_datos' => '', 
		'usi_cargo_otro' => '', 
		'usi_area_otro' => '', 
		'usi_fuero_otro' => '', 
		'usi_genero' => '', 
		'usi_fecha_nacimiento' => '', 
		'usi_tel_particular' => '', 
		'usi_fecha_alta' => '', 
		'updated_at' => '', 
		'created_at' => '', 

    );

    $form = $app['form.factory']->createBuilder('form', $initial_data);



	$form = $form->add('usi_legajo', 'text', array('required' => true));
	$form = $form->add('usi_email', 'text', array('required' => true));
	$form = $form->add('usi_clave', 'text', array('required' => true));
	$form = $form->add('usi_nombre', 'text', array('required' => true));
	$form = $form->add('usi_telefono', 'text', array('required' => false));
	$form = $form->add('usi_activado', 'text', array('required' => true));
	$form = $form->add('usi_celular', 'text', array('required' => true));
	$form = $form->add('usi_cp', 'text', array('required' => true));
	$form = $form->add('usi_dni', 'text', array('required' => true));
	$form = $form->add('usi_direccion', 'textarea', array('required' => true));
	$form = $form->add('usi_are_id', 'text', array('required' => true));
	$form = $form->add('usi_dep_id', 'text', array('required' => true));
	$form = $form->add('usi_dep_otro', 'text', array('required' => true));
	$form = $form->add('usi_fuero_id', 'text', array('required' => true));
	$form = $form->add('usi_car_id', 'text', array('required' => true));
	$form = $form->add('usi_validado', 'text', array('required' => true));
	$form = $form->add('usi_obligar_clave', 'text', array('required' => true));
	$form = $form->add('usi_actualizar_datos', 'text', array('required' => true));
	$form = $form->add('usi_cargo_otro', 'text', array('required' => false));
	$form = $form->add('usi_area_otro', 'text', array('required' => false));
	$form = $form->add('usi_fuero_otro', 'text', array('required' => true));
	$form = $form->add('usi_genero', 'text', array('required' => true));
	$form = $form->add('usi_fecha_nacimiento', 'text', array('required' => true));
	$form = $form->add('usi_tel_particular', 'text', array('required' => true));
	$form = $form->add('usi_fecha_alta', 'text', array('required' => true));
	$form = $form->add('updated_at', 'text', array('required' => true));
	$form = $form->add('created_at', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "INSERT INTO `usuario_sitio` (`usi_legajo`, `usi_email`, `usi_clave`, `usi_nombre`, `usi_telefono`, `usi_activado`, `usi_celular`, `usi_cp`, `usi_dni`, `usi_direccion`, `usi_are_id`, `usi_dep_id`, `usi_dep_otro`, `usi_fuero_id`, `usi_car_id`, `usi_validado`, `usi_obligar_clave`, `usi_actualizar_datos`, `usi_cargo_otro`, `usi_area_otro`, `usi_fuero_otro`, `usi_genero`, `usi_fecha_nacimiento`, `usi_tel_particular`, `usi_fecha_alta`, `updated_at`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $app['db']->executeUpdate($update_query, array($data['usi_legajo'], $data['usi_email'], $data['usi_clave'], $data['usi_nombre'], $data['usi_telefono'], $data['usi_activado'], $data['usi_celular'], $data['usi_cp'], $data['usi_dni'], $data['usi_direccion'], $data['usi_are_id'], $data['usi_dep_id'], $data['usi_dep_otro'], $data['usi_fuero_id'], $data['usi_car_id'], $data['usi_validado'], $data['usi_obligar_clave'], $data['usi_actualizar_datos'], $data['usi_cargo_otro'], $data['usi_area_otro'], $data['usi_fuero_otro'], $data['usi_genero'], $data['usi_fecha_nacimiento'], $data['usi_tel_particular'], $data['usi_fecha_alta'], $data['updated_at'], $data['created_at']));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'usuario_sitio created!',
                )
            );
            return $app->redirect($app['url_generator']->generate('usuario_sitio_list'));

        }
    }

    return $app['twig']->render('usuario_sitio/create.html.twig', array(
        "form" => $form->createView()
    ));
        
})
->bind('usuario_sitio_create');



$app->match('/usuario_sitio/edit/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `usuario_sitio` WHERE `usi_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if(!$row_sql){
        $app['session']->getFlashBag()->add(
            'danger',
            array(
                'message' => 'Row not found!',
            )
        );        
        return $app->redirect($app['url_generator']->generate('usuario_sitio_list'));
    }

    
    $initial_data = array(
		'usi_legajo' => $row_sql['usi_legajo'], 
		'usi_email' => $row_sql['usi_email'], 
		'usi_clave' => $row_sql['usi_clave'], 
		'usi_nombre' => $row_sql['usi_nombre'], 
		'usi_telefono' => $row_sql['usi_telefono'], 
		'usi_activado' => $row_sql['usi_activado'], 
		'usi_celular' => $row_sql['usi_celular'], 
		'usi_cp' => $row_sql['usi_cp'], 
		'usi_dni' => $row_sql['usi_dni'], 
		'usi_direccion' => $row_sql['usi_direccion'], 
		'usi_are_id' => $row_sql['usi_are_id'], 
		'usi_dep_id' => $row_sql['usi_dep_id'], 
		'usi_dep_otro' => $row_sql['usi_dep_otro'], 
		'usi_fuero_id' => $row_sql['usi_fuero_id'], 
		'usi_car_id' => $row_sql['usi_car_id'], 
		'usi_validado' => $row_sql['usi_validado'], 
		'usi_obligar_clave' => $row_sql['usi_obligar_clave'], 
		'usi_actualizar_datos' => $row_sql['usi_actualizar_datos'], 
		'usi_cargo_otro' => $row_sql['usi_cargo_otro'], 
		'usi_area_otro' => $row_sql['usi_area_otro'], 
		'usi_fuero_otro' => $row_sql['usi_fuero_otro'], 
		'usi_genero' => $row_sql['usi_genero'], 
		'usi_fecha_nacimiento' => $row_sql['usi_fecha_nacimiento'], 
		'usi_tel_particular' => $row_sql['usi_tel_particular'], 
		'usi_fecha_alta' => $row_sql['usi_fecha_alta'], 
		'updated_at' => $row_sql['updated_at'], 
		'created_at' => $row_sql['created_at'], 

    );


    $form = $app['form.factory']->createBuilder('form', $initial_data);


	$form = $form->add('usi_legajo', 'text', array('required' => true));
	$form = $form->add('usi_email', 'text', array('required' => true));
	$form = $form->add('usi_clave', 'text', array('required' => true));
	$form = $form->add('usi_nombre', 'text', array('required' => true));
	$form = $form->add('usi_telefono', 'text', array('required' => false));
	$form = $form->add('usi_activado', 'text', array('required' => true));
	$form = $form->add('usi_celular', 'text', array('required' => true));
	$form = $form->add('usi_cp', 'text', array('required' => true));
	$form = $form->add('usi_dni', 'text', array('required' => true));
	$form = $form->add('usi_direccion', 'textarea', array('required' => true));
	$form = $form->add('usi_are_id', 'text', array('required' => true));
	$form = $form->add('usi_dep_id', 'text', array('required' => true));
	$form = $form->add('usi_dep_otro', 'text', array('required' => true));
	$form = $form->add('usi_fuero_id', 'text', array('required' => true));
	$form = $form->add('usi_car_id', 'text', array('required' => true));
	$form = $form->add('usi_validado', 'text', array('required' => true));
	$form = $form->add('usi_obligar_clave', 'text', array('required' => true));
	$form = $form->add('usi_actualizar_datos', 'text', array('required' => true));
	$form = $form->add('usi_cargo_otro', 'text', array('required' => false));
	$form = $form->add('usi_area_otro', 'text', array('required' => false));
	$form = $form->add('usi_fuero_otro', 'text', array('required' => true));
	$form = $form->add('usi_genero', 'text', array('required' => true));
	$form = $form->add('usi_fecha_nacimiento', 'text', array('required' => true));
	$form = $form->add('usi_tel_particular', 'text', array('required' => true));
	$form = $form->add('usi_fecha_alta', 'text', array('required' => true));
	$form = $form->add('updated_at', 'text', array('required' => true));
	$form = $form->add('created_at', 'text', array('required' => true));


    $form = $form->getForm();

    if("POST" == $app['request']->getMethod()){

        $form->handleRequest($app["request"]);

        if ($form->isValid()) {
            $data = $form->getData();

            $update_query = "UPDATE `usuario_sitio` SET `usi_legajo` = ?, `usi_email` = ?, `usi_clave` = ?, `usi_nombre` = ?, `usi_telefono` = ?, `usi_activado` = ?, `usi_celular` = ?, `usi_cp` = ?, `usi_dni` = ?, `usi_direccion` = ?, `usi_are_id` = ?, `usi_dep_id` = ?, `usi_dep_otro` = ?, `usi_fuero_id` = ?, `usi_car_id` = ?, `usi_validado` = ?, `usi_obligar_clave` = ?, `usi_actualizar_datos` = ?, `usi_cargo_otro` = ?, `usi_area_otro` = ?, `usi_fuero_otro` = ?, `usi_genero` = ?, `usi_fecha_nacimiento` = ?, `usi_tel_particular` = ?, `usi_fecha_alta` = ?, `updated_at` = ?, `created_at` = ? WHERE `usi_id` = ?";
            $app['db']->executeUpdate($update_query, array($data['usi_legajo'], $data['usi_email'], $data['usi_clave'], $data['usi_nombre'], $data['usi_telefono'], $data['usi_activado'], $data['usi_celular'], $data['usi_cp'], $data['usi_dni'], $data['usi_direccion'], $data['usi_are_id'], $data['usi_dep_id'], $data['usi_dep_otro'], $data['usi_fuero_id'], $data['usi_car_id'], $data['usi_validado'], $data['usi_obligar_clave'], $data['usi_actualizar_datos'], $data['usi_cargo_otro'], $data['usi_area_otro'], $data['usi_fuero_otro'], $data['usi_genero'], $data['usi_fecha_nacimiento'], $data['usi_tel_particular'], $data['usi_fecha_alta'], $data['updated_at'], $data['created_at'], $id));            


            $app['session']->getFlashBag()->add(
                'success',
                array(
                    'message' => 'usuario_sitio edited!',
                )
            );
            return $app->redirect($app['url_generator']->generate('usuario_sitio_edit', array("id" => $id)));

        }
    }

    return $app['twig']->render('usuario_sitio/edit.html.twig', array(
        "form" => $form->createView(),
        "id" => $id
    ));
        
})
->bind('usuario_sitio_edit');



$app->match('/usuario_sitio/delete/{id}', function ($id) use ($app) {

    $find_sql = "SELECT * FROM `usuario_sitio` WHERE `usi_id` = ?";
    $row_sql = $app['db']->fetchAssoc($find_sql, array($id));

    if($row_sql){
        $delete_query = "DELETE FROM `usuario_sitio` WHERE `usi_id` = ?";
        $app['db']->executeUpdate($delete_query, array($id));

        $app['session']->getFlashBag()->add(
            'success',
            array(
                'message' => 'usuario_sitio deleted!',
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

    return $app->redirect($app['url_generator']->generate('usuario_sitio_list'));

})
->bind('usuario_sitio_delete');






