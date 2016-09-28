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
            ->where('cur_ecu_id', '=', 1)
            ->orderBy('cur_fechaInicio','ASC');
        
            //Si uso el filtro
            if(isset($input['_search'])) $query->where('grupo_curso3.gcu3_titulo','like',"%$input[str_curso]%");

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
		
		
		$curso_usuario = CursoUsuarioSitio::where('cus_cur_id',$cus_cur_id);//->get();
		
		$curso_usuario->update(array("cus_validado"=>"Si"));
		
		return 'true';
		
	}
	
	

}
