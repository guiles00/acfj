<?php namespace App\Http\Middleware;

use Closure;
use Cookie;
use App\domain\MyAuth;

class SessionExpired {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//Si la session expiro, chequeo si tiene la variable laravel_session
		//|| empty(MyAuth::check() ) 
		 if ( empty(Cookie::get('laravel_session')) || empty(MyAuth::check()) )
        {
            return redirect('/');
        }
		return $next($request);
	}

}
