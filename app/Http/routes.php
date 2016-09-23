<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'WelcomeController@index');

Route::group(['middleware' => 'session_expired'], function () {
Route::get('bienvenido', 'WelcomeController@welcome');
});

Route::post('login', 'WelcomeController@doLogin');
Route::get('logout', 'WelcomeController@doLogout');

Route::get('cambiarClave', 'WelcomeController@cambiarClave');
Route::post('updatePassword', 'WelcomeController@updatePassword');
Route::get('home', 'HomeController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*Route::get('error',function()
{
	abort(500);
	return "bar";
});
*/
//Route::get('/', function()
//{
//    return 'Hello World';
//});

//Route::resource('alumnos', 'AlumnosController');

//Route::get('about','AlumnosController@about');
//Route::get('tasks','TasksController@list');
//Route::get('tasks','TasksController@lista');
//Route::get('accion','TasksController@accion');
//Route::get('crea','TasksController@create');



Route::group(['middleware' => 'session_expired'], function () {

	Route::get('becas','BecaController@index');
	Route::get('listBecas','BecaController@listBecas');
	Route::get('becas/{id}','DwarfController@show');
	Route::post('becas','DwarfController@store');

	Route::get('d3','D3Controller@index');
});

Route::group(['middleware' => 'session_expired'], function () {

	Route::get('tablero','TableroController@index');
	Route::get('tablero/estadisticas','TableroController@estadisticasCurso');
	Route::get('cargocurso/{x}/{y}','TableroController@traeCargoCurso');
	Route::get('tablero/estadisticas/{x}','TableroController@estadisticasCurso');
	Route::get('pendientes','AlumnosController@pendientes');
	Route::get('curso-fecha','TableroController@cursoFecha');
	Route::get('inscriptos-curso','TableroController@inscriptosCurso');


	Route::get('curso-cargo/{x}','TableroController@cursoCargo');
	Route::get('ajaxget','AlumnosController@ajaxget');


	Route::get('categorias','TableroController@categorias');
	Route::get('area','TableroController@area');
	Route::get('grupo','TableroController@grupo');
	Route::get('resarea','TableroController@resarea');
	Route::get('listadoCursos','TableroController@listadoCursos');
	Route::get('listadoGrupoDosCursos','TableroController@listadoGrupoDosCursos');
	Route::get('alumnosCurso','TableroController@alumnosCurso');
	Route::get('listCursos','TableroController@listCursos');
	Route::get('fichaCurso','TableroController@fichaCurso');
	Route::get('mgrupo','TableroController@mgrupo');

});

/*Solicitudes*/

Route::group(['middleware' => 'session_expired'], function () {

	Route::resource('listSolicitudesBecas', 'BecaController@index');
	Route::get('busquedaAvanzada', 'BecaController@busquedaAvanzada');


	Route::get('verSolicitud/{id}', 'BecaController@verSolicitud');
	Route::get('imprimirSolicitud/{id}', 'BecaController@imprimirSolicitud');
	Route::get('verDocAdjunta/{id}', 'BecaController@verDocAdjunta');
	Route::post('saveBeca', 'BecaController@save');
	Route::get('exportar', 'BecaController@exportar');
	Route::get('enviarEmailDocumentacion', 'BecaController@enviarEmailDocumentacion');
	Route::get('previewEmailDocumentacion', 'BecaController@previewEmailDocumentacion');

	Route::post('saveActuacion', 'BecaController@saveActuacion');
	Route::get('addActuacion/{id}', 'BecaController@addActuacion');
	Route::get('eliminarVinculoActuacion/{id}', 'BecaController@eliminarVinculoActuacion');

	Route::get('addPasoBeca/{id}', 'BecaController@addPasoBeca');
	Route::post('savePasoBeca', 'BecaController@savePasoBeca');
	Route::get('deletePasoBeca/{id}', 'BecaController@deletePasoBeca');
	Route::get('editPasoBeca/{id}', 'BecaController@editPasoBeca');
	Route::post('updatePasoBeca/{id}', 'BecaController@updatePasoBeca');
	Route::get('otorgarBeca/{id}', 'BecaController@otorgarBeca');


});

Route::group(['middleware' => 'session_expired'], function () {

	Route::get('listadoBecas', 'BecaOtorgadaController@listadoBecas');
	Route::get('verBecaOtorgada/{id}', 'BecaOtorgadaController@verBecaOtorgada');
	Route::post('saveBecaOtorgada', 'BecaOtorgadaController@save');
	Route::get('addActuacionOtorgada/{id}', 'BecaOtorgadaController@addActuacion');
	Route::post('saveActuacionOtorgada', 'BecaOtorgadaController@saveActuacion');
	Route::get('addPasoBecaOtorgada/{id}', 'BecaOtorgadaController@addPasoBeca');
	Route::get('busquedaAvanzada', 'BecaOtorgadaController@busquedaAvanzada');
	
	Route::post('savePasoBecaOtorgada', 'BecaOtorgadaController@savePasoBeca');
	Route::get('editPasoBecaOtorgada/{id}', 'BecaOtorgadaController@editPasoBeca');
	Route::get('deletePasoBecaOtorgada/{id}', 'BecaOtorgadaController@deletePasoBeca');
	Route::post('updatePasoBecaOtorgada/{id}', 'BecaOtorgadaController@updatePasoBeca');
	
	Route::get('addPasoVencimientoBeca/{id}', 'BecaOtorgadaController@addPasoVencimientoBeca');
	
	Route::get('editPasoBecaVencimiento/{id}', 'BecaOtorgadaController@editPasoBecaVencimiento');
	Route::get('deletePasoBecaVencimiento/{id}', 'BecaOtorgadaController@deletePasoBecaVencimiento');
	Route::post('updatePasoBecaVencimiento', 'BecaOtorgadaController@updatePasoBecaVencimiento');

	Route::get('traeTextoPaso', 'BecaOtorgadaController@traeTextoPaso');

	Route::get('enviarEmailIntimacion', 'BecaOtorgadaController@enviarEmailIntimacion');


});



/*
Actuaciones
*/

Route::group(['middleware' => ['session_expired']], function () {
	
	Route::resource('actuacion','ActuacionController');
    Route::get('altaActuacion','ActuacionController@altaActuacion');
    Route::get('listActuacion','ActuacionController@listActuacion');
    Route::post('storeActuacion', 'ActuacionController@store');
	Route::get('listActuacion','ActuacionController@listActuacion');
	Route::post('updateActuacion','ActuacionController@update');
	Route::get('editActuacion/{id}','ActuacionController@edit');
	Route::get('getDatosActuacion','ActuacionController@getDatosActuacion');
	Route::get('getNumeroActuacion','ActuacionController@getNumeroActuacion');
});

//});


/* Archivos Remitidos */
Route::group(['middleware' => ['session_expired']], function () {

Route::get('listRemitidos','RemitidosController@listRemitidos');
Route::get('altaRemitidos','RemitidosController@altaRemitidos');
Route::post('storeRemitidos', 'RemitidosController@store');
Route::get('editRemitidos/{id}','RemitidosController@edit');
Route::post('updateRemitidos','RemitidosController@update');

});

Route::group(['middleware' => ['session_expired']], function () {
	
	Route::get('editUsuario/{id}','UsuarioController@edit');
	Route::post('updateUsuario','UsuarioController@update');
	Route::get('listUsuarios','UsuarioController@listUsuarios');
	
	Route::get('listPerfiles','PerfilController@listPerfiles');
	Route::get('editPerfil/{id}','PerfilController@edit');
	Route::post('addMenuPerfil','PerfilController@ajaxAddMenu');
	Route::post('deleteMenuPerfil','PerfilController@ajaxDeleteMenu');

	Route::get('loadTableMenuPerfil','PerfilController@loadTableMenuPerfil');

	Route::get('listMenu','MenuController@listMenu');

	Route::get('editMenu/{id}','MenuController@edit');	
	Route::post('updateMenu','MenuController@update');
	Route::get('altaMenu','MenuController@altaMenu');
	Route::post('addMenu','MenuController@add');
	
});


