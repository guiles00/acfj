<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\PagoCheque;
use App\Remitidos;
use App\ArchivoActuacion;
use App\AreaCfj;
use App\Agente;
use DB;
use App\domain\MyAuth;
use App\domain\User;
use App\domain\PagoCheque as DPagoCheque;
use App\domain\Helper;
use Redirect;


class ChequesController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listPagoCheques()
	{
		
		$input = Request::all();
		
	
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',1)->orderBy('pago_cheque_id','DESC')->paginate(20);// ->get();	
		
		//echo "<pre>";
		//print_r($input);

		if(isset($input['search'])) {
		
			$matchear = ['apellido' => $input['str_cheque'], 'nombre' => $input['str_cheque'],'nro_cheque' => $input['str_cheque']];	
		
			$cheques = DB::table('pago_cheque')
								->join('docente', 'pago_cheque.docente_id', '=', 'docente.doc_id')
								->where(function($query) use ($input){
	                   				 return $query
	                              			->where('docente.doc_apellido','like','%'.$input['str_cheque'].'%')
	                              			->orWhere('docente.doc_nombre','like','%'.$input['str_cheque'].'%')
	                              			->orwhere('pago_cheque.nro_cheque','like','%'.$input['str_cheque'].'%')
	                              			->orwhere('pago_cheque.nro_disp_otorga','like','%'.$input['str_cheque'].'%')
	                              			->orwhere('pago_cheque.nro_disp_aprueba','like','%'.$input['str_cheque'].'%');
	                              			//->orwhere('pago_cheque.nro_cheque','like','%'.$input['str_cheque'].'%');
	                              			//->orwhere('pago_cheque.nro_cheque','like','%'.$input['str_cheque'].'%');
	                			})
								->where('pago_cheque.tipo_pago_cheque_id','=',1)
								->orderBy('pago_cheque.pago_cheque_id','DESC')
					            //->toSql();
	            				->paginate(20);
	            					
        }

        $cheques->setPath('listPagoCheques');
		
        $nro_recibo = $this->traeUltimoNroRecibo();
        $pago_cheque = new DPagoCheque();

		return view('cheques.listPagoCheques')->with('cheques',$cheques)
		->with('nro_recibo',$nro_recibo)
		->with('pago_cheque',$pago_cheque);
		
	}


	public function altaPagoCheque()
	{

		/*$archivo_actuacion = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();*/
		$entregado_por = Agente::get();

		return view('cheques.altaPagoCheque')
		->with('entregado_por',$entregado_por);/*->with('archivo_actuacion',$archivo_actuacion)
		->with('area_cfj',$area_cfj)->with('conste_agente',$conste_agente);*/
	}

	public function traeUltimoNroRecibo(){

		$res_nro_recibo = DB::table('pago_cheque')->orderBy('nro_recibo','DESC')->first();
		
		return intval($res_nro_recibo->nro_recibo);
	}

	public function traeDataCurso(){

		$input = Request::all();
		$q = $input['q'];
		$res['items'] = '';
		//Hubo una modificacion en la estructura de la base

		/*$cursos = $data = DB::table('curso')
							->leftJoin('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							->leftJoin('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
							->leftJoin('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
							->where('gcu3_titulo','like','%'.$q.'%')
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();
        */

		//SELECT * FROM curso INNER JOIN grupo_curso3_grupo_curso2 c32 ON c32.gcu32_id = curso.cur_gcu32_id INNER JOIN grupo_curso3 ON grupo_curso3.gcu3_id = c32.gc32_gcu3_id

        				$cursos = $data = DB::table('curso')
							->leftJoin('grupo_curso3_grupo_curso2', 'grupo_curso3_grupo_curso2.gcu32_id', '=', 'curso.cur_gcu32_id')
							->leftJoin('grupo_curso3', 'grupo_curso3.gcu3_id', '=', 'grupo_curso3_grupo_curso2.gc32_gcu3_id')
							->leftJoin('grupo_curso2', 'grupo_curso2.gcu2_id', '=', 'grupo_curso3.gcu3_gcu2_id')
							->where('gcu3_titulo','like','%'.$q.'%')
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();
        
		//print_r($cursos);
		
		foreach ($cursos as $key => $value) {
					//$res['items'][] = array("id"=>$value->cur_id, "name"=>$value->gcu3_titulo,"full_name"=>$value->gcu3_titulo.'- Fecha Inicio: '.$value->cur_fechaInicio.' Fecha Fin: '.$value->cur_fechaFin);
			$res['items'][] = array("id"=>$value->cur_id, "name"=>$value->gcu3_titulo,"full_name"=>$value->gcu3_titulo,"fecha"=>$value->cur_fechaInicio,"destinatarios"=>$value->cur_destinatario,"subgrupo"=>htmlentities($value->gcu2_nombre));
		}
	//	echo "<pre>";
	//	print_r($res['items']);
	//	exit;

		$res['total_counts'] = sizeof($res['items']);
		
		//print_r($res);

		echo json_encode($res);
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
	
		$pago_cheque = new PagoCheque;
		
	
		$pago_cheque->nro_cheque = $input['nro_cheque'];
		$pago_cheque->nro_expediente = $input['nro_expediente'];
		$pago_cheque->orden_pago = $input['orden_pago'];
		$pago_cheque->curso_id = $input['curso_id'];
	    $pago_cheque->importe = $input['importe']; 
    	$pago_cheque->fecha_retiro = $input['fecha_retiro'];
    	$pago_cheque->retirado_por = $input['retirado_por'];
    	$pago_cheque->nro_memo_id = $input['nro_memo_id'];
 	   	$pago_cheque->nro_disp_otorga = $input['nro_disp_otorga'];
    	$pago_cheque->nro_disp_aprueba = $input['nro_disp_aprueba'];
    	$pago_cheque->disponible_id = $input['disponible_id'];
    	    	
		try {

			$pago_cheque->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		$cheques = PagoCheque::paginate(20);// ->get();	

		return view('cheques.listPagoCheques')->with('cheques',$cheques);
	}



   /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listPagoBecaCheques()
	{
		
		$input = Request::all();

		//$str_cheque = (isset($input['str_actuacion']))?$input['str_actuacion']:'';
	
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',2)->orderBy('pago_cheque_id','DESC')->paginate(20);//->get();
		//echo "<pre>";
		//print_r($cheques);
		if(isset($input['search']))

		$cheques = DB::table('usuario_sitio')
							->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							->join('pago_cheque', 'pago_cheque.beca_id', '=', 'beca.beca_id')
							->where('usuario_sitio.usi_nombre','like','%'.$input['str_cheque'].'%')
							->orWhere('pago_cheque.nro_cheque','like','%'.$input['str_cheque'].'%')
							->where('tipo_pago_cheque_id','=',2)
							->orderBy('pago_cheque.pago_cheque_id','DESC')
				            //->toSql();
            				->paginate(20);
            					
        $cheques->setPath('listPagoBecaCheques');

		//$actuaciones->appends(array('str_actuacion' => $str_actuacion));			

		//print_r($cheques);
		return view('cheques.listPagoBecaCheques')->with('cheques',$cheques);
		
	}

	public function busquedaAvanzadaBecaPagoCheque()
	{
		$input = Request::all();
		
		//print_r($input);
		//echo 'busquedaAvanzada';
		//exit;
		
		//$helpers = self::traeHelpers();
		
		$query = DB::table('usuario_sitio')
							->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							->join('pago_cheque', 'pago_cheque.beca_id', '=', 'beca.beca_id')
							->where('tipo_pago_cheque_id','=',2);
							//->orderBy('pago_cheque.pago_cheque_id','DESC')
				            //->toSql();
            				//->paginate(20);


		$query->select('*');
       
        if( $input['disponible_id'] !='') $query->where('pago_cheque.disponible_id', '=', $input['disponible_id']);	
        if( $input['entregado'] == 0 ) $query->where('pago_cheque.entregado_por_id', '=', 0);		
        if( $input['entregado'] == 1 ) $query->where('pago_cheque.entregado_por_id', '<>', 0);		
        //if( $input['entregado'] == 1 ) $query->where('pago_cheque.disponible_id', '=', $input['disponible_id']);		
        //if(!empty($input['tipo_beca_id'])) $query->where('beca.tipo_beca_id', '=', $input['tipo_beca_id']);	
		//if(!empty($input['anio'])) $query->where(DB::raw('YEAR(beca.timestamp)'), '=', $input['anio']);	
		            

        
        $cheques = $query->orderBy('pago_cheque.pago_cheque_id','DESC')->paginate(200);
           
        
       // $cheques->setPath('listSolicitudesBecas');
        // $becas->appends(array('estado_id' => $input['estado_id'],'str_beca' => $str));
            
		return view('cheques.listPagoBecaCheques')->with('cheques',$cheques);
	}


	public function busquedaAvanzadaCursoPagoCheque()
	{
		$input = Request::all();
		
		/*print_r($input);
		echo 'busquedaAvanzada';
		exit;
		*/
		//$helpers = self::traeHelpers();
		
		$query = DB::table('pago_cheque')
							//->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							//->join('pago_cheque', 'pago_cheque.beca_id', '=', 'beca.beca_id')
							->where('tipo_pago_cheque_id','=',1);
							//->orderBy('pago_cheque.pago_cheque_id','DESC')
				            //->toSql();
            				//->paginate(20);


		$query->select('*');
       
        if( $input['disponible_id'] !='') $query->where('pago_cheque.disponible_id', '=', $input['disponible_id']);	
     //   if( $input['entregado'] == 0 ) $query->where('pago_cheque.entregado_por_id', '=', 0);		
     //   if( $input['entregado'] == 1 ) $query->where('pago_cheque.entregado_por_id', '<>', 0);		
        //if( $input['entregado'] == 1 ) $query->where('pago_cheque.disponible_id', '=', $input['disponible_id']);		
        //if(!empty($input['tipo_beca_id'])) $query->where('beca.tipo_beca_id', '=', $input['tipo_beca_id']);	
		//if(!empty($input['anio'])) $query->where(DB::raw('YEAR(beca.timestamp)'), '=', $input['anio']);	
		            

        
        $cheques = $query->orderBy('pago_cheque.pago_cheque_id','DESC')->paginate(200);
           
       // print_r($cheques);
       // exit;
       // $cheques->setPath('listSolicitudesBecas');
        // $becas->appends(array('estado_id' => $input['estado_id'],'str_beca' => $str));
   		$nro_recibo = $this->traeUltimoNroRecibo();

		return view('cheques.listPagoCheques')
		->with('cheques',$cheques)
		->with('nro_recibo',$nro_recibo);
	}

	public function altaPagoBecaCheque()
	{

		/*$archivo_actuacion = ArchivoActuacion::get();
		$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();*/
		$entregado_por = Agente::get();

		return view('cheques.altaPagoBecaCheque')
		->with('entregado_por',$entregado_por);/*->with('archivo_actuacion',$archivo_actuacion)
		->with('area_cfj',$area_cfj)->with('conste_agente',$conste_agente);*/
	}

	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function storePagoBecaCheque()
	{
		//
		$input = Request::all();
	
		$pago_cheque = new PagoCheque;
		$pago_cheque->tipo_pago_cheque_id = 2;
		$pago_cheque->nro_cheque = $input['nro_cheque'];
		$pago_cheque->numero_reintegro = $input['numero_reintegro'];
		$pago_cheque->nro_expediente = $input['nro_expediente'];
		$pago_cheque->orden_pago = $input['orden_pago'];
		$pago_cheque->beca_id = $input['beca_id'];
	    $pago_cheque->importe = $input['importe']; 
    	$pago_cheque->fecha_retiro = $input['fecha_retiro'];
    	$pago_cheque->fecha_emision = $input['fecha_emision'];
    	$pago_cheque->retirado_por = $input['retirado_por'];
    	$pago_cheque->dni_retira = $input['dni_retira'];
    	$pago_cheque->nro_memo_id = $input['nro_memo_id'];
 	   	$pago_cheque->nro_disp_otorga = $input['nro_disp_otorga'];
    	$pago_cheque->nro_disp_aprueba = $input['nro_disp_aprueba'];
    	$pago_cheque->disponible_id = $input['disponible_id'];
    	$pago_cheque->observaciones = $input['observaciones'];
    	    	
		try {

			$pago_cheque->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',2)->orderBy('pago_cheque_id','DESC')->paginate(20);// ->get();	

		return view('cheques.listPagoBecaCheques')->with('cheques',$cheques);
	}



	public function traeDataBeca(){ 

		$input = Request::all();
		$q = $input['q'];
		$res['items'] = '';

//SELECT * FROM usuario_sitio us, beca b WHERE b.alumno_id = us.usi_id AND us.usi_nombre LIKE  '%monte%'

		$becas = DB::table('usuario_sitio')
							->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							->where('usuario_sitio.usi_nombre','like','%'.$q.'%')
							->orderBy('beca.beca_id','DESC')
            				->get();
		

		foreach ($becas as $key => $value) {
					//$res['items'][] = array("id"=>$value->cur_id, "name"=>$value->gcu3_titulo,"full_name"=>$value->gcu3_titulo.'- Fecha Inicio: '.$value->cur_fechaInicio.' Fecha Fin: '.$value->cur_fechaFin);
			$res['items'][] = array("id"=>$value->beca_id, "name"=>$value->usi_nombre,"full_name"=>$value->usi_nombre,"fecha"=>$value->usi_id,"nro_disposicion"=>$value->nro_disposicion);
		}
		//print_r($cursos);
		//exit;

		
		$res['total_counts'] = sizeof($res['items']);
		
		//print_r($res);

		echo json_encode($res);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editPagoBecaCheque($id)
	{

		//
		$pago_cheque = PagoCheque::find($id);
		
		//echo "<pre>";
		//print_r($pago_cheque->beca_id);
	//	exit;
		$becario = DPagoCheque::getDatosBecario($pago_cheque->beca_id);
		
		$helper = new Helper();
		$disponible = $helper->getHelperByDominio('disponible_id');
		$entregado_por = Agente::get();
		$nro_memo = Remitidos::where('remitidos_id','=',$pago_cheque->nro_memo_id)->first();
		//echo "<pre>";
		//print_r($nro_memo);
		//exit;
		/*$area_cfj = AreaCfj::get();
		$conste_agente = Agente::get();
*/
		return view('cheques.editPagoBecaCheque')->with('pago_cheque',$pago_cheque)
		->with('becario',$becario)
		->with('disponible',$disponible)
		->with('entregado_por',$entregado_por)
		->with('nro_memo',$nro_memo);/*
		->with('archivo_actuacion',$archivo_actuacion)->with('area_cfj',$area_cfj)
		->with('conste_agente',$conste_agente);*/
	}

		/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function updatePagoBecaCheque()
	{
		//
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);
		//exit;
		$pago_cheque = PagoCheque::find($input['_id']);
		//$pago_cheque->tipo_pago_cheque_id = 2;
		$pago_cheque->nro_cheque = $input['nro_cheque'];
		$pago_cheque->numero_reintegro = $input['numero_reintegro'];
		$pago_cheque->nro_expediente = $input['nro_expediente'];
		$pago_cheque->orden_pago = $input['orden_pago'];
		$pago_cheque->beca_id = $input['beca_id'];
	    $pago_cheque->importe = $input['importe']; 
    	$pago_cheque->fecha_retiro = $input['fecha_retiro'];
    	$pago_cheque->fecha_emision = $input['fecha_emision'];
    	$pago_cheque->retirado_por = $input['retirado_por'];
    	$pago_cheque->dni_retira = $input['dni_retira'];
    	$pago_cheque->nro_memo_id = $input['nro_memo_id'];
 	   	$pago_cheque->nro_disp_otorga = $input['nro_disp_otorga'];
    	$pago_cheque->nro_disp_aprueba = $input['nro_disp_aprueba'];
    	$pago_cheque->disponible_id = $input['disponible_id'];
    	$pago_cheque->entregado_por_id = $input['entregado_por_id'];
    	$pago_cheque->observaciones = $input['observaciones'];


    	    	
		try {

			$pago_cheque->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',2)->orderBy('pago_cheque_id','DESC')->paginate(20);// ->get();	
		
		$cheques->setPath('listPagoBecaCheques');

		return view('cheques.listPagoBecaCheques')->with('cheques',$cheques);
	}


	public function traeDataDocente(){ 

		$input = Request::all();
		$q = $input['q'];
		$res['items'] = '';

//SELECT * FROM usuario_sitio us, beca b WHERE b.alumno_id = us.usi_id AND us.usi_nombre LIKE  '%monte%'

		$docentes = DB::table('docente')
							->where('doc_nombre','like','%'.$q.'%')
							->orWhere('doc_apellido','like','%'.$q.'%')
							//->orderBy('apellido','DESC')
            				->get();
		//print_r($docentes);

		foreach ($docentes as $key => $value) {
					//,"full_name"=>$value->apellido.' '.$value->nombre,"fecha"=>''
			$res['items'][] = array("id"=>$value->doc_id, "name"=>$value->doc_apellido.' '.$value->doc_nombre);
		}

		
		$res['total_counts'] = sizeof($res['items']);

		echo json_encode($res);
	}




	public function traeDataMemo(){

		$input = Request::all();
		$q = $input['q'];
		$res['items'] = '';



		$becas = DB::table('remitidos')
							->join('helper', 'remitidos.tipo_remitido_id', '=', 'helper.dominio_id')
							->where('helper.dominio','=','tipo_memo')
							->where('numero_memo','like','%'.$q.'%')
							->orderBy('remitidos.remitidos_id','DESC')
            				->get();
		

		foreach ($becas as $key => $value) {
					//$res['items'][] = array("id"=>$value->cur_id, "name"=>$value->gcu3_titulo,"full_name"=>$value->gcu3_titulo.'- Fecha Inicio: '.$value->cur_fechaInicio.' Fecha Fin: '.$value->cur_fechaFin);
			$res['items'][] = array("id"=>$value->remitidos_id, "name"=>$value->numero_memo,"full_name"=>$value->nombre.'-'.$value->numero_memo,"fecha"=>$value->fecha_remitidos);
		}
		//print_r($cursos);
		//exit;

		
		$res['total_counts'] = sizeof($res['items']);
		
		//print_r($res);

		echo json_encode($res);
	}

	public function imprimirComprobanteCurso($id){

		$cheque = PagoCheque::find($id);
	
		$docente = DPagoCheque::getDatosDocenteById($cheque->docente_id);
		$curso = DPagoCheque::getDatosCursoById($cheque->curso_id);
		//echo "<pre>";
		//print_r($cheque);
		//exit;
		//$entregado_por = Agente::find($cheque->entregado_por_id);
	
		$entregado_por =  '';
		if(! $cheque->entregado_por_id == 0){
			$agente = Agente::find($cheque->entregado_por_id);
			$entregado_por = $agente->agente_nombre;	
		} 		

		$nro_memo = '';
		if(! $cheque->nro_memo_id == 0){
			$remitido = Remitidos::where('remitidos_id','=',$cheque->nro_memo_id)->first();
			//print_r($cheque->nro_memo_id);
			//exit;
			$nro_memo = $remitido->numero_memo;	
		}

	return view('cheques.comprobanteCurso')->with('cheque',$cheque)
		->with('nro_memo',$nro_memo)
		->with('docente',$docente->doc_apellido.', '.$docente->doc_nombre)
		->with('curso',$curso->gcu3_titulo)
		->with('entregado_por',$entregado_por)
		;

	}


	public function imprimirComprobanteBeca($id){
		
		$cheque = PagoCheque::find($id);
		/*echo "<pre>";
		print_r($cheque);
		exit;
		*/
		$becario = DPagoCheque::getDatosBecario($cheque->beca_id);
		
		$entregado_por =  '';
		if(! $cheque->entregado_por_id == 0){
			$agente = Agente::find($cheque->entregado_por_id);
			$entregado_por = $agente->agente_nombre;	
		} 
		//echo $entregado_por;
		//print_r($cheque->nro_memo_id);
		//exit;	
		$nro_memo = '';
		if(! $cheque->nro_memo_id == 0){
			$remitido = Remitidos::where('remitidos_id','=',$cheque->nro_memo_id)->first();
			$nro_memo = $remitido->numero_memo;	
		}
		
		
	return view('cheques.comprobanteBeca')->with('cheque',$cheque)
		->with('nro_memo',$nro_memo)
		->with('beneficiario',$becario->usi_nombre)
		->with('entregado_por',$entregado_por);	
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


	public function saveCursoPagoCheque()
	{
		//
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);
		//exit;
		$pago_cheque = new PagoCheque;
		$pago_cheque->tipo_pago_cheque_id = 1;
		$pago_cheque->nro_cheque = $input['nro_cheque'];
		$pago_cheque->nro_expediente = $input['nro_expediente'];
		$pago_cheque->orden_pago = $input['orden_pago'];
		$pago_cheque->docente_id = $input['docente_id'];
		$pago_cheque->curso_id = $input['curso_id'];
	    $pago_cheque->importe = $input['importe']; 
    	$pago_cheque->fecha_retiro = $input['fecha_retiro'];
    	$pago_cheque->fecha_emision = $input['fecha_emision'];
    	$pago_cheque->retirado_por = $input['retirado_por'];
    	$pago_cheque->dni_retira = $input['dni_retira'];
    	$pago_cheque->nro_memo_id = $input['nro_memo_id'];
 	   	$pago_cheque->nro_disp_otorga = $input['nro_disp_otorga'];
    	$pago_cheque->nro_disp_aprueba = $input['nro_disp_aprueba'];
    	$pago_cheque->disponible_id = $input['disponible_id'];
    	$pago_cheque->entregado_por_id = $input['entregado_por_id'];
    	$pago_cheque->observaciones = $input['observaciones'];

		$pago_cheque->observaciones_cheque = $input['observaciones_cheque'];
		$pago_cheque->nro_recibo = $input['nro_recibo'];
		$pago_cheque->importe_cheque = $input['importe_cheque'];
		    	    	
		try {

			$pago_cheque->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',1)->orderBy('pago_cheque_id','DESC')->paginate(20);// ->get();	

		$nro_recibo = $this->traeUltimoNroRecibo();

		return view('cheques.listPagoCheques')
		->with('cheques',$cheques)
		->with('nro_recibo',$nro_recibo);
	}


	

	public function editCursoPagoCheque($id)
	{

		//
		$pago_cheque = PagoCheque::find($id);
		
		$docente = DPagoCheque::getDatosDocenteById($pago_cheque->docente_id);
		$curso = DPagoCheque::getDatosCursoById($pago_cheque->curso_id);

		//print_r($id);
		//exit;
		//Traer Docente y Actividad

		$helper = new Helper();
		$disponible = $helper->getHelperByDominio('disponible_id');
		$entregado_por = Agente::get();
		$nro_memo = Remitidos::where('remitidos_id','=',$pago_cheque->nro_memo_id)->first();
		$nro_recibo = $this->traeUltimoNroRecibo();
		
		return view('cheques.editCursoPagoCheque')->with('pago_cheque',$pago_cheque)
		->with('docente',$docente)
		->with('curso',$curso)
		->with('disponible',$disponible)
		->with('entregado_por',$entregado_por)
		->with('nro_memo',$nro_memo)
		->with('nro_recibo',$nro_recibo);
	}


	public function updateCursoPagoCheque()
	{
		//
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);
		//exit;
		$pago_cheque = PagoCheque::find($input['_id']);
		//$pago_cheque->tipo_pago_cheque_id = 2;
		$pago_cheque->nro_cheque = $input['nro_cheque'];
		$pago_cheque->nro_expediente = $input['nro_expediente'];
		$pago_cheque->orden_pago = $input['orden_pago'];
		$pago_cheque->docente_id = $input['docente_id'];
		$pago_cheque->curso_id = $input['curso_id'];
	    $pago_cheque->importe = $input['importe']; 
    	$pago_cheque->fecha_retiro = $input['fecha_retiro'];
    	$pago_cheque->fecha_emision = $input['fecha_emision'];
    	$pago_cheque->retirado_por = $input['retirado_por'];
    	$pago_cheque->dni_retira = $input['dni_retira'];
    	$pago_cheque->nro_memo_id = $input['nro_memo_id'];
 	   	$pago_cheque->nro_disp_otorga = $input['nro_disp_otorga'];
    	$pago_cheque->nro_disp_aprueba = $input['nro_disp_aprueba'];
    	$pago_cheque->disponible_id = $input['disponible_id'];
    	$pago_cheque->entregado_por_id = $input['entregado_por_id'];
    	$pago_cheque->observaciones = $input['observaciones'];

    	$pago_cheque->observaciones_cheque = $input['observaciones_cheque'];
		$pago_cheque->nro_recibo = $input['nro_recibo'];
		$pago_cheque->importe_cheque = $input['importe_cheque'];
    	    	
		try {

			$pago_cheque->save();

		} catch (Exception $e) {
			
			echo "error";
			exit;
		}
		
		$cheques = PagoCheque::where('tipo_pago_cheque_id','=',1)->orderBy('pago_cheque_id','DESC')->paginate(20);// ->get();	

		$nro_recibo = $this->traeUltimoNroRecibo();

		return view('cheques.listPagoCheques')
		->with('cheques',$cheques)
		->with('nro_recibo',$nro_recibo);
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




	private function comunicarPase($area_id,$actuacion){
		$area = AreaCfj::where('area_cfj_id', '=',$area_id)->get();
		
		$notificacion_cfj = DB::table('notificacion_area_cfj')
  				                ->leftJoin('agente','notificacion_area_cfj.agente_id','=','agente.agente_id')
								->where('notificacion_area_cfj.area_cfj_id','=',$area_id)->get();

		$agentes = array();
		foreach ($notificacion_cfj as $agente) {
			$agentes[] = $agente->agente_email;
		}

		$notificacion_agentes = implode(',',$agentes);
		

		$html = '<html>
					<body>
						<p><b><u>Alta </u></b>
						</p>
						<table>
							<tr>
								<td><b>Fecha: </b></td><td>'.$actuacion->actuacion_fecha.'</td>
							</tr>
							<tr>
								<td><b>Asunto: </b></td><td>'.htmlentities($actuacion->asunto, ENT_QUOTES, "UTF-8").'</td>
							</tr>
							<tr>
								<td><b>Actuaci&oacute;n: </b></td><td>'.$actuacion->prefijo.'-'.$actuacion->numero_actuacion.'</td>
							</tr>
							<tr>
								<td><b>Causante: </b></td><td>'.htmlentities($actuacion->remite, ENT_QUOTES, "UTF-8").'</td>
							</tr>
							<tr>
								<td><b>Observaciones: </b></td><td>'.htmlentities($actuacion->observaciones, ENT_QUOTES, "UTF-8").'</td>
							</tr>
						</table>
						<br>
						<p style="font-size:10">Mesa de Entradas Interna - Centro de Formaci&oacute;n Judicial</p>
					</body>
					</html>';

		$subject = 'CFJ-MEI - Alta ACTUACION: '.$actuacion->prefijo.'-'.$actuacion->numero_actuacion;
		$this->enviaEmail($notificacion_agentes,$html,$subject);
	}

	private function enviaEmail($notificacion_agentes,$html,$subject){

		//echo $notificacion_agentes;
		//echo $html;

		$to      = $notificacion_agentes;
		$subject = $subject;
		$message = $html;
		$headers = 'From: no-reply@jusbaires.gov.ar' . "\r\n" .
   			   'Reply-To: no-reply@jusbaires.gov.ar' . "\r\n" .
			   'Bcc: gcaserotto@jusbaires.gov.ar' . "\r\n" .
			   'Return-Path: return@jusbaires.gov.ar' . "\r\n" .
			   'MIME-Version: 1.0' . "\r\n" .
			   'Content-Type: text/html; charset=UTF-8' . "\r\n" .
			   'Content-Transfer-Encoding: 7bit'.
			   'X-Mailer: PHP/' . phpversion();

		$res = mail($to, $subject, $message, $headers);

		//ver error 
		if(!$res) echo 'hubo un error al notificar';

		return $res;
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
