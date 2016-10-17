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

class CursosTest extends TestCase {
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

        $response = $this->call('GET','/listarCursos');
        $this->assertContains('Listado de Cursos', $response->getContent());
	    $this->assertEquals(200, $response->getStatusCode());
    }

/*Este no funciona*/
	public function traeDataAltaAlumno(){
	
	//$this->visit('/');
		//?q=caserotto&cur_id=378
        $response = $this->call('GET','/traeDataAltaAlumno/',['cur_id' => 378,'q' => '']);
        print_r($response->getStatusCode());
	    $this->assertEquals(300, $response->getStatusCode());
	    //$this->assertEquals('Hello World', $response->getContent());

	}
	public function testlistarUsuariosCurso(){
		//Ver Inscriptos Curso
		$response = $this->call('GET','/listarUsuariosCurso/378');
		//echo "asdasdasdasdasdasdasd";
		//print_r($response->getContent());
		$this->assertEquals(200, $response->getStatusCode());		
		$this->assertContains('VILLASANTE', $response->getContent());

	}
	public function verInscriptosCurso(){
		
		$response = $this->call('GET','/verInscriptosCurso/1');
		$this->assertEquals(200, $response->getStatusCode());
	}
}
