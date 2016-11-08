<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\UsuarioSitio;
/*

*/

class UsuarioSitioTest extends TestCase {
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

    public function testlistarUsuarioSitio(){

        $response = $this->call('GET','/listarUsuarioSitio');
       // $this->assertContains('Listado de Alumnos', $response->getContent());
	    $this->assertEquals(200, $response->getStatusCode());
    }

    public function testTraeUsuarioSitioParaValidar(){

        $response = $this->call('GET','/listarUsuarioSitio',['_search'=>'true','str_usuario'=>'BELLO','estado_id'=>0]);
       // $this->assertContains('Listado de Alumnos', $response->getContent());
	    $this->assertEquals(200, $response->getStatusCode()); //FALTA CONTROLAR QUE LO QUE TRAE ES PARA VALIDAR, PERO SI ESTA BIEN LA CONSULTA
    }

    public function testFiltrarUsuarioSitio(){

        $response = $this->call('GET','/listarUsuarioSitio',['_search'=>'true','str_usuario'=>'BELLO']);
        //print_r($response->getContent());
        $this->assertContains('BELLO', $response->getContent());
	    $this->assertEquals(200, $response->getStatusCode());
    }

    public function testValidarUsuarioSito(){

        //$response = $this->call('GET','/validarUsuarioSitio',['id'=>8613]); //8613

        $usuario = UsuarioSitio::find(8613);
        $usuario->usi_validado = '-';
        $usuario->save();
        $response = $this->call('GET','/validarUsuarioSitio/8613'); //8613
        $usuario = UsuarioSitio::find(8613);

        $this->assertEquals($usuario->usi_validado, 'Si');   
    	
        //$this->assertTrue(true);	
    }

    public function testVerUsuarioSitio(){

    	$response = $this->call('GET','/verUsuarioSitio/1474');	//busco el usuario caserotto
    	$this->assertEquals(200, $response->getStatusCode());	
    	$this->assertContains('CASEROTTO', $response->getContent());

    }

    public function testResetearContrasena(){

        $usuario = UsuarioSitio::find(1474);
        $usuario->usi_clave = '1234';
        $usuario->save();
        $response = $this->call('GET','/resetPasswordUsuarioSitio/1474'); //busco el usuario caserotto
        
        $usuario = UsuarioSitio::find(1474);
        
        $this->assertEquals($usuario->usi_clave, $usuario->usi_dni);   
    }

}
