<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Redirect;
use Request;
use DB;
use Auth;

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


		/*$dataAttempt = array(
            'UserEmail' => Input::get('email'),
            'password' => Input::get('password')
        );*/
//		print_r($userdata);
		//$res = Auth::attempt($userdata);
		//print_r($user = Auth::user());
//exit;
		
//print_r($res);
 /* if (Auth::attempt($userdata)) {
         
            echo "no funciona";
        }	else{
        	echo "no funciona??";
        }
*/
//		exit;
		 // attempt to do the login
	     if (Auth::attempt(['email' => $input['email'], 'password' => md5($input['password']) ]) ) {
//		if (1) {
	        
	        return Redirect::to('bienvenido');

	    } else {        

	        
	        return Redirect::to('/');

	    }

	}

	public function doLogout(){
		Auth::logout();
		 return Redirect::to('/');
	}

	public function welcome()
	{	
		//$user = Auth::user();
		//print_r($user);		
		return view('welcome');
	}

}
