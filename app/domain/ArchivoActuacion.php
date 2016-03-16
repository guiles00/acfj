<?php namespace App\Domain;

use DB;

class ArchivoActuacion {


	public static function getArchivoNomnbreById($archivo_actuacion_id){


      $res = DB::table('archivo_actuacion')
            ->select('*')
            ->where('archivo_actuacion_id','=',$archivo_actuacion_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->nombre_archivo ;
	}

}
?>