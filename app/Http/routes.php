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

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Route::get('/', function()
//{
//    return 'Hello World';
//});

Route::resource('alumnos', 'AlumnosController');

Route::get('about','AlumnosController@about');
//Route::get('tasks','TasksController@list');
Route::get('tasks','TasksController@lista');
Route::get('accion','TasksController@accion');
Route::get('crea','TasksController@create');

//Route::get('hobbit','HobbitController');

//Ruta para tratar un objeto restFul
//Route::resource('hobbit', 'HobbitController');

//Route::controller('hobbit', 'HobbitController@index');

Route::get('foo',function()
{
	return "bar";
});
Route::get('dwarfs','DwarfController@index');
Route::get('dwarfs/create','DwarfController@create');
Route::get('dwarfs/{id}','DwarfController@show');

Route::post('dwarfs','DwarfController@store');


//Route::get('dwarfs', 'HobbitController@index');
Route::get('becas','BecaController@index');
//Route::get('becas/create','DwarfController@create');
Route::get('becas/{id}','DwarfController@show');

Route::post('becas','DwarfController@store');

Route::get('d3','D3Controller@index');

Route::get('tablero','TableroController@index');
Route::get('tablero/estadisticas','TableroController@estadisticasCurso');
Route::get('cargocurso/{x}/{y}','TableroController@traeCargoCurso');
Route::get('tablero/estadisticas/{x}','TableroController@estadisticasCurso');
Route::get('pendientes','AlumnosController@pendientes');
Route::get('curso-fecha','TableroController@cursoFecha');
Route::get('inscriptos-curso','TableroController@inscriptosCurso');

//Route::get('tablero/{id}','TableroController@estadisticasCurso');

//Route::controller('tablero', 'TableroController');
//Route::get('tablero','TableroController@index');
//Route::get('esta','TableroController@getEstadisticasCurso');

//Route::get('hobbits','HobbitController@index');



