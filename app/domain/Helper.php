<?php namespace App\Domain;

use DB;

class Helper {

	public function sayHi(){
		echo "hola mundo";

		$test = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            ->limit(20)
            ->toSql();
	}

	static public function getHelperByDominio($dominio){

			$tipo_beca = DB::table('helper')
            ->select('*')
           	->where('dominio','=', "$dominio" )
            ->get();
            return $tipo_beca;
	}
}
