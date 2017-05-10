<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Redirect;
use Request;
use DB;
use Auth;
use App\domain\MyAuth;
use App\domain\User;
use App\User as ModelUser;


class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{	
		//Si esta recordarme loguearse
		$datos_usuario = null;
		$recordarme = 0;
		$user_data = null;
		//Si estan las cookies de recordar de usuario, mandarle los datos
		if (isset($_COOKIE["id_usuario_dw"]) && isset($_COOKIE["marca_aleatoria_usuario_dw"])){
			$user_data = MyAuth::getUserDataById($_COOKIE["id_usuario_dw"]);//,$_COOKIE["marca_aleatoria_usuario_dw"]);
			$recordarme = 1;

			return Redirect::to('bienvenido');
		}

		return view('login')
		->with('recordarme',$recordarme)
		->with('user_data',$user_data);
	}

	public function doLogin()
	{
		
		$input = Request::all();
		
		/*$credenciales = DB::table('users')
	            ->select('*')
	            ->where('email', '=', $input['email'])
	            ->get(); 
		*/
	  //  $success = false;        
	  //  if($credenciales[0]->password == md5($input['password'])) $success = true;        
		
		$userdata = array('email'=> $input['email'],
		        'password'  => $input['password']);

/* 		$id_sesion = md5(uniqid(rand(), true));
		$id_sesion2 = $input['email']."%".$id_sesion."%".'190.1.1.1';
		setcookie('id_sesion', $id_sesion2, time()+7776000,'/');
*/

		 // attempt to do the login
	     if ( MyAuth::attempt($userdata) ) {


					     	if (isset($input["recordar_usuario"])){
					     	  
						      mt_srand (time());
						      $numero_aleatorio = mt_rand(1000000,999999999);
						      $user_data = MyAuth::getUserData($userdata);
		
								//para mayor seguridad tengo que guardar un numero aleatorio en la tabla del usuario				     
						     // $ssql = "update usuario set cookie='$numero_aleatorio' where id_usuario=" . $usuario_encontrado->id_usuario;
						    
						      setcookie("id_usuario_dw", $user_data->user_id , time()+(60*60*24*365));
						      setcookie("marca_aleatoria_usuario_dw", $numero_aleatorio, time()+(60*60*24*365));

						   }
	       
	        return Redirect::to('bienvenido');

	    } else {        

	        return Redirect::to('/');
	    }


	}

	public function doLogout(){
		
			session_start();
			session_destroy();
			if(isset($_COOKIE['id_usuario_dw'])) setcookie('id_usuario_dw');

		 return Redirect::to('/');
	}

	public function welcome()
	{	
		//$user = Auth::user();
		//print_r($user);		
		return view('welcome');
	}

	public function cambiarClave(){

		$username = User::getInstance()->getUsername();
		$user_id = User::getInstance()->getSessionId();
		
		return view('auth.reset')->with('username',$username)->with('user_id',$user_id);
	}

	public function updatePassword(){
		$input = Request::all();
		
		$user = ModelUser::find($input['user_id']);
		$user->password = md5($input['password']);
		$user->save();

		return view('auth.updatePassword');
	}

}
