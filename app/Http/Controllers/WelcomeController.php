<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Redirect;
use Request;
use DB;
use Auth;
use App\domain\MyAuth;

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
		return view('login');
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


		 // attempt to do the login
	     if ( MyAuth::attempt($userdata) ) {
	        
	        return Redirect::to('bienvenido');

	    } else {        

	        
	        return Redirect::to('/');

	    }

	}

	public function doLogout(){
		
			session_start();
			session_destroy();

		 return Redirect::to('/');
	}

	public function welcome()
	{	
		//$user = Auth::user();
		//print_r($user);		
		return view('welcome');
	}

}
