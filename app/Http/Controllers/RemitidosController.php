<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\Remitidos;
use App\ArchivoActuacion;
use App\AreaCfj;
use DB;
use App\domain\MyAuth;
use App\domain\User;
use App\domain\Helper;
use Redirect;


class RemitidosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//return "hola Actuacion";



	/*	if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}
	*/
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
		$remitido = Remitidos::find($id);
		
		$archivo_remitidos = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$helper = new Helper();
		$tipos_memo = $helper->getHelperByDominio('tipo_memo');

		return view('remitidos.editRemitidos')->with('remitido',$remitido)
		->with('archivo_remitidos',$archivo_remitidos)->with('area_cfj',$area_cfj)
		->with('tipos_memo',$tipos_memo);
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

		$remitidos = Remitidos::find($input['_id']);
		
		$remitidos->fecha_remitidos =	$input['remitidos_fecha'];
		$remitidos->tipo_remitido_id = $input['tipo_remitido_id']; 
		$remitidos->numero_memo = $input['numero_memo']; 
	    $remitidos->asunto = $input['remitidos_asunto']; 
    	$remitidos->dirigido = $input['remitidos_dirigido'];
    	$remitidos->firmado_id = $input['area_destino_id'];
    	$remitidos->conste = $input['remitidos_conste'];
    	$remitidos->archivo_remitidos_id = $input['archivo_remitidos_id'];

		$remitidos->save();
		
		$archivo_remitidos = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$helper = new Helper();
		$tipos_memo = $helper->getHelperByDominio('tipo_memo');


		return view('remitidos.editRemitidos')->with('remitido',$remitidos)->with('archivo_remitidos',$archivo_remitidos)->with('area_cfj',$area_cfj)
		->with('tipos_memo',$tipos_memo)->with('edited',true);;

		
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

	public function altaRemitidos()
	{
		//
		$archivo_remitidos = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$helper = new Helper();
		$tipos_memo = $helper->getHelperByDominio('tipo_memo');

		//echo "<pre>";
		//print_r($tipos_memo);

		return view('remitidos.altaRemitidos')->with('archivo_remitidos',$archivo_remitidos)->with('area_cfj',$area_cfj)->with('tipos_memo',$tipos_memo);
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
		$remitidos = new Remitidos;
		//$remitidos->numero_actuacion = $input['nro_actuacion'];
		
		$remitidos->fecha_remitidos =	$input['remitidos_fecha'];
		$remitidos->tipo_remitido_id = $input['tipo_remitido_id']; 
		$remitidos->numero_memo = $input['numero_memo']; 
	    $remitidos->asunto = $input['remitidos_asunto']; 
    	$remitidos->dirigido = $input['remitidos_dirigido'];
    	$remitidos->firmado_id = $input['area_destino_id'];
    	$remitidos->conste = $input['remitidos_conste'];
    	$remitidos->archivo_remitidos_id = $input['archivo_remitidos_id'];
		
		try {

			$remitidos->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		

		//echo "<pre>";
		
		//print_r($input);

		//return view('actuacion.store')->with('actuacion',$actuacion);
		//$remitidos = Remitidos::orderBy( 'remitidos_id' ,'desc')->get();	

		//return view('remitidos.listRemitidos')->with('remitidos',$remitidos);
		//return redirect()->back()->with('remitidos',$remitidos);

		//$url = 'verSolicitud/'.$input['beca_id'];
		return Redirect::to('./listRemitidos');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listRemitidos()
	{

	/*	if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}
	*/
		$input = Request::all();

		$str = (isset($input['str_remitido']))?$input['str_remitido']:'';

		//print_r($input);
		//CAST(field_name as SIGNED INTEGER) ->orderBy('actuacion_fecha', 'desc')
		//$actuaciones = Actuacion::all();
		if(!isset($input['busqueda'])){
			$remitidos = Remitidos::orderBy( 'numero_memo' ,'desc')
						->where(DB::raw('YEAR(remitidos.timestamp)'), '=', DB::raw('YEAR(now())')) //SIEMPRE TRAE LAS DEL CORRIENTE AÑO

			->get();	
		}else{
			$remitidos = Remitidos::where('numero_memo', 'LIKE', '%'.$input['str_remitido'].'%')
			->orWhere('dirigido', 'LIKE', '%'.$input['str_remitido'].'%')
			->orWhere('asunto', 'LIKE', '%'.$input['str_remitido'].'%')
			->orderBy( 'numero_memo' ,'desc')->get();			
		}
		
		
		//echo "<pre>";
		//print_r($remitidos);
		//exit;
		return view('remitidos.listRemitidos')->with('remitidos',$remitidos);
		
	}


		public function busquedaAvanzada()
	{
		$input = Request::all();
		
		
		//$helpers = self::traeHelpers();
		
		
		$query = DB::table('remitidos');
            //->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            //->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id');

        $query->select('*');
       
       	if(!empty($input['str_numero'])) $query->where(DB::raw('remitidos.numero_memo'), '=', $input['str_numero']);	
        if(!empty($input['anio'])) $query->where(DB::raw('YEAR(remitidos.fecha_remitidos)'), '=', $input['anio']);	
		            

        
        $data = 

           
        $remitidos = $query->orderBy( 'numero_memo' ,'desc')->get();			

            
		return view('remitidos.listRemitidos')->with('remitidos',$remitidos);
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
