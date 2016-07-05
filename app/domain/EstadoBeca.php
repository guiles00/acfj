<?php namespace App\Domain;

use DB;

class EstadoBeca {


	public static function getEstadoIdByNombre($estado_beca){


      $res = DB::table('estado_beca')
            ->select('*')
            ->where('estado_beca','=',$estado_beca)
            ->get();
		
		if(empty($res)) return 0;
		
		return  $res[0]->estado_beca_id ;
	}

}
?>