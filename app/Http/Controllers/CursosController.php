<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use App\domain\Utils;
use App\CursoUsuarioSitio;

class CursosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listarCursos()
	{
		
		$input = Request::all();

		//Trae cursos activos
		 $query = DB::table('curso')
            ->join('grupo_curso3_grupo_curso2', 'grupo_curso3_grupo_curso2.gcu32_id', '=', 'curso.cur_gcu32_id')
            ->join('grupo_curso3', 'gcu3_id', '=', 'gc32_gcu3_id')
            ->join('grupo_curso2', 'gc32_gcu2_id', '=', 'gcu2_id')
            ->join('grupo_curso', 'gcu2_gcu_id', '=', 'gcu_id')
            ->select('*' )
            
            ->orderBy('cur_fechaInicio','ASC');
        

        	if(!isset($input['_search'])){
        		$query->where(DB::raw('YEAR(cur_fechaInicio)'), '=', DB::raw('YEAR(now())')) //SIEMPRE TRAE LAS DEL CORRIENTE AÑO
        		->where('cur_ecu_id', '=', 1);
        	} 
            
            //Si uso el filtro
            if(isset($input['_search'])){
            	$query->where('grupo_curso3.gcu3_titulo','like',"%$input[str_curso]%");
            	
            	if($input['anio'] > 0) $query->where(DB::raw('YEAR(cur_fechaInicio)'), '=', $input['anio']);
            } 

            //->groupBy('gcu_nombre')
            //->toSql();
            $cursos = $query->get();

          $cant = sizeof($cursos);  
       	return view('cursos.listarCursos')
			->with('cursos',$cursos)
			->with('cant',$cant);
	}


	public function verInscriptosCurso($cur_id){


		return view('cursos.verInscriptosCurso')
		->with('cur_id',$cur_id);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listarUsuariosCurso($cur_id)
	{

		$input = Request::all();

		/*select count(*) as inscriptos 
		from curso_usuario_sitio 
		inner join curso on curso.cur_id = curso_usuario_sitio.cus_cur_id 
		inner join usuario_sitio on usuario_sitio.usi_id = curso_usuario_sitio.cus_usi_id 
		where curso.cur_id = $curso[cur_id] and cus_habilitado =1
		*/
		
		//Trae usuarios anotados al curso
		 
		$inscriptos = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->select('*')
            ->where('curso.cur_id', '=', $cur_id)
            ->orderBy('cus_validado','ASC')
            //->where('curso_usuario_sitio.cus_habilitado', '=', 1)
            //->toSql();
            ->get();

            //echo "<pre>";
            //print_r($inscriptos);

		return view('cursos.listarUsuariosCurso')
		->with('inscriptos',$inscriptos)
		->with('cur_id',$cur_id);
		
		
	}

	public function traeDataCurso($cur_id){

		/*select *
from curso
inner join grupo_curso3_grupo_curso2 on (gcu32_id = cur_gcu32_id)
inner join grupo_curso3 on (gcu3_id = gc32_gcu3_id)
where curso.cur_id = 378*/

		//trae los inscriptos del curso

		$inscriptos = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('grupo_curso3_grupo_curso2', 'grupo_curso3_grupo_curso2.gcu32_id', '=', 'curso.cur_gcu32_id')
            ->join('grupo_curso3', 'gcu3_id', '=', 'gc32_gcu3_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->select('*')
            ->where('curso.cur_id', '=', $cur_id)
            
            //->where('curso_usuario_sitio.cus_habilitado', '=', 1)
            //->toSql();
            ->get();

            $total = sizeof($inscriptos);
            $validados = 0;
            foreach($inscriptos as $inscripto) {
            	if($inscripto->cus_validado== 'Si') $validados++;
            }
            $por_validar = $total - $validados;
            
            
            $data['total'] = $total;
            $data['validados'] = $validados; 
            $data['por_validar'] = $por_validar;
            $data['titulo'] = $inscriptos[0]->gcu3_titulo;
            $data['cur_fechaInicio'] = $inscriptos[0]->cur_fechaInicio;
            $data['cur_fechaFin'] = $inscriptos[0]->cur_fechaFin;
           // echo "<pre>";
           // print_r($b);
            
		return $data;
	}

	public function validarUsuarioCurso(){
		
		$input = Request::all();
		
		$cus_id = $input['cus_id'];
		$curso_usuario = CursoUsuarioSitio::find($cus_id);
		$curso_usuario->cus_validado = 'Si';
		$curso_usuario->save();
		
		return 'true'; //Debería devolver estado si hay error o exito
	}

	public function rechazarUsuarioCurso(){
		
		$input = Request::all();
		
		$cus_id = $input['cus_id'];
		$curso_usuario = CursoUsuarioSitio::find($cus_id);
		$curso_usuario->cus_validado = '-';
		$curso_usuario->save();
		
		return 'true';
	}

	public function validarTodosCurso(){
		
		$input = Request::all();
		
		$cus_cur_id = $input['cus_cur_id'];
		
		
		$curso_usuario = CursoUsuarioSitio::where('cus_cur_id',$cus_cur_id)->where("cus_validado","=","-");//->get();
		
		$curso_usuario->update(array("cus_validado"=>"Si"));
		
		return 'true';
		
	}
	

	public function traeDataAltaAlumno(){

		

		$input = Request::all();
		$cur_id = $input['cur_id'];
		$q = $input['q'];
		$res['items'] = '';

        /*select * from usuario_sitio where usuario_sitio.usi_id not in (SELECT cus_usi_id FROM curso_usuario_sitio where cus_cur_id=378)*/

        				$cursos = $data = DB::table('usuario_sitio')
							->where('usi_nombre','like','%'.$q.'%')
							->orWhere('usi_dni','like','%'.$q.'%')
							->orWhere('usi_email','like','%'.$q.'%')
							->whereNotIn('usuario_sitio.usi_id',function($query) use($cur_id){

							    $query->select('cus_usi_id')
							    ->from('curso_usuario_sitio')
							    ->where('cus_cur_id', $cur_id);

							})
							->orderBy('usuario_sitio.usi_nombre','DESC')
							//->toSql();
            				->get();
        
		//print_r($cursos);
		
		foreach ($cursos as $key => $value) {
					
			$res['items'][] = array("id"=>$value->usi_id, "name"=>$value->usi_nombre,"dni"=>$value->usi_dni,"email"=>$value->usi_email);
		}
	
		$res['total_counts'] = sizeof($res['items']);
		
	
		echo json_encode($res);

	}
	
	public function addAlumnoCurso(){

		$input = Request::all();
		//Agrego los id en la tabla curso_usuario_sitio

		$curso_usuario_sitio = new CursoUsuarioSitio();
		$curso_usuario_sitio->cus_usi_id = $input['usi_id'];
		$curso_usuario_sitio->cus_cur_id = $input['cur_id'];
		$curso_usuario_sitio->save();


		return 'true';
	}


}
