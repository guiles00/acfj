<?php namespace App\Http\Controllers;
use App\Beca;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
//use App\Alumno;
//use App\Cargo;
use DB;
use Request;
use Auth;
use App\domain\Helper;
use App\domain\Documentacion;
use Redirect;

class BecaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$becas = Beca::all();
		
		if (Auth::check())
		{
		    echo "logueado";
		    exit;
		}/*else{
			echo " no logueado";
		    exit;
		}*/

		$input = Request::all();
		
		$str = (isset($input['str_beca']))?$input['str_beca']:'';
		//print_r($input);
		$helper = new Helper();
		/*$becas = Beca::where('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_dni', 'LIKE', "%$str%")
		->orWhere('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_legajo', 'LIKE', "%$str%")
		->paginate(30);
		*/
		//$alumnos->setPath('alumnos');
		$input['estado_id'] = (isset($input['estado_id']))?$input['estado_id']:'-1';
		if($input['estado_id'] == -1){
			$data = DB::table('beca')
	            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
	            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
	           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
	            ->select('*')
	            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
                ->where('beca.estado_id', '<>', 0)

	           // ->groupBy('cargo.car_nombre')
	            ->orderBy('beca.beca_id','DESC')
	            //->toSql();
	            ->paginate(20); // El paginate funciona como get()
	            //->get(); 
        	
		}else{
		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
            ->where('beca.estado_id', '=', $input['estado_id'])
            ->where('beca.estado_id', '<>', 0)
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
           // ->toSql();
            ->paginate(20); // El paginate funciona como get()
            //->get(); 

        }
            $becas = $data;

            $becas->setPath('listBecas');
            $becas->appends(array('estado_id' => $input['estado_id'],'str_beca' => $str));
            
		return view('beca.index')->with('becas',$becas);
	}

		public function listBecas(){
		//$becas = Beca::all();
		

		$input = Request::all();
		
		$str = (isset($input['str_beca']))?$input['str_beca']:'';
		//print_r($input);

		/*$becas = Beca::where('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_dni', 'LIKE', "%$str%")
		->orWhere('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_legajo', 'LIKE', "%$str%")
		->paginate(30);
		*/
		//$alumnos->setPath('alumnos');
		$input['estado_id'] = (isset($input['estado_id']))?$input['estado_id']:'-1';
		
		if($input['estado_id'] == -1){
			$data = DB::table('beca')
	            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
	            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
	           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
	            ->select('*')
	            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
	           // ->groupBy('cargo.car_nombre')
	            ->orderBy('beca.beca_id','DESC')
	            //->toSql();
	            ->paginate(20); // El paginate funciona como get()
	            //->get(); 
        	
		}else{
		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
            ->where('beca.estado_id', '=', $input['estado_id'])
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            //->toSql();
            ->paginate(20); // El paginate funciona como get()
            //->get(); 
        }
            $becas = $data;

            $becas->setPath('listBecas');


		return view('beca.listBecas')->with('becas',$becas);
	}


	public function verSolicitud($id){

		//$input = Request::all();
		//echo "<pre>";
		//print_r($id);

		$helper = new Helper();
		$tipo_becas = $helper->getHelperByDominio('tipo_beca');
		$renovacion = $helper->getHelperByDominio('renovacion');
		$tipo_actividad = $helper->getHelperByDominio('tipo_actividad');
		$s_horaria = $helper->getHelperByDominio('s_horaria');
		$estado_beca = $helper->getHelperByDominio('estado_beca');

//echo "<pre>";
//print_r($estado_beca);

		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*')
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            
            $cargos = DB::table('cargo')->get();
            $universidades = DB::table('universidad')->get();
            $fuero = DB::table('fuero')->get();
			$titulos = DB::table('titulo')->get();
			$facultades = DB::table('facultad')->get();
			$dependencias = DB::table('dependencia')->get();

			$helpers['cargos']=$cargos;
			$helpers['universidades']=$universidades;
			$helpers['fuero']=$fuero;
			$helpers['dependencias']=$dependencias;
			$helpers['titulos']=$titulos;
			$helpers['facultades']=$facultades;
			$helpers['tipo_becas'] = $tipo_becas;
			$helpers['renovacion'] = $renovacion;
			$helpers['tipo_actividad'] = $tipo_actividad;
			$helpers['s_horaria'] = $s_horaria;
			$helpers['estado_beca'] = $estado_beca;
			
			$documentacion = Documentacion::traeDocumentacion($id);

		return view('beca.verSolicitudBeca')->with('beca',$solicitud_beca[0])->with('helpers',$helpers)->with('documentacion',$documentacion);

	}

	public function verDocAdjunta($id){

		//$input = Request::all();
		//echo "<pre>";
		//print_r($id);


		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*')
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            /*echo "<pre>";
            print_r($solicitud_beca);
            exit;*/
		return view('beca.verDocAdjunta')->with('beca',$solicitud_beca[0]);

	}

	public function save(){

		$input = Request::all();
		
		//echo "<pre>";
		//print_r($input);
		//exit;
		//echo "muestro la solicitud";		
		//guardo datos de beca, los de usuario_sitio hay que confirmar que datos se pueden modificar.
		$beca = Beca::find($input['_id']);
		$beca->titulo_id = $input['titulo_id'];
		$beca->domicilio_constituido = $input['domicilio'];
		$beca->cargo_id = $input['car_id'];
		$beca->fuero_id = $input['fuero_id'];
		$beca->universidad_id = $input['universidad_id'];
		$beca->facultad_id = $input['facultad_id'];
		$beca->titulo_id = $input['titulo_id'];
		$beca->tipo_beca_id = $input['tipo_beca_id'];
		$beca->tipo_actividad_id = $input['tipo_actividad_id'];
		$beca->institucion_propuesta = $input['inst_prop_id'];
		$beca->costo = $input['costo'];
		$beca->monto = $input['monto'];
		$beca->fecha_inicio = $input['fecha_inicio'];
		$beca->fecha_fin = $input['fecha_fin'];
		$beca->actividad_nombre = $input['actividad_nombre'];
		$beca->duracion = $input['duracion'];
		$beca->sup_horaria = $input['s_horaria'];
		$beca->f_ingreso_caba = $input['f_ingreso_caba'];
		$beca->dependencia_id = $input['dependencia_id'];
		$beca->telefono_laboral = $input['tel_laboral'];
		$beca->dictamen_por = $input['dictamen_por'];
		$beca->renovacion_id = $input['renovacion_id'];

		$beca->estado_id = $input['estado_id'];

		$beca->save();


		$documentacion = \App\Documentacion::where('beca_id',$input['_id'])->first();
		
		
        $documentacion->formulario_solicitud = ( empty($input['doc_formulario_solicitud']) )? 0 : 1;
        $documentacion->curriculum_vitae = ( empty($input['doc_curriculum_vitae']) )? 0 : 1;
        $documentacion->informacion_actividad = ( empty($input['doc_informacion_actividad']) )? 0 : 1;
        $documentacion->certificado_laboral = ( empty($input['doc_certificado_laboral']) )? 0 : 1;;
        $documentacion->copia_titulo = ( empty($input['doc_copia_titulo']) )? 0 : 1;
        $documentacion->dictamen_evaluativo = ( empty($input['doc_dictamen_evaluativo']) )? 0 : 1;

        $documentacion->save();

		//echo "<pre>";
		//echo $input['_id'];
		//print_r($documentacion);
		//exit;
		/*		echo "<pre>";

		$helper = new Helper();
		$t_becas = $helper->getHelperByDominio('tipo_beca');
		print_r($t_becas);
		exit;
*/

return redirect()->back()->with('edited',true);

/*		$helper = new Helper();
		$tipo_becas = $helper->getHelperByDominio('tipo_beca');
		$renovacion = $helper->getHelperByDominio('renovacion');
		$tipo_actividad = $helper->getHelperByDominio('tipo_actividad');
		$s_horaria = $helper->getHelperByDominio('s_horaria');
		$estado_beca = $helper->getHelperByDominio('estado_beca');

		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*')
            ->where('beca.beca_id', '=', $input['_id'])
            ->get(); 
            
            
            $cargos = DB::table('cargo')->get();
            $universidades = DB::table('universidad')->get();
            $fuero = DB::table('fuero')->get();
			$titulos = DB::table('titulo')->get();
			$facultades = DB::table('facultad')->get();

			$helpers['cargos']=$cargos;
			$helpers['universidades']=$universidades;
			$helpers['fuero']=$fuero;
			$helpers['titulos']=$titulos;
			$helpers['facultades']=$facultades;
			$helpers['tipo_becas'] = $tipo_becas;
			$helpers['renovacion'] = $renovacion;
			$helpers['tipo_actividad'] = $tipo_actividad;
			$helpers['s_horaria'] = $s_horaria;
			$helpers['estado_beca'] = $estado_beca;
			
			
		return view('beca.verSolicitudBeca')->with('beca',$solicitud_beca[0])->with('helpers',$helpers);

*/		
/*
		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
           // ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            //->toSql();
            ->paginate(20); // El paginate funciona como get()
            //->get(); 
            
            $becas = $data;

		return view('beca.index')->with('becas',$becas);
*/
	}

