<?php namespace App\Domain;

//use DB;

class Utils {


	public static function formatDate($datetime){

		if(empty($datetime)) return false;

		$date =  date_create($datetime);
		
		return  date_format($date,"d/m/Y");;
	}

	public static function now(){

		$date =  date_create($datetime);
		
		return  date_format($date,"Y-m-dd/m/Y");;
	}

}
?>