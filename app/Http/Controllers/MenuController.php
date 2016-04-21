<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use App\Menu;

class MenuController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
	}


	public function listMenu()
	{

		$menues = DB::table('menu')->get();

		return view('menu.listMenu')->with('menues',$menues);
	}


	public function edit($id)
	{
		
		$menu = Menu::find($id);	
		
		return view('menu.verMenu')->with('menu',$menu);	
		
	}

	public function update(){
		$input = Request::all();


		$menu = Menu::find($input['_id']);
		$menu->menu = $input['menu_nombre'];
		$menu->url = $input['menu_url'];
		$menu->padre_id = $input['menu_padre_id'];
		$menu->save();

		return view('menu.verMenu')->with('menu',$menu)->with('edited',true);	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function altaMenu()
	{
		$menu_padre = DB::table('menu')->where('padre_id','=',0)->get();

		//
		return view('menu.altaMenu')->with('menu_padre',$menu_padre);
	}

	public function add(){
		
		$input = Request::all();

		$menu = new Menu();
		$menu->menu = $input['menu_nombre']; 
		$menu->url = $input['menu_url'];
		$menu->padre_id = $input['menu_padre_id'];
		$menu->save();

		return redirect('listMenu');//->back();
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

}
