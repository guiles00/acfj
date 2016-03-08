<?php namespace App\Domain;

use DB;

class PasoBeca {


	public static function getTipoPasoById($t_paso_beca_id){


      $res = DB::table('t_paso_beca')
            ->select('*')
            ->where('t_paso_beca_id','=',$t_paso_beca_id)
            ->get();
		
		if(empty($res)) return '';
		
		return  $res[0]->t_paso_beca;
	}

}
?>