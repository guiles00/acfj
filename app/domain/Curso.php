<?php namespace App\Domain;

use DB;

class Curso {

	public static function siNo($boolean){
		return ($boolean == 0)? 'NO':'SI';

	}

	public static function cantidadInscriptos($cur_id){

		/*	select count(*) as inscriptos 
		from curso_usuario_sitio 
		inner join curso on curso.cur_id = curso_usuario_sitio.cus_cur_id 
		inner join usuario_sitio on usuario_sitio.usi_id = curso_usuario_sitio.cus_usi_id 
		where curso.cur_id = $curso[cur_id] and cus_habilitado =1";
		*/


		$cantidad = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->select('*')
            ->where('curso.cur_id', '=', $cur_id)
            ->where('curso_usuario_sitio.cus_habilitado', '=', 1)
            //->groupBy('gcu_nombre')
            //->toSql();
            ->get();
            
            //echo "<pre>";
            return sizeof($cantidad);
	}

	public static function cantidadValidados($cur_id){

		/*	select count(*) as inscriptos 
		from curso_usuario_sitio 
		inner join curso on curso.cur_id = curso_usuario_sitio.cus_cur_id 
		inner join usuario_sitio on usuario_sitio.usi_id = curso_usuario_sitio.cus_usi_id 
		where curso.cur_id = $curso[cur_id] and cus_habilitado =1";
		*/


		$cantidad = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->select('*')
            ->where('curso.cur_id', '=', $cur_id)
            ->where('curso_usuario_sitio.cus_habilitado', '=', 1)
            ->where('curso_usuario_sitio.cus_validado', '=', 'Si')
            //->groupBy('gcu_nombre')
            //->toSql();
            ->get();
            
            //echo "<pre>";
            return sizeof($cantidad);
	}

	public static function traeAreaById($usi_fuero_id){

		$area = DB::table('fuero')
            ->where('fuero_id', '=', $usi_fuero_id)
            //->toSql();
            ->first();
        if(empty($area)) return '';
		return $area->fuero_nombre;
	}


	public static function traeDependenciaById($usi_dep_id){

		$dep = DB::table('dependencia')
            ->where('dep_id', '=', $usi_dep_id)
            //->toSql();
            ->first();
		if(empty($dep)) return '';
		return $dep->dep_nombre;
	}


	public static function traeCargoById($usi_car_id){

		$cargo = DB::table('cargo')
            ->where('car_id', '=', $usi_car_id)
            //->toSql();
            ->first();

		if(empty($cargo)) return '';
		return $cargo->car_nombre;
	}
}
?>