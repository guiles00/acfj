<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\Actuacion;
use DB;
use App\domain\MyAuth;
use App\domain\User;
use Redirect;


class ActuacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//return "hola Actuacion";



		if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}
	
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		$actuacion = Actuacion::find($id);
		

		return view('actuacion.editActuacion')->with('actuacion',$actuacion);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//
		//echo $id;
		$input = Request::all();

		$actuacion = Actuacion::find($input['_id']);
		$actuacion->prefijo = $input['codigo_actuacion'];
		$actuacion->actuacion_fecha =	$input['actuacion_fecha'];
	    $actuacion->asunto = $input['actuacion_asunto']; 
    	$actuacion->dirigido = $input['actuacion_dirigido'];
    	$actuacion->remite = $input['actuacion_remite'];
    	$actuacion->conste = $input['actuacion_conste'];
    	$actuacion->fojas = $input['actuacion_fojas'];
    	$actuacion->observaciones = $input['actuacion_observaciones'];
		$actuacion->save();
		//echo "<pre>";
		//print_r($actuacion);
		//exit;

		return view('actuacion.editActuacion')->with('actuacion',$actuacion)->with('edited',true);
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

	public function altaActuacion()
	{
		//

		return view('actuacion.altaActuacion');
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
		//echo "<pre>";
		//print_r($input);
		//exit;
		$actuacion = new Actuacion;
		$actuacion->numero_actuacion = $input['nro_actuacion'];
		$actuacion->prefijo = $input['codigo_actuacion'];
		$actuacion->actuacion_fecha =	$input['actuacion_fecha'];
	    $actuacion->asunto = $input['actuacion_asunto']; 
    	$actuacion->dirigido = $input['actuacion_dirigido'];
    	$actuacion->remite = $input['actuacion_remite'];
    	$actuacion->conste = $input['actuacion_conste'];
    	$actuacion->fojas = $input['actuacion_fojas'];
    	$actuacion->observaciones = $input['actuacion_observaciones'];
		
		try {

			$actuacion->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		

		//echo "<pre>";
		
		//print_r($input);

		//return view('actuacion.store')->with('actuacion',$actuacion);
		$actuaciones = Actuacion::orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->get();	

		return view('actuacion.listActuacion')->with('actuaciones',$actuaciones);//->with('actuacion',$actuacion);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listActuacion()
	{

		if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}

		$input = Request::all();
		//print_r($input);

		//CAST(field_name as SIGNED INTEGER) ->orderBy('actuacion_fecha', 'desc')
		//$actuaciones = Actuacion::all();
		if( empty($input) ){
			$actuaciones = Actuacion::orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->get();	
		}else{
			$actuaciones = Actuacion::where('numero_actuacion', 'LIKE', '%'.$input['str_actuacion'].'%')
			->orWhere('dirigido', 'LIKE', '%'.$input['str_actuacion'].'%')
			->orWhere('remite', 'LIKE', '%'.$input['str_actuacion'].'%')
			->orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->get();			
		}
		
		

		//print_r($actuaciones);
		
		return view('actuacion.listActuacion')->with('actuaciones',$actuaciones);
		
	}

	public function getDatosActuacion(){

		$input = Request::all();
		
		$datos_actuacion = Actuacion::where('numero_actuacion','=',$input['numero_actuacion'])->get();	
		//print_r($datos_actuacion);
		if(empty($datos_actuacion[0])) return "false";
		
//		$datos_actuacion = ['fecha'=>'01-01-2016','observaciones'=>'esto es una observacion'];
		return $datos_actuacion[0];
	}

		public function getNumeroActuacion(){

		$input = Request::all();
		
		$datos_actuacion = Actuacion::where('numero_actuacion','=',$input['numero_actuacion'])->get();	
		//print_r($datos_actuacion);
		if(empty($datos_actuacion[0])) return "false";
		
//		$datos_actuacion = ['fecha'=>'01-01-2016','observaciones'=>'esto es una observacion'];
		return $datos_actuacion[0];
	}
	

}
