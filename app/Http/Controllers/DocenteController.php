<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\Docente;
use DB;
use App\domain\MyAuth;
use App\domain\User;
use App\domain\Helper;
use Redirect;


class DocenteController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listDocentes()
	{

		$input = Request::all();
		$str_docente = (isset($input['str_docente']))? $input['str_docente'] : '';
		
		if( empty($input) ){
			$docentes = Docente::orderBy('doc_apellido','ASC')//->orderBy('doc_nombre','ASC')
			->paginate(30);	
		}else{
			$docentes = Docente::where('doc_nombre', 'LIKE', '%'.$str_docente.'%')
			->orderBy('doc_apellido','ASC')
			//->orderBy('doc_nombre','ASC')
			->paginate(30);
		
		}

		$docentes->setPath('listDocentes');
		
		
		$docentes->appends(array('str_docente' => $str_docente));
		
		
		return view('docente.listDocentes')->with('docentes',$docentes);
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editDocente($id)
	{
		//SELECT * FROM curso,curso_docente 
		//WHERE curso.cur_id = curso_docente.cdo_cur_id 
		//and curso.cur_id = 10
		/*SELECT * 
			FROM curso, curso_docente
			WHERE curso.cur_id = curso_docente.cdo_cur_id
		and curso_docente.cdo_cur_id = 43*/

		$docente = Docente::find($id);
		

		$cursos_docente = DB::table('curso')
            ->join('curso_docente', 'curso.cur_id', '=', 'curso_docente.cdo_cur_id')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->select('*')
            ->where('curso_docente.cdo_doc_id', '=', $id)
            ->get();
            
        //echo "<pre>";
        //print_r($cursos_docente);
        //exit;    
		return view('docente.editDocente')->with('docente',$docente)
		->with('cursos_docente',$cursos_docente);

		
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

		$docente = Docente::find($input['_id']);
		
		
        $docente->doc_nombre = $input['docente_nombre'];
        $docente->doc_apellido = $input['docente_apellido'];
        $docente->doc_telefono = $input['docente_telefono'];
        $docente->doc_celular = $input['docente_celular'];
        $docente->doc_email = $input['docente_email'];
        $docente->doc_domicilio = $input['docente_domicilio'];
        $docente->doc_cp = $input['docente_cp'];

		
		$docente->save();
		
		
		$cursos_docente = DB::table('curso')
            ->join('curso_docente', 'curso.cur_id', '=', 'curso_docente.cdo_cur_id')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->select('*')
            ->where('curso_docente.cdo_doc_id', '=', $input['_id'])
            ->get();

		return view('docente.editDocente')->with('docente',$docente)
		->with('cursos_docente',$cursos_docente)
		->with('edited',true);

		
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
		$remitidos = Remitidos::orderBy( 'remitidos_id' ,'desc')->get();	

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
