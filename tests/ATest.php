<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

//use User;
//use Menu;

class ATest extends TestCase {
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

       public function testListarCheques(){

        // $response = $this->call('GET','/listPagoCheques');
	//     $this->assertEquals(302, $response->getStatusCode());
       }

	public function testVisit(){
	
	//$this->visit('/');

      //  $response = $this->call('GET','/listPagoCheques');

	    // $this->assertEquals(200, $response->getStatusCode());
	//   $this->assertEquals('Hello World', $response->getContent());

	}
	public function testDocentes(){

		//$response = $this->call('GET','/listDocentes');		

	}
	public function testCursos(){

		$response = $this->call('GET','/listarCursos');		

	}
}
