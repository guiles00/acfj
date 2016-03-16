<?php namespace App\Domain;

use DB;

class Agente {


	public static function getAgenteById($conste_agente_id){


      $res = DB::table('agente')
            ->select('*')
            ->where('agente_id','=',$conste_agente_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->agente_nombre ;
	}
	public static function getResponsableByAreaId($firmado_id){


      $res = DB::table('area_cfj')
            ->select('*')
            ->where('area_cfj_id','=',$firmado_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->area_responsable ;
	}

}
?>