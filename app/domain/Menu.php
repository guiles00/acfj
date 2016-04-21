<?php namespace App\Domain;

use DB;

class Menu {

	public static function getMenuAll(){


    	//Trae primero los que tiene padre_id = 0 
      $menu_root = DB::table('menu')
            ->select('*')
            ->where('padre_id','=',0)
            ->get();
	
	$menu_items = array();
	$menu_item = array();
	//Recorro para armar el menu con el segundo nivel
      foreach ($menu_root as $key => $menu) {
            	
            $items = DB::table('menu')
            ->select('*')
            ->where('padre_id','=',$menu->menu_id)
            ->get();

           if(!empty($items))
           $menu_items[$menu->menu] = $items ;
      }      

		return  $menu_items ;
	}


	public static function getMenuByPerfil($perfil_id){


    	//Trae primero los que tiene padre_id = 0 
      $menu_root = DB::table('menu')
            ->select('*')
            ->where('padre_id','=',0)
            ->orderBy('orden')
            ->get();
	
	$menu_items = array();
	$menu_item = array();
	//Recorro para armar el menu con el segundo nivel
      foreach ($menu_root as $key => $menu) {
            	
            $items = DB::table('menu')
            ->select('*')
            ->where('padre_id','=',$menu->menu_id)
            ->get();


           $menu_items[$menu->menu] = self::estaEnPerfil($items,$perfil_id) ;
                 
       }      
       foreach ($menu_items as $key => $menu) {
         if(empty($menu)) unset($menu_items[$key]) ;
       }

		return  $menu_items ;
	}

	private static function estaEnPerfil($items,$perfil_id){

		$menu_items = array();

		foreach ($items as $key => $menu) {
		
		$res = DB::table('menu_perfil')
            ->select('*')
            ->where('menu_id','=',$menu->menu_id)
            ->where('perfil_id','=',$perfil_id)
            ->get();
        
        if(!empty($res)) $menu_items[] = $menu;

        }


		return $menu_items;
	}
}
?>