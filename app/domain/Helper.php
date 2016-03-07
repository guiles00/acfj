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

			$res = DB::table('helper')
            ->select('*')
           	->where('dominio','=', "$dominio" )
            ->get();

            return $res;
	}

  static public function getHelperByDominioAndId($dominio,$id){

      $res = DB::table('helper')
            ->select('*')
            ->where('dominio','=', "$dominio" )
            ->where('dominio_id','=', "$id" )
            ->get();


if( empty($res[0]) ) return 'S/D';
            
            return $res[0]->nombre;
  }


    static public function getInstitucionPropuestaId($institucion_propuesta){

      $res = DB::table('universidad_sigla')
            ->select('*')
            ->where('universidad_id','=', $institucion_propuesta )
            ->get();

if( empty($res[0]) ) return 'S/D';
            
            return $res[0]->universidad;
  }
}

