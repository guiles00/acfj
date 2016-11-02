<?php namespace App\Domain;

//use DB;

class Utils {


	public static function formatDate($datetime){
		
		
		if( $datetime == 0 ) return '';
		if(empty($datetime)) return false;
		
		$date =  date_create($datetime);
		
		return  date_format($date,"d/m/Y");;
	}

	public static function now(){

		//$date =  date_create($datetime);
		
		//return  date_format($date,"Y-m-dd/m/Y");
		return date("Y-m-d H:i:s");
	}


	public static function formatDateBis($datetime){

		if(empty($datetime)) return false;
		
		//$date =  date_create_from_format($datetime,'Y-m-d');
		$date_nose = date($datetime);
		$date = date_create($date_nose);
		
		return  date_format($date,"d/m/Y");;
	}

	public static function siNo($boolean){
		return ($boolean == 0)? 'NO':'SI';

	}

	public static function compareDate($one,$two){

		$datetime1 = date_create($one); 
		$datetime2 = date_create($two); 
		$interval = date_diff($datetime1, $datetime2); 
		return $interval->days;
	}
}
?>