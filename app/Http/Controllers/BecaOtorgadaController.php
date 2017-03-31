<?php namespace App\Http\Controllers;
use App\Beca;
use App\Actuacion;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
//use App\Alumno;
//use App\Cargo;
use DB;
use Request;
use Auth;
use App\domain\MyAuth;
use App\domain\Helper;
use App\domain\Documentacion;
use Redirect;
use App\domain\User;
use App\domain\Utils;
use App\PasoBeca;
use App\domain\Agente;
use App\domain\UsuarioSitio;




class BecaOtorgadaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$becas = Beca::all();
		


		/*if (  MyAuth::check() )
		{
			//Aca algo voy a hacer
			//Levanto los datos el usuario
		}else{

	        return Redirect::to('/');
		}
		*/
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
            
		return view('beca.index')
		->with('becas',$becas)
		->with('search',$input);
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
	          //  ->toSql();
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


		return view('beca.listBecas')
		->with('becas',$becas)
		->with('search',$input);
	}


	public function verBecaOtorgada($id){

		//$input = Request::all();
		//echo "<pre>";
		//print_r($id);

		$helper = new Helper();
		$tipo_becas = $helper->getHelperByDominio('tipo_beca');
		$renovacion = $helper->getHelperByDominio('renovacion');
		$tipo_actividad = $helper->getHelperByDominio('tipo_actividad');
		$s_horaria = $helper->getHelperByDominio('s_horaria');
		$estado_beca = $helper->getHelperByDominio('estado_beca');
		$corresponde_si_no = $helper->getHelperByDominio('corresponde_si_no');
		$certificado = $helper->getHelperByDominio('certificado');


		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*',DB::raw('YEAR(beca.timestamp) as anio'))
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            
            $cargos = DB::table('cargo')->get();
            $universidades = DB::table('universidad_sigla')->get();
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
			$helpers['corresponde_si_no'] = $corresponde_si_no;
			$helpers['certificado'] = $certificado;
			
			$documentacion = Documentacion::traeDocumentacion($id);
			//echo $id;
			$actuaciones = DB::table('actuacion')->where('beca_id','=',$id)->get();
			$pasos_beca = DB::table('paso_beca')
			->join('t_paso_beca', 'paso_beca.tipo_paso_beca_id', '=', 't_paso_beca.t_paso_beca_id')
			->where('t_paso_beca.t_accion_id','=',1)
			->where('beca_id','=',$id)
			->orderBy('paso_beca.paso_beca_id','DESC')
			->get();

			$pasos_vencimiento_beca = DB::table('paso_beca')
			->join('t_paso_beca', 'paso_beca.tipo_paso_beca_id', '=', 't_paso_beca.t_paso_beca_id')
			->where('t_paso_beca.t_accion_id','=',2)
			->where('beca_id','=',$id)
			->orderBy('paso_beca.paso_beca_id','DESC')
			->get();
			
			//Trae pagos para esta beca

			$cheques = DB::table('beca')
						->join('pago_cheque', 'pago_cheque.beca_id', '=', 'beca.beca_id')
						->where('beca.beca_id','=',$id)
						//->orderBy('pago_cheque.reintegro','DESC')
			            //->toSql();
        				->get();

        	$importe_pago = self::getPAgoCheques($cheques);			
			$saldo = ($solicitud_beca[0]->otorgado) - $importe_pago;
			//echo "<pre>";
			//print_r($saldo);
			//exit;

		return view('otorgada.verBecaOtorgada')->with('beca',$solicitud_beca[0])->with('helpers',$helpers)
		->with('documentacion',$documentacion)
		->with('actuaciones',$actuaciones)
		->with('pasos_beca',$pasos_beca)
		->with('pasos_vencimiento_beca',$pasos_vencimiento_beca)
		->with('cheques',$cheques)
		->with('saldo',$saldo);

	}

