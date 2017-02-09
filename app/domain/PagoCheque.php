<?php namespace App\Domain;

use DB;

class PagoCheque {


	public static function getNombreBecario($beca_id){


      $res = DB::table('usuario_sitio')
							->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							->where('beca.beca_id','like',$beca_id)
							->get();

		if(empty($res)) return '';							
		
		return  $res[0]->usi_nombre;
	}

	
	public static function getDatosBecario($beca_id){


      $res = DB::table('usuario_sitio')
							->join('beca', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
							->where('beca.beca_id','like',$beca_id)
							->get();

		if(empty($res)) return false;							
		
		return  $res[0];
	}

	public static function getNroMemoById($remitidos_id){

		/*echo 'remitidos_id';
			echo $remitidos_id;
*/

      $res = DB::table('remitidos')
							->where('remitidos.remitidos_id','=',$remitidos_id)
							//->toSql();
							->get();

		if(empty($res)) return '';							

		return  'MEMO CFJ N° '.$res[0]->numero_memo.'/16';
	}

	public static function getDisponibleChequeById($disponible_id){

	
      /*$res = DB::table('remitidos')
							->where('remitidos.remitidos_id','=',$remitidos_id)
							//->toSql();
							->get();
		*/
	  
	  	if($disponible_id == 1 ) return 'SI';							

		return  'NO';
	}
	
	public static function getEntregadoChequeById($entregado_por_id){

	
      /*$res = DB::table('remitidos')
							->where('remitidos.remitidos_id','=',$remitidos_id)
							//->toSql();
							->get();
		*/
	 // echo $entregado_por_id;
	  	if($entregado_por_id == 0 ) return 'NO';							

		return  'SI';
	}

	public static function getNombreDocenteById($capacitador_id){

	

      $res = DB::table('docente')
							->where('docente.doc_id','=',$capacitador_id)
							//->toSql();
							->get();

		if(empty($res)) return '';							

		return  $res[0]->doc_apellido.' '.$res[0]->doc_nombre ;
	}
	
	
	public static function getDatosDocenteById($capacitador_id){

	

      $res = DB::table('docente')
							->where('docente.doc_id','=',$capacitador_id)
							//->toSql();
							->get();


		if(empty($res)) return '';							

		return  $res[0];
	}

	public static function getDatosCursoById($curso_id){

/*	$res = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							//->where('gcu3_titulo','like','%'.$q.'%')
							->where('curso.cur_id','=',$curso_id)
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();

*/
	$res = $data = DB::table('curso')
							->leftJoin('grupo_curso3_grupo_curso2', 'grupo_curso3_grupo_curso2.gcu32_id', '=', 'curso.cur_gcu32_id')
							->leftJoin('grupo_curso3', 'grupo_curso3.gcu3_id', '=', 'grupo_curso3_grupo_curso2.gc32_gcu3_id')
							->leftJoin('grupo_curso2', 'grupo_curso2.gcu2_id', '=', 'grupo_curso3.gcu3_gcu2_id')
							->where('curso.cur_id','=',$curso_id)
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();



		if(empty($res)) return '';							

		return  $res[0];
	}

	public static function getNombreCursoById($curso_id){

/*	$res = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							//->where('gcu3_titulo','like','%'.$q.'%')
							->where('curso.cur_id','=',$curso_id)
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();
*/
	$res = $data = DB::table('curso')
				->leftJoin('grupo_curso3_grupo_curso2', 'grupo_curso3_grupo_curso2.gcu32_id', '=', 'curso.cur_gcu32_id')
				->leftJoin('grupo_curso3', 'grupo_curso3.gcu3_id', '=', 'grupo_curso3_grupo_curso2.gc32_gcu3_id')
				->leftJoin('grupo_curso2', 'grupo_curso2.gcu2_id', '=', 'grupo_curso3.gcu3_gcu2_id')
				->where('curso.cur_id','=',$curso_id)
				->orderBy('curso.cur_gcu3_id','DESC')
				//->toSql();
				->get();            				
            				
		if(empty($res)) return '';							

		return  $res[0]->gcu3_titulo;
	}

	public static function getNombreSubgrupoById($curso_id){

			$res = $data = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
							->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
							->where('curso.cur_id','=',$curso_id)
							//->toSql();
            				->get();
            				
		if(empty($res)) return '';							

		return  htmlentities($res[0]->gcu2_nombre);
	}

	public static function getMemoById($remitidos_id){

	
	$res = DB::table('remitidos')
							->join('helper', 'remitidos.tipo_remitido_id', '=', 'helper.dominio_id')
							->where('helper.dominio','=','tipo_memo')
							->where('remitidos_id','=',$remitidos_id)
							->get();
      

		if(empty($res)) return '';							

		return  $res[0]->nombre.' '.$res[0]->numero_memo.'/'.$res[0]->anio;
	}

	

}
?>