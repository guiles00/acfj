<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use App\User;
use App\MenuPerfil;

class PerfilController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
	}


	public function listPerfiles()
	{
		$perfiles = DB::table('perfil_menu')->get();

		return view('perfil.listPerfiles')->with('perfiles',$perfiles);
	}


	public function edit($id)
	{

		$perfil = DB::table('perfil_menu')->where('perfil_id','=',$id)->first();	
		
		$menu_perfil = DB::table('menu')->get();	
		$perfil_menu = DB::table('perfil_menu')->get();									

		return view('perfil.verPerfil')->with('menu_perfil',$menu_perfil)->with('perfil_menu',$perfil_menu)->with('perfil',$perfil);	
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

	public function ajaxAddMenu(){

		$input = Request::all();

		$menu_perfil = new MenuPerfil();
		$menu_perfil->perfil_id = $input['perfil_id'];
		$menu_perfil->menu_id = $input['menu_id'];
		$menu_perfil->save();
		
		echo "add ajax";
	}
	public function ajaxDeleteMenu(){
		$input = Request::all();
		
		$res = DB::table('menu_perfil')->where('menu_id',$input['menu_id'])->where('perfil_id',$input['perfil_id'])->delete();
		
		echo "delete ajax";
	}

	public function loadTableMenuPerfil(){
		$input = Request::all();
		$perfil_id = $input['id'];
		$menu_perfil = DB::table('menu')->get();	
		$perfil_menu = DB::table('perfil_menu')->get();	

		return view('perfil.loadTableMenuPerfil')->with('menu_perfil',$menu_perfil)->with('perfil_menu',$perfil_menu)->with('perfil_id',$perfil_id);
	}
}