Route::group(['middleware' => ['session_expired']], function () {
	
	//Route::resource('actuacion','ActuacionController');
    Route::get('listAreas','AreaNotificacionController@listAreas');
    Route::get('verAreaNotificacion','AreaNotificacionController@verAreaNotificacion');
    /*Route::get('listActuacion','ActuacionController@listActuacion');
    Route::post('storeActuacion', 'ActuacionController@store');
	Route::get('listActuacion','ActuacionController@listActuacion');
	Route::post('updateActuacion','ActuacionController@update');
	Route::get('editActuacion/{id}','ActuacionController@edit');
	Route::get('getDatosActuacion','ActuacionController@getDatosActuacion');
	Route::get('getNumeroActuacion','ActuacionController@getNumeroActuacion');*/
});




Route::group(['middleware' => ['session_expired']], function () {
	
	//Route::resource('actuacion','ActuacionController');
    Route::get('listPagoCheques','ChequesController@listPagoCheques');
    Route::get('altaPagoCheque','ChequesController@altaPagoCheque');
    Route::post('saveCursoPagoCheque','ChequesController@saveCursoPagoCheque');
    
    Route::get('editCursoPagoCheque/{id}','ChequesController@editCursoPagoCheque');
    Route::post('updateCursoPagoCheque','ChequesController@updateCursoPagoCheque');
    Route::get('busquedaAvanzadaCursoPagoCheque','ChequesController@busquedaAvanzadaCursoPagoCheque');
    
    
    Route::get('listPagoBecaCheques','ChequesController@listPagoBecaCheques');
    Route::get('altaPagoBecaCheque','ChequesController@altaPagoBecaCheque');
    Route::get('editPagoBecaCheque/{id}','ChequesController@editPagoBecaCheque');
    Route::post('updatePagoBecaCheque','ChequesController@updatePagoBecaCheque');
    Route::post('storePagoBecaCheque','ChequesController@storePagoBecaCheque');
    Route::get('busquedaAvanzadaBecaPagoCheque','ChequesController@busquedaAvanzadaBecaPagoCheque');

    

    Route::get('traeDataCurso','ChequesController@traeDataCurso');
    Route::get('traeDataBeca','ChequesController@traeDataBeca');
    Route::get('traeDataDocente','ChequesController@traeDataDocente');
    Route::get('traeUltimoNroRecibo','ChequesController@traeUltimoNroRecibo');

    Route::get('traeDataMemo','ChequesController@traeDataMemo');

	Route::get('imprimirComprobanteCurso/{id}','ChequesController@imprimirComprobanteCurso');    
    
});



Route::group(['middleware' => 'session_expired'], function () {

	Route::get('listarCursos', 'CursosController@listarCursos');
	Route::get('verInscriptosCurso/{id}', 'CursosController@verInscriptosCurso');
	Route::get('listarUsuariosCurso/{id}', 'CursosController@listarUsuariosCurso');
	Route::post('validarUsuarioCurso', 'CursosController@validarUsuarioCurso');
	Route::post('rechazarUsuarioCurso', 'CursosController@rechazarUsuarioCurso');
	Route::post('validarTodosCurso', 'CursosController@validarTodosCurso');

});


	
/* ABM Docentes */
Route::group(['middleware' => ['session_expired']], function () {

Route::get('listDocentes','DocenteController@listDocentes');
Route::get('editDocente/{id}','DocenteController@editDocente');
Route::post('updateDocente','DocenteController@update');
/*Route::get('altaRemitidos','RemitidosController@altaRemitidos');
Route::post('storeRemitidos', 'RemitidosController@store');
*/
});

