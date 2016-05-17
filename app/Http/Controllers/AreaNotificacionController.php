<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;

class AreaNotificacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
	}


	public function listAreas()
	{

		$area_cfj = DB::table('area_cfj')->get();
		//echo "<pre>";
		//print_r($area_cfj);
		return view('areanotificacion.listAreas')->with('area_cfj',$area_cfj);
	}

	public function verAreaNotificacion(){
		$input = Request::all();
		$area_cfj = DB::table('area_cfj')->where('area_cfj_id','=',$input['id'])->get();
		$notificacion_cfj = DB::table('notificacion_area_cfj')
  				                ->leftJoin('agente','notificacion_area_cfj.agente_id','=','agente.agente_id')
								->where('notificacion_area_cfj.area_cfj_id','=',$input['id'])->get();
		//echo "el ID";
		//print_r($input);
		return view('areanotificacion.resVerAreaNotificacion')->with('area_cfj',$area_cfj[0])->with('notificacion_cfj',$notificacion_cfj);
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
