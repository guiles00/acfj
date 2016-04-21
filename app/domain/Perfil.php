<?php namespace App\Domain;

use DB;

class Perfil {


	public static function hasAccess($perfil_id,$menu_id){


      $res = DB::table('menu_perfil')
            ->select('*')
            ->where('perfil_id','=',$perfil_id)
            ->where('menu_id','=',$menu_id)
            ->get();

        if(empty($res[0])) return false;    
		
		return true;
	}


}
?>