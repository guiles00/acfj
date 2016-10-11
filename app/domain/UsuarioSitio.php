<?php namespace App\Domain;

use DB;

class UsuarioSitio {

	public static function siNo($boolean){
		return ($boolean == 0)? 'NO':'SI';

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