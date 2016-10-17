<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;


/*Route::get('listarCursos', 'CursosController@listarCursos');
	Route::get('verInscriptosCurso/{id}', 'CursosController@verInscriptosCurso');
	Route::get('listarUsuariosCurso/{id}', 'CursosController@listarUsuariosCurso');
	Route::post('validarUsuarioCurso', 'CursosController@validarUsuarioCurso');
	Route::post('rechazarUsuarioCurso', 'CursosController@rechazarUsuarioCurso');
	Route::post('validarTodosCurso', 'CursosController@validarTodosCurso');

	Route::get('traeDataCurso/{id}', 'CursosController@traeDataCurso');
	Route::get('traeDataAltaAlumno', 'CursosController@traeDataAltaAlumno');
	Route::post('addAlumnoCurso', 'CursosController@addAlumnoCurso');
*/

class RouteTest extends TestCase {
	use WithoutMiddleware; 
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testABasicExample()
	{
		$response = $this->call('GET', '/');

        $this->assertTrue(true);
	}

       public function testlistarCursos(){

      //   $response = $this->call('GET','/listarCursos');
	  //   $this->assertEquals(200, $response->getStatusCode());
       }

	public function traeDataAltaAlumno(){
	
	//$this->visit('/');

        $response = $this->call('GET','/traeDataAltaAlumno');

	    $this->assertEquals(200, $response->getStatusCode());

	}
	public function testDocentes(){

		//$response = $this->call('GET','/listDocentes');		

	}
	public function testlistarUsuariosCurso(){

		$response = $this->call('GET','/listarUsuariosCurso/1');
		$this->assertEquals(200, $response->getStatusCode());		

	}
}
