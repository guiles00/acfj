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

	

      $res = DB::table('capacitador')
							->where('capacitador.capacitador_id','=',$capacitador_id)
							//->toSql();
							->get();

		if(empty($res)) return '';							

		return  $res[0]->apellido.', '.$res[0]->nombre ;
	}
	
	
	public static function getDatosDocenteById($capacitador_id){

	

      $res = DB::table('capacitador')
							->where('capacitador.capacitador_id','=',$capacitador_id)
							//->toSql();
							->get();


		if(empty($res)) return '';							

		return  $res[0];
	}

	public static function getDatosCursoById($curso_id){

	$res = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							//->where('gcu3_titulo','like','%'.$q.'%')
							->where('curso.cur_id','=',$curso_id)
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();

		if(empty($res)) return '';							

		return  $res[0];
	}

	public static function getNombreCursoById($curso_id){

	$res = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
							//->where('gcu3_titulo','like','%'.$q.'%')
							->where('curso.cur_id','=',$curso_id)
							->orderBy('curso.cur_gcu3_id','DESC')
							//->toSql();
            				->get();
            				
		if(empty($res)) return '';							

		return  $res[0]->gcu3_titulo;
	}

}
?>