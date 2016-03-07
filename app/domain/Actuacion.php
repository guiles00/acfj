<?php namespace App\Domain;

use DB;

class Actuacion {


	public static function getLastNumber(){


      $res = DB::table('actuacion')
            ->select('*')
            ->orderBy('numero_actuacion','DESC')
            ->get();

		return  $res[0]->numero_actuacion + 1;
	}

	public static function getDestinoById($area_destino_id){


      $res = DB::table('area_cfj')
            ->select('*')
            ->where('area_cfj_id','=',$area_destino_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->area_nombre ;
	}
	public static function getAgenteById($conste_agente_id){


      $res = DB::table('agente')
            ->select('*')
            ->where('agente_id','=',$conste_agente_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->agente_nombre ;
	}
	public static function getResponsableByAreaId($area_destino_id){


      $res = DB::table('area_cfj')
            ->select('*')
            ->where('area_cfj_id','=',$area_destino_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->area_responsable ;
	}

}
?>