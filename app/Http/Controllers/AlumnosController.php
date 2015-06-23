<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Alumno;
use Request;

class AlumnosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//echo "nada";
		//exit;
		$input = Request::all();
		
		$str = (isset($input['str_alumno']))?$input['str_alumno']:'';
		$alumnos = Alumno::where('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_dni', 'LIKE', "%$str%")
		->orWhere('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_legajo', 'LIKE', "%$str%")
		->paginate(30);
		
		$alumnos->setPath('alumnos');
		//echo "<pre>";
		//print_r($input);
		return view('alumnos.index')->with('alumnos',$alumnos);
	}

	public function pendientes(){

//return response()->json($json_data);
	return view('alumnos.pendientes');
	}
	public function about()
	{
		//
		return view('about');
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
			$input = Request::all();
			$alumno = Alumno::where('usi_id','=',$input['_id'])->first();
		//	echo"<pre>";
		//	print_r($input);
		
			$alumno->usi_nombre = $input['nombre'];
			$alumno->save();
			
		return view('alumnos.store');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$alumno = Alumno::where('usi_id','=',$id)->first();
	//	echo "<pre>";
	//	print_r($alumno);
		return view('alumnos.show')->with('alumno',$alumno);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
