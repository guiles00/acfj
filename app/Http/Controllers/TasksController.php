<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class TasksController extends Controller {



	public function lista(){
		
		//$tasks = \App\Tasks::find(1);
		$tasks = \App\Tasks::all();
		
		//echo "<pre>";
		foreach ($tasks as $key => $value) {
			echo $value->title ."<br>";
		}
		//print_r($tasks);
		//$users = User::all();
		return view('list');//>with($tasks);	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$taks = Tasks::all();
		echo "nada";
	}
	public function accion(){
		echo "nadaada1111dadada";
		//$tasks = \App\Tasks::find(1);
		//$tasks = \App\Tasks::all();
		
		//echo "<pre>";
		//foreach ($tasks as $key => $value) {
		//	print_r($value->title);
		//}
		//print_r($tasks);
		//$users = User::all();
		//return view('tasks')->with($tasks);	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//


		$task = new \App\Tasks;

		$task->title = 'Insertando desde get';
		$task->body = 'Insertando desde get';

		$task->save();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
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

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
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

}