private function getPAgoCheques($cheques){
	if( empty($cheques) ) return 0;
	$total = 0;
	
	foreach ($cheques as $cheque) {
		if($cheque->entregado_por_id !=0)
		$total += $cheque->importe;
	}

	return $total;
}
public function imprimirSolicitud($id){

		$helper = new Helper();
		$tipo_becas = $helper->getHelperByDominio('tipo_beca');
		$renovacion = $helper->getHelperByDominio('renovacion');
		$tipo_actividad = $helper->getHelperByDominio('tipo_actividad');
		$s_horaria = $helper->getHelperByDominio('s_horaria');
		$estado_beca = $helper->getHelperByDominio('estado_beca');

//echo "<pre>";
//print_r($estado_beca);

		$solicitud_beca = DB::table('beca')
            ->select('*')
            ->leftJoin('cargo','beca.cargo_id','=','cargo.car_id')
            ->leftJoin('dependencia','beca.dependencia_id','=','dependencia.dep_id')
            ->leftJoin('titulo','beca.titulo_id','=','titulo.titulo_id')
            ->leftJoin('universidad_sigla','beca.universidad_id','=','universidad_sigla.universidad_id')
            ->leftJoin('facultad','beca.facultad_id','=','facultad.facultad_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            
            $cargos = DB::table('cargo')->get();
            $universidades = DB::table('universidad_sigla')->get();
            $fuero = DB::table('fuero')->get();
			$titulos = DB::table('titulo')->get();
			$facultades = DB::table('facultad')->get();
			$dependencias = DB::table('dependencia')->get();

			
		return view('beca.imprimirSolicitudBeca')->with('beca',$solicitud_beca[0]);

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
		
		//guardo datos de beca, los de usuario_sitio hay que confirmar que datos se pueden modificar.
		$beca = Beca::find($input['_id']);
		$beca->titulo_id = $input['titulo_id'];
		$beca->domicilio_constituido = $input['domicilio'];
		$beca->cargo_id = $input['car_id'];
		$beca->fuero_id = $input['fuero_id'];
		$beca->universidad_id = $input['universidad_id'];
		$beca->universidad_otro = $input['universidad_otro'];
		$beca->facultad_id = $input['facultad_id'];
		$beca->facultad_otro = $input['facultad_otro'];
		$beca->titulo_id = $input['titulo_id'];
		$beca->titulo_otro = $input['titulo_otro'];
		$beca->otorgado = $input['monto_otorgado'];
		$beca->legajo_beca = $input['legajo_beca'];
		$beca->institucion_propuesta = $input['inst_prop_id'];
		$beca->presenta_ddjj = $input['presenta_ddjj'];
		$beca->informe_final = $input['informe_final'];
		$beca->copia_titulo = $input['copia_titulo'];
		$beca->certificado = $input['certificado'];
		$beca->actividad_nombre = $input['actividad_nombre'];
		$beca->f_ingreso_caba = $input['f_ingreso_caba'];
		$beca->dependencia_id = $input['dependencia_id'];
		$beca->dependencia_otro = $input['dependencia_otro'];
		$beca->telefono_laboral = $input['tel_laboral'];
		$beca->telefono_particular = $input['tel_particular'];
		$beca->observaciones_otorgada = $input['beca_observaciones_otorgada'];
		$beca->nro_disposicion = $input['nro_disposicion'];
		
		$beca->estado_id = $input['estado_id'];

		$beca->save();



		return redirect()->back()->with('edited',true);

	}


	public function addActuacion($id){
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);

		return view('otorgada.addActuacion')->with('beca_id',$id);

	}

	public function saveActuacion(){
		$input = Request::all();
		$actuacion = Actuacion::find($input['actuacion_id']);
		$actuacion->beca_id = $input['beca_id'];
		$actuacion->save();
		//return view('beca.verSolicitudBeca')->with('beca_id',$id);
		$url = 'verBecaOtorgada/'.$input['beca_id'];
		return Redirect::to($url);

	}

	
	public function enviarEmailDocumentacion(){
			
			$input = Request::all();

			//Trae datos de la beca
			$beca = Beca::find($input['beca_id']);

			//Trae datos del destinatario
			$datos_destinatario = DB::table('usuario_sitio')
            ->select('*')
            ->where('usuario_sitio.usi_id', '=', $beca['alumno_id'])
            ->get();

            $email = $datos_destinatario[0]->usi_email;	
            
            //Trae datos de Documentacion
			$documentacion = (array) Documentacion::traeDocumentacion($input['beca_id']);
			
			$documentacion_papeles = [];
			$doc = array_slice($documentacion, 2);   
			
			foreach ($doc as $key => $value) {
					//lo que falta
					if($value == 0) array_push($documentacion_papeles,$key);
			}
		
			if($beca->sup_horaria == 0) { 

				if(($key = array_search('autorizacion_superposicion', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
   			
				}
			}


			if($beca->renovacion_id == 2) { 

				if(($key = array_search('curriculum_vitae', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
				if(($key = array_search('informacion_actividad', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
				if(($key = array_search('copia_titulo', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
			}
			
			if($beca->estado_id == 2){

				$html = $this->arma_html($datos_destinatario[0],$documentacion_papeles);
				$this->agregaAccion(1,$beca->beca_id);
				$res = $this->enviaEmail($datos_destinatario,$html);

			}/*else if($beca->estado_id == 3){

				$html = $this->arma_html_completo($datos_destinatario[0],$documentacion_papeles);
				$this->agregaAccion(1,$beca->beca_id);
				$res = $this->enviaEmail($datos_destinatario,$html);
			}*/else{
				return 'No hay nada para mandar';
			}
			
			$res_html = ($res)?'<b>Email enviado con &eacute;xito</b>':'<br><br><b>Oh no, ocurrí&oacute; un error, comun&iacute;quese con el administrador</b>';

			

			return $res_html;

	}
	private function agregaAccion($tipo_paso_beca_id,$beca_id){
		//Agrega accion que envio email

		$paso_beca = new PasoBeca();
		$paso_beca->beca_id = $beca_id;
		$paso_beca->tipo_paso_beca_id = $tipo_paso_beca_id;
		$paso_beca->save();

		return true;
	}

	
	public function addPasoVencimientoBeca($id){
		
		//$input = Request::all();
		$t_pasos = DB::table('t_paso_beca')->where('t_accion_id','=',2)->OrderBy('orden')->get();

		$firmantes = Agente::getFirmantes();
		$beca = Beca::find($id);
		/*echo "<pre>";
		print_r($beca->alumno_id);*/
		$nombre = UsuarioSitio::traeNombreById($beca->alumno_id);

		return view('otorgada.addPasoVencimientoBeca')
		->with('t_pasos',$t_pasos)
		->with('beca_id',$id)
		->with('nombre',$nombre)
		->with('firmantes',$firmantes);

	}

	public function addPasoBeca($id){
		
		//$input = Request::all();
		$t_pasos = DB::table('t_paso_beca')->where('t_accion_id','=',1)->OrderBy('orden')->get();

		return view('otorgada.addPasoBeca')->with('t_pasos',$t_pasos)->with('beca_id',$id);

	}

	public function savePasoBeca(){
		$input = Request::all();
		
		$paso_beca = new PasoBeca();
		$paso_beca->beca_id = $input['beca_id'];
		$paso_beca->tipo_paso_beca_id = $input['tipo_paso_beca_id'];
		$paso_beca->fecha = $input['paso_beca_fecha'];
		$paso_beca->observaciones = $input['paso_beca_observaciones'];
		$paso_beca->fecha_vencimiento = (isset($input['paso_beca_fecha_vencimiento']))?$input['paso_beca_fecha_vencimiento']:'';

		$paso_beca->firmante_id = (isset($input['firmante_id']))?$input['firmante_id']:0;

		$paso_beca->texto_email = $input['paso_texto_email'];
		$paso_beca->save();


		$url = 'editPasoBecaVencimiento/'.$paso_beca->paso_beca_id;
		return Redirect::to($url);
	}

	public function deletePasoBeca($id){

		$paso_beca = PasoBeca::find($id);
		$paso_beca->delete();

		return redirect()->back();
	}	

	public function editPasoBeca($id){

		$paso_beca = PasoBeca::find($id);
		
		$t_pasos = DB::table('t_paso_beca')->where('t_accion_id','=',1)->OrderBy('orden')->get();


		return view('otorgada.editPasoBeca')
		->with('t_pasos',$t_pasos)
		->with('paso_beca',$paso_beca);
	}	

	public function updatePasoBeca(){
		
		$input = Request::all();
		
		$paso_beca = PasoBeca::find($input['paso_beca_id']);
		//$paso_beca->beca_id = $input['beca_id'];
		$paso_beca->tipo_paso_beca_id = $input['tipo_paso_beca_id'];
		$paso_beca->observaciones = $input['paso_beca_observaciones'];
		$paso_beca->fecha = $input['paso_beca_observaciones'];
		$paso_beca->save();

		//return view('beca.verSolicitudBeca')->with('beca_id',$id);
		$url = 'verBecaOtorgada/'.$input['beca_id'];
		return Redirect::to($url);
	}



	public function editPasoBecaVencimiento($id){

		$paso_beca = PasoBeca::find($id);
		
		$t_pasos = DB::table('t_paso_beca')->where('t_accion_id','=',2)->OrderBy('orden')->get();

		$firmantes = Agente::getFirmantes();

		return view('otorgada.editPasoBecaVencimiento')
		->with('t_pasos',$t_pasos)
		->with('paso_beca',$paso_beca)
		->with('firmantes',$firmantes);

	}	

	public function updatePasoBecaVencimiento(){
		
		$input = Request::all();
		
		$paso_beca = PasoBeca::find($input['paso_beca_id']);
		
		//$paso_beca->beca_id = $input['beca_id'];
		$paso_beca->tipo_paso_beca_id = $input['tipo_paso_beca_id'];
		$paso_beca->observaciones = $input['paso_beca_observaciones'];
		$paso_beca->fecha = $input['paso_beca_fecha'];
		$paso_beca->fecha_vencimiento = (isset($input['paso_beca_fecha_vencimiento']))?$input['paso_beca_fecha_vencimiento']:'';
		$paso_beca->texto_email = $input['paso_texto_email'];

		$paso_beca->firmante_id = (isset($input['firmante_id']))?$input['firmante_id']:0;

		$paso_beca->save();

		//return view('beca.verSolicitudBeca')->with('beca_id',$id);
		//$url = 'verBecaOtorgada/'.$input['beca_id'];
		//return Redirect::to($url);
		return 1;
	}

	public function previewEmailDocumentacion(){

			$input = Request::all();

			//Trae datos de la beca
			$beca = Beca::find($input['beca_id']);

			//Trae datos del destinatario
			$datos_destinatario = DB::table('usuario_sitio')
            ->select('*')
            ->where('usuario_sitio.usi_id', '=', $beca['alumno_id'])
            ->get();

            $email = $datos_destinatario[0]->usi_email;	
            
            //Trae datos de Documentacion
			$documentacion = (array) Documentacion::traeDocumentacion($input['beca_id']);
			
			$documentacion_papeles = [];
			$doc = array_slice($documentacion, 2);   
			
			foreach ($doc as $key => $value) {
					//lo que falta
					if($value == 0) array_push($documentacion_papeles,$key);
			}
		
			if($beca->sup_horaria == 0) { 

				if(($key = array_search('autorizacion_superposicion', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
   			
				}
			}


			if($beca->renovacion_id == 2) { 

				if(($key = array_search('curriculum_vitae', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
				if(($key = array_search('informacion_actividad', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
				if(($key = array_search('copia_titulo', $documentacion_papeles)) !== false) {
    			unset($documentacion_papeles[$key]);
				}
			}
			 
			//Se arman dos emails, si esta compĺeto o incompleto
			if( $beca->estado_id == 2) {
				$html = $this->arma_html($datos_destinatario[0],$documentacion_papeles);	
			}/*else if($beca->estado_id == 3){
				$html = $this->arma_html_completo($datos_destinatario[0]);	
			}*/else{
				return '';
			}
			
			return $html;

	}


	private function arma_html($datos_destinatario,$documentacion_papeles){

		$html_email = "Estimado/a: ".$datos_destinatario->usi_nombre."<br>"."<p>Nos comunicamos con Ud. con motivo de la solicitud de beca en tr&aacute;mite ante este Centro. <br>
		Del an&aacute;lisis de su presentaci&oacute;n surge que a la fecha le falta acompa&ntilde;ar la siguiente documentaci&oacute;n:</p>";

		$documentacion_labels = ['formulario_solicitud'=>'Formulario de Solicitud de Beca.','copia_titulo'=>'Copia Certificada del T&iacute;tulo Universitario.'
		,'dictamen_evaluativo'=>'Dictamen Evaluativo del funcionario superior jer&aacute;rquico de la dependencia donde desempe&ntilde;e sus funciones, que contenga -de corresponder- la conformidad requerida por el Art. 12, 2&deg; p&aacute;rrafo del Reglamento.',
		 'informacion_actividad'=>'Informaci&oacute;n de Actividad emitida por la instituci&oacute;n donde se pretende cursar los estudios con sus contenidos, carga horaria, días y horarios de cursos y costos'
		 ,'certificado_laboral'=>' Certificado Laboral en el que conste la situaci&oacute;n de revista del aspirante y antig&uuml;edad en el cargo y remuneraci&oacute;n.'
		,'autorizacion_superposicion'=>'Autorizaci&oacute;n por superposici&oacute;n horaria, del Presidente del Consejo de la Magistratura, Fiscal General, Defensor General, Asesor General Tutelar o Presidente del Tribunal Superior de Justicia de la Ciudad Aut&oacute;noma de Buenos Aires, seg&uacute;n corresponda, con indicaci&oacute;n expresa de la modalidad de recupero de las horas de trabajo.'
		,'curriculum_vitae'=>'Curriculum Vitae.'];
		
		$html_email .= "<ul>";
		//echo "<pre>";
		//print_r($documentacion_papeles);
		foreach ($documentacion_papeles as $key => $value) {
			
					$html_email = $html_email."<li>".$documentacion_labels[$value]."</li>";				
		}	
		$html_email .= "</ul>";
		$html_email .= 'Cordialmente, <br>';
		$html_email .= '<p style="font-size:14px">
		Departamento de Coordinaci&oacute;n de Convenios, Becas y Publicaciones.
		</p>
 		<br>
		<div align="center"><b><i style="font-size:12px">
		Bolivar 177 Piso 3ro -  Ciudad Aut&oacute;noma de Buenos Aires  -   CP: C1066AAC   -  Tel: 4008-0284  -  Email: becas@jusbaires.gov.ar
		</i></b><div>';
		//$html_email .= '<i>Por favor, NO responda a este mensaje, es un env&iacute;o autom&aacute;tico. Por cualquier inconveniente comuniques</i>';
		return $html_email;
	}

	private function arma_html_completo($datos_destinatario){

		$html_email = "Estimado/a: ".$datos_destinatario->usi_nombre."<br>"."<p>Nos comunicamos con Ud. con motivo de la solicitud de beca en tr&aacute;mite ante este Centro. <br>
		Del an&aacute;lisis de su presentaci&oacute;n surge que a la fecha se encuentra toda la documentaci&oacute;n presentada.</p>";

		$html_email .= 'Cordialmente, <br>';
		$html_email .= '<p style="font-size:14px">
		Departamento de Coordinaci&oacute;n de Convenios, Becas y Publicaciones.
		</p>
 		<br>
		<div align="center"><b><i style="font-size:12px">
		Bolivar 177 Piso 3ro -  Ciudad Aut&oacute;noma de Buenos Aires  -   CP: C1066AAC   -  Tel: 4008-0284  -  Email: becas@jusbaires.gov.ar
		</i></b><div>';
		//$html_email .= '<i>Por favor, NO responda a este mensaje, es un env&iacute;o autom&aacute;tico. Por cualquier inconveniente comuniques</i>';
		return $html_email;
	}
	private function enviaEmail($datos_destinatario,$html){

		//$to      = $datos_destinatario[0]->usi_email;
		$to = $datos_destinatario; //ESTO NO SE COMO LO VOY A IMPLEMENTAR
		$subject = 'NOTIFICACION BECA 2016';
		$message = $html;
		$headers = 'From: becas@jusbaires.gov.ar' . "\r\n" .
   			   'Reply-To: becas@jusbaires.gov.ar' . "\r\n" .
			   'Bcc: gcaserotto@jusbaires.gov.ar' . "\r\n" .
			   'Return-Path: return@jusbaires.gov.ar' . "\r\n" .
			   'MIME-Version: 1.0' . "\r\n" .
			   'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
			   'X-Mailer: PHP/' . phpversion();

		$res = mail($to, $subject, $message, $headers);
		//echo $to;
		//	print_r($message);

		//ver error 

		return $res;
	}


	public function enviarEmailIntimacion(){

		$input = Request::all();
		$data = PasoBeca::find($input['paso_beca_id']);

		//$data = DB::table('paso_beca')->where('paso_beca_id',$input['paso_beca_id'])->first();
		$data->notificado = 1;

		if( $data->fecha_envio == 0)
		$data->fecha_envio = Utils::now();
		
		$data->save();
		//print_r($data);

		$data_beca = DB::table('beca')->where('beca_id',$data->beca_id)->first();

	//	print_r($data_beca->alumno_id);
		$alumno_id = $data_beca->alumno_id;

		$data_destinatario = DB::table('usuario_sitio')
            ->select('*')
            ->where('usuario_sitio.usi_id', '=', $alumno_id)
            ->first();
	
		$datos_destinatario = $data_destinatario->usi_email;
		

		if(empty($datos_destinatario)) return 'false';
		
		$html = $data->texto_email;

		$res = $this->enviaEmail($datos_destinatario,$html);
		
		$res_html = ($res)?'<b>Email enviado con &eacute;xito</b>':'<br><br><b>Oh no, ocurrí&oacute; un error, comun&iacute;quese con el administrador</b>';

		return $res_html;
	}





	public function listadoBecas(){ //HORRIBLE

		$input = Request::all();
		
		$str = (isset($input['str_beca']))?$input['str_beca']:'';
		
		$input['estado_id'] = (isset($input['estado_id']))?$input['estado_id']:'-1';

		if(!isset($input['buscar'])){
		
			$data = DB::table('beca')
	            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
	            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
	            ->select('*')
	            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
                ->where('beca.otorgada','=',1 )
				->where(DB::raw('YEAR(beca.timestamp)'), '=',DB::raw('YEAR(now())') )
	            ->orderBy('beca.beca_id','DESC')
	            //->toSql();
	            ->paginate(20);
	            
		
		}else{

				if($input['estado_id'] == -1){
					$data = DB::table('beca')
			            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
			            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
			           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
			            ->select('*')
			            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
		                ->where('beca.otorgada','=',1 )
						//->where(DB::raw('YEAR(beca.timestamp)'), '=',DB::raw('YEAR(now())') )
			           // ->groupBy('cargo.car_nombre')
			            ->orderBy('beca.beca_id','DESC')
			            //->toSql();
			            //print_r($data);
			            ->paginate(20); // El paginate funciona como get()
			            //->get(); 
		        	
				}else{
				$data = DB::table('beca')
		            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
		            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
		            ->select('*')
		            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
		            ->where('beca.estado_id', '=', $input['estado_id'])
					->where('beca.otorgada','=',1 )
					//->where(DB::raw('YEAR(beca.timestamp)'), '=',DB::raw('YEAR(now())') )
		            ->orderBy('beca.beca_id','DESC')
		           // ->toSql();
		            ->paginate(20); // El paginate funciona como get()

		        }
		}

		
            $becas = $data;

            $becas->setPath('listadoBecas');
            $becas->appends(array('estado_id' => $input['estado_id'],'str_beca' => $str));
            

         $helpers = self::traeHelpers();    

		return view('otorgada.listadoBecas')
		->with('becas',$becas)
		->with('helpers',$helpers)
		->with('search',$input);

	}

		private static function traeHelpers(){


			$helper = new Helper();
			$tipo_beca = $helper->getHelperByDominio('tipo_beca');
			$renovacion = $helper->getHelperByDominio('renovacion');
		    $estado_beca = $helper->getHelperByDominio('estado_beca');

		    $helpers = array();
			$helpers['renovacion'] = $renovacion;
			$helpers['estado_beca'] = $estado_beca;
			$helpers['tipo_beca'] = $tipo_beca;

		return $helpers;
	}

	public function busquedaAvanzada()
	{
		$input = Request::all();
		
		$helpers = self::traeHelpers();
		
		
		$query = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
            ->where('otorgada','=','1');

        $query->select('*');
       
        if(!empty($input['renovacion_id'])) $query->where('beca.renovacion_id', '=', $input['renovacion_id']);	
        if(!empty($input['estado_id'])) $query->where('beca.estado_id', '=', $input['estado_id']);	
        if(!empty($input['tipo_beca_id'])) $query->where('beca.tipo_beca_id', '=', $input['tipo_beca_id']);	
		if(!empty($input['anio'])) $query->where(DB::raw('YEAR(beca.timestamp)'), '=', $input['anio']);	
		            

        
        $data = $query->orderBy('beca.beca_id','DESC')->paginate(500);
           
        $becas = $data;

        // $becas->setPath('listSolicitudesBecas');
        // $becas->appends(array('estado_id' => $input['estado_id'],'str_beca' => $str));
            
		return view('otorgada.listadoBecas')->with('becas',$becas)->with('helpers',$helpers);
	}

	public function eliminarVinculoActuacion($id)
	{
		//Traigo actuacion y desasocio la beca de la tabla actuacion (beca_id)
		
		$actuacion = Actuacion::find($id);
		$actuacion->beca_id = null;
		$actuacion->save();

		return redirect()->back();
	}


	public function traeTextoPaso(){
		$input = Request::all();

		$pasos_beca = DB::table('t_paso_beca')->where('t_paso_beca_id','=',$input['id'])->first();
		
		//Trae el texto

		echo $pasos_beca->email_texto;
	}

	public function traeFirmaTexto(){
		$input = Request::all();

		$firma_texto = DB::table('agente')->where('agente_id','=',$input['id'])->first();
		//print_r($input);
		//Trae el texto

		echo $firma_texto->firma_texto;
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

	public function exportar(){
	$input = Request::all();
	//Bastante desprolijo

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
		
		//Primer busqueda, uso parametro de busqueda
		$input['estado_id'] = (isset($input['estado_id']))?$input['estado_id']:'-1';
		
		//if($input['estado_id'] == -1 && empty($str)){
		if(!isset($input['busqueda'])){
			$data = DB::table('beca')
	            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
	            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
	            ->leftJoin('dependencia','beca.dependencia_id','=','dependencia.dep_id')
	            ->leftJoin('titulo','beca.titulo_id','=','titulo.titulo_id')
    	        ->leftJoin('universidad_sigla','beca.universidad_id','=','universidad_sigla.universidad_id')
        	    ->leftJoin('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
	            ->select('*')
	            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
                ->where('beca.estado_id', '<>', 0)
                ->where('beca.otorgada', '=', 0)
				->where(DB::raw('YEAR(beca.timestamp)'), '=', DB::raw('YEAR(now())')) //SIEMPRE TRAE LAS DEL CORRIENTE AÑO
	            ->orderBy('beca.beca_id','DESC')
	            ->get(); 
        	
		}else{
		//Busqueda por dos parametros	
		$query = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
            ->leftJoin('dependencia','beca.dependencia_id','=','dependencia.dep_id')
            ->leftJoin('titulo','beca.titulo_id','=','titulo.titulo_id')
            ->leftJoin('universidad_sigla','beca.universidad_id','=','universidad_sigla.universidad_id')
            ->leftJoin('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
            
            ->where('beca.estado_id', '<>', 0);

           if($input['estado_id'] > 0 ) $query->where('beca.estado_id', '=', $input['estado_id']);	
        
            $query->orderBy('beca.beca_id','DESC');
        
            $data = $query->get();
        
        }
           
        
	/*
		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
            ->leftJoin('dependencia','beca.dependencia_id','=','dependencia.dep_id')
            ->leftJoin('titulo','beca.titulo_id','=','titulo.titulo_id')
            ->leftJoin('universidad_sigla','beca.universidad_id','=','universidad_sigla.universidad_id')
            ->leftJoin('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')

            ->select('*')
            //->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
            //->where('beca.estado_id', '=', $input['estado_id'])
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            ->get();
     
    */



     $excel = array();
     $row = array();
	 //echo "<pre>";
     foreach($data as $registro){
     	

     	//print_r($registro);
     	$row['nombre y apellido'] = $registro->usi_nombre;
     	$row['Nro de Actuacion'] = '';
		$row['Identificador de Legajo'] = '';
		$row['DNI'] = $registro->usi_dni;
		$row['Domicilio'] = $registro->domicilio_constituido;
		$row['Telefono'] = $registro->telefono_laboral;
		$row['Correo electronico'] = $registro->usi_email;
		$row['Antiguedad'] = '';
		$row['Titulo de grado'] = $registro->titulo;
		$row['Dictamen evaluativo del superior jerarquico'] = $registro->dictamen_por;
		$row['Curriculum Vitae'] = '';
		$row['Superposicion horaria: si/no'] = ($registro->sup_horaria == 1)?'SI':'NO';
		$row['Autorizacion de presidencia, etc.: si/no'] = '';
		$row['Estudio a realizar a mas de 50 km CABA'] = '';
		$row['Renovacion'] = ($registro->renovacion_id == 2)?'SI':'NO';
		$row['Segunda carrera en adelante'] = '';
		$row['Cargo'] = $registro->car_nombre;
		$row['Dependencia'] = $registro->dep_nombre;
		$row['Origen'] = '';
		$row['Remuneracion'] = '';
		$row['Carrera'] = $registro->actividad_nombre;
		$row['Universidad'] = Helper::getInstitucionPropuestaId($registro->institucion_propuesta);
		$row['Duracion'] = $registro->duracion;
		$row['Convenio: si/no'] = '';
		$row['Beca: si/no'] = '';
		$row['Valor de la carrera'] = $registro->costo;
		$row['Valor con convenio o beca'] = '';
		$row['Monto solicitado'] = $registro->monto;
		$row['Maximo por Art. 7 - Reg. Becas'] = '';
		$row['Monto otorgable'] = '';
		$row['Monto final'] = '';
		$row['Monto adicional'] = '';
		$row['Monto desafectado'] = '';
		$row['Normativa que otorga o deniega la beca'] = '';
		$row['Renuncia Total/Parcial'] = '';
		$row['Caducidad'] = '';
		$row['Reintegro/s.'] = '';
		$row['Estado'] = Helper::getHelperByDominioAndId('estado_beca',$registro->estado_id);


     	$excel[] = $row;
     }
     
     	//print_r($dat);
     	//foreach ($registro as $key =>$valor) {
			
		

     	
     	//}
     		//$excel[] = $row;
    $data = $excel;
    
	//echo "<pre>";
	//print_r($excel);
	//exit;
	return view('otorgada.exportar')->with('data',$data);

}


}