public function addActuacion($id){
	$input = Request::all();
	//echo "<pre>";
	print_r($input);

	return view('beca.addActuacion')->with('beca_id',$id);

}

public function saveActuacion(){
	$input = Request::all();
	//echo "<pre>";
	print_r($input);

	//return view('beca.verSolicitudBeca')->with('beca_id',$id);
	$url = 'verSolicitud/'.$input['beca_id'];
	return Redirect::to($url);

}
public function exportar(){
	$datos = array(
		array("First Name" => "Nitya", "Last Name" => "Maity", "Email" => "nityamaity87@gmail.com", "Message" => "Test message by Nitya"),
		array("First Name" => "Codex", "Last Name" => "World", "Email" => "info@codexworld.com", "Message" => "Test message by CodexWorld"),
		array("First Name" => "John", "Last Name" => "Thomas", "Email" => "john@gmail.com", "Message" => "Test message by John"),
		array("First Name" => "Michael", "Last Name" => "Vicktor", "Email" => "michael@gmail.com", "Message" => "Test message by Michael"),
		array("First Name" => "Sarah", "Last Name" => "David", "Email" => "sarah@gmail.com", "Message" => "Test message by Sarah")
	);

		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            //->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
            //->where('beca.estado_id', '=', $input['estado_id'])
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            ->get();
//echo "<pre>";
     $row = array();
     foreach ($data as $key => $value) {

  			$row['beca_id'] = $value->beca_id;
            $row['nombre'] = $value->usi_nombre;
            $row['tipo_beca_id'] = $value->tipo_beca_id;
    		
    		$excel[] = $row;
    }
    $data = $excel;
    //$data = $datos;
	//echo "<pre>";
	//print_r($data);
	//exit;
	return view('beca.exportar')->with('data',$data);

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
