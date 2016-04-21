<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use App\User;

class UsuarioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
	}


	public function listUsuarios()
	{
		$usuarios = DB::table('users')->get();

		return view('usuario.listUsuarios')->with('usuarios',$usuarios);
	}


	public function edit($id)
	{

		$usuario = DB::table('users')->where('user_id','=',$id)->get();	
		
		$menu_perfil = DB::table('menu')->get();	
		$perfil_menu = DB::table('perfil_menu')->get();									
		
		return view('usuario.verUsuario')->with('usuario',$usuario[0])->with('menu_perfil',$menu_perfil)->with('perfil_menu',$perfil_menu);	
	}

	/*public function edit($id){
		
		$usuario = DB::table('users')->where('user_id','=',$id)->get();	

		//return view('usuario.verUsuario')->with('usuario',$usuario);	
	}*/

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}
	
	public function update()
	{
		$input = Request::all();

		$usuario = User::find($input['_id']);
			
		$usuario->username = $input['usuario_nombre'];
		$usuario->email = $input['usuario_email'];
		$usuario->perfil_id = $input['usuario_perfil_id'];
		$usuario->save();

		//Ver que mensaje le mando con el resultado.
		echo "Actualizo correctamente";
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function store()
	{

	}

	public function ajaxEditMenu(){

		echo "ajax";
	}
}
