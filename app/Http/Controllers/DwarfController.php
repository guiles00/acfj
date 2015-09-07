<?php namespace App\Http\Controllers;
use App\Hobbit;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
class DwarfController extends Controller {

	//
	public function index(){
		$hobbits = Hobbit::all();
		//echo "nada";
		//return $hobbits;
		return view('hobbit.index')->with('hobbits',$hobbits);
	}

	public function show($id){

		$hobbit = Hobbit::findOrFail($id);
		

		return view('hobbit.show')->with('hobbit',$hobbit);
	}


	public function create(){

		//$hobbit = Hobbit::findOrFail($id);
		

		return view('hobbit.create');
	}

	public function store(){
		$input = Request::all();
		
		$hobbit = new Hobbit();
		$hobbit->nombre = $input['nombre'];
		$hobbit->apellido = $input['apellido'];
		$hobbit->comarca_id = $input['comarca_id'];

		$hobbit->save();

		$hobbits = Hobbit::all();
		return view('hobbit.index')->with('hobbits',$hobbits);
		//return $input;
	}
}
