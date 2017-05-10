<?php namespace App\Domain;

use DB;

class MyAuth {

	public function sayHi(){
		//echo "hola mundo";

		$test = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            ->limit(20)
            ->toSql();
	}

  static public function attempt($userdata){
    
  $credenciales = DB::table('users')
              ->select('*')
              ->where('email', '=', $userdata['email'])
              ->OrWhere('username', '=', $userdata['email'])
              ->get();
              
  //print_r($credenciales);

    if(empty($credenciales)) return false;

    if( md5($userdata['password']) == $credenciales[0]->password ){

      self::startSession($credenciales[0]);

      return true;
    } 

    return false;  
  }


  private static function startSession($userdata){
    
    session_start();

    $_SESSION['cfj_userinfo']['username'] = $userdata->username;
    $_SESSION['cfj_userinfo']['user_id'] = $userdata->user_id;

    return true;
  }

  public static function check(){
    session_start();    

    if( empty($_SESSION['cfj_userinfo']) ) return false;
    
    return true;
  }

	static public function getHelperByDominio($dominio){

			$res = DB::table('helper')
            ->select('*')
           	->where('dominio','=', "$dominio" )
            ->get();

            return $res;
	}

  static public function getHelperByDominioAndId($dominio,$id){

      $res = DB::table('helper')
            ->select('*')
            ->where('dominio','=', "$dominio" )
            ->where('dominio_id','=', "$id" )
            ->get();


if( empty($res[0]) ) return 'S/D';
            
            return $res[0]->nombre;
  }



 static public function getUserData($userdata){
    
  $user_data = DB::table('users')
              ->select('*')
              ->where('email', '=', $userdata['email'])
              ->OrWhere('username', '=', $userdata['email'])
              ->get();
              
    if(empty($user_data)) return false;

    return $user_data[0];  
  }

  static public function getUserDataById($user_id){
    
  $user_data = DB::table('users')
              ->select('*')
              ->where('user_id', '=', $user_id)
              ->get();
              
    if(empty($user_data)) return false;

    return $user_data[0];  
  }

}
