<?php namespace App\Domain;

use DB;


class User {
    
    protected $_session_id;
    protected $_usuario;
    protected $_username;
    protected $_acl;
    protected $_perfil_id;
    private static $_instance;
    
 //Singleton  
    private function __construct(){
        
        if(session_id() == '' || !isset($_SESSION)) {
        // session isn't started
          session_start();
        }

        
        $this->_session_id =  (isset($_SESSION['cfj_userinfo']['user_id']))?$_SESSION['cfj_userinfo']['user_id']:null;
        $this->_username =  (isset($_SESSION['cfj_userinfo']['username']))?$_SESSION['cfj_userinfo']['username']:null;

        $user = DB::table('users')->where('user_id','=',$this->_session_id)->get();
        
        $this->_perfil_id = $user[0]->perfil_id;

        //$this->_usuario = new Domain_Usuario($this->_session_id);
        //$this->_acl = new Domain_Acl($this->_session_id) ;
        //$this->_usuario->setAcl(new  Domain_Acl($this->_session_id));
    }
   
   public static function getInstance(){
        
        if( self::$_instance instanceof self ) return self::$_instance;
        
        self::$_instance = new self;
        
        return self::$_instance;
    }
    
    function getUsername(){
        return $this->_username;
    }
    //Getters
    function getUsuario(){
        return $this->_usuario;
    }
    
    function getSessionId(){
        return $this->_session_id;
    }
    function hassAcess($menu_id){

      //echo $menu_id;
     // echo $this->_session_id;

      $res = DB::table('rol')
            ->select('*')
            ->where('menu_id', '=', $menu_id)
            ->where('user_id', '=', $this->_session_id)
            ->get();

     if( empty($res) ) return false;
     
      return true;
    }
    function getPerfilId(){
        return $this->_perfil_id;
    }
}
