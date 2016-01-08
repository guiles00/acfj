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

}
?>