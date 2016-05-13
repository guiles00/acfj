<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\Actuacion;
use App\ArchivoActuacion;
use App\AreaCfj;
use App\Agente;
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



		/*if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}*/
	
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
		
		$archivo_actuacion = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();

		return view('actuacion.editActuacion')->with('actuacion',$actuacion)
		->with('archivo_actuacion',$archivo_actuacion)->with('area_cfj',$area_cfj)
		->with('conste_agente',$conste_agente);
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
    	//$actuacion->conste = $input['actuacion_conste'];
    	$actuacion->fojas = $input['actuacion_fojas'];
    	$actuacion->observaciones = $input['actuacion_observaciones'];
    	$actuacion->archivo_actuacion_id = $input['archivo_actuacion_id'];
    	$actuacion->area_destino_id = $input['area_destino_id'];
    	$actuacion->conste_agente_id = $input['conste_agente_id'];
		$actuacion->save();
		//echo "<pre>";
		//print_r($actuacion);
		//exit;
		$archivo_actuacion = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();

		return view('actuacion.editActuacion')->with('actuacion',$actuacion)->with('archivo_actuacion',$archivo_actuacion)
		->with('area_cfj',$area_cfj)->with('conste_agente',$conste_agente)->with('edited',true);
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

		//if(session_status() == 1)
		//return Redirect::to('/');	
		//
		$archivo_actuacion = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();

		return view('actuacion.altaActuacion')->with('archivo_actuacion',$archivo_actuacion)
		->with('area_cfj',$area_cfj)->with('conste_agente',$conste_agente);
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
		$actuacion->actuacion_fecha = $input['actuacion_fecha'];
	    $actuacion->asunto = $input['actuacion_asunto']; 
    	$actuacion->dirigido = $input['actuacion_dirigido'];
    	$actuacion->remite = $input['actuacion_remite'];
    	//$actuacion->conste = $input['actuacion_conste'];
    	$actuacion->fojas = $input['actuacion_fojas'];
    	$actuacion->observaciones = $input['actuacion_observaciones'];
    	$actuacion->area_destino_id = $input['area_destino_id'];
    	$actuacion->archivo_actuacion_id = $input['archivo_actuacion_id'];
    	$actuacion->conste_agente_id = $input['conste_agente_id'];
		
		try {

			$actuacion->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		//trae los datos del area destino

		//echo "comunico a quien sea";
		

		self::comunicarPase($input['area_destino_id']);
		
		//return view('actuacion.store')->with('actuacion',$actuacion);
		$actuaciones = Actuacion::orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->paginate(20);// ->get();	

		return view('actuacion.listActuacion')->with('actuaciones',$actuaciones);//->with('actuacion',$actuacion);
	}


	private function comunicarPase($area_id){
		$area = AreaCfj::where('area_cfj_id', '=',$area_id)->get();
		//echo "<pre>";
		//echo "Le manda email a esta persona";
		//print_r($area[0]->responsable_email);
		$html = '<html>Holis</html>';
		$this->enviaEmail($area[0]->responsable_email,$html);
	}

	private function enviaEmail($responsable_email,$html){

		//echo $responsable_email;
		//echo $html;

		$to      = 'gcaserotto@jusbaires.gov.ar';
		$subject = 'Departamento de Becas';
		$message = $html;
		$headers = 'From: no-reply@jusbaires.gov.ar' . "\r\n" .
   			   'Reply-To: no-reply@jusbaires.gov.ar' . "\r\n" .
			   //'Bcc: gcaserotto@jusbaires.gov.ar' . "\r\n" .
			   'Return-Path: return@jusbaires.gov.ar' . "\r\n" .
			   'MIME-Version: 1.0' . "\r\n" .
			   'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
			   'X-Mailer: PHP/' . phpversion();

		$res = mail($to, $subject, $message, $headers);

		//ver error 
		if(!$res) echo 'hubo un error al notificar';

		return $res;
	}




	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listActuacion()
	{
		
		$input = Request::all();
		//print_r($input);

		//CAST(field_name as SIGNED INTEGER) ->orderBy('actuacion_fecha', 'desc')
		//$actuaciones = Actuacion::all();
		$str_actuacion = (isset($input['str_actuacion']))?$input['str_actuacion']:'';
		//if( empty($str_actuacion) ){
			//$actuaciones = Actuacion::orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->paginate(20);//->get();	
		//}else{
			$actuaciones = Actuacion::where('numero_actuacion', 'LIKE', '%'.$str_actuacion.'%')
			->orWhere('dirigido', 'LIKE', '%'.$str_actuacion.'%')
			->orWhere('remite', 'LIKE', '%'.$str_actuacion.'%')
			->orWhere('asunto', 'LIKE', '%'.$str_actuacion.'%')
			->orderBy( DB::raw('convert(numero_actuacion, decimal)') ,'desc')->paginate(20);//->get();
			
		//}
		
		 $actuaciones->setPath('listActuacion');
		 //$actuaciones->appends(array('dirigido' => $str_actuacion,'remite' => $str_actuacion,'asunto' => $str_actuacion));			
		$actuaciones->appends(array('str_actuacion' => $str_actuacion));			

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
