<?php namespace App\Http\Controllers;
use App\Curso;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//use Illuminate\Http\Request;
use Request;


class TableroController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$cursos = $data = DB::table('curso')
							->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            				->get();
		return view('tablero.index')->with('cursos',$cursos);
	}


	public function cursoCargo($x){

		$input = Request::all();
		$p_curso_id = ( isset($input['curso']) )? $input['curso'] : $x;


		$data = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select(DB::raw('count(*) as cantidad, cargo.car_nombre,cargo.car_id'))
            ->where('curso.cur_id', '=',$p_curso_id)
            ->groupBy('cargo.car_nombre')
            ->orderBy('cantidad','DESC')
            //->toSql();
            ->get();

		$arr_data = [];
		$cantidad_total = 0;

		foreach ($data as $value) {
			$curso['color'] = "#2484c1";
			$curso['value'] = (integer)$value->cantidad;
			$curso['label'] = $value->car_nombre;
			$arr_data[]=(object)$curso;
			$cantidad_total = $cantidad_total +  $value->cantidad;
		}

		
		return view('tablero.cargoxcurso')->with('data',$data)->with('json_data',json_encode($arr_data))
		->with('curso_id',$p_curso_id)->with('cantidad_total',$cantidad_total);	



	}

	public function estadisticasCurso($x){
/*
select ca.car_id,count(*),ca.car_nombre from curso c , curso_usuario_sitio cus, usuario_sitio us, cargo as ca  
where c.cur_id = cus.cus_cur_id 
and us.usi_id = cus.cus_usi_id
and us.usi_car_id = ca.car_id
and c.cur_id=220 
AND cus.cus_validado =  'Si'
group by ca.car_nombre
*/
		$input = Request::all();
		$p_curso_id = ( isset($input['curso']) )? $input['curso'] : $x;
//print_r($input);
//exit;
		$data = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select(DB::raw('count(*) as cantidad, cargo.car_nombre,cargo.car_id'))
            ->where('curso.cur_id', '=',$p_curso_id)
            ->groupBy('cargo.car_nombre')
            //->toSql();
            ->get();
			//echo "<pre>";
			//print_r($input['curso']);
			  //  ->where('curso_usuario_sitio.cus_validado', '=', 'Si')
         
		//exit;
	//Trae request para armar la query
	/*	 "content": [
      {
        "label": "ASESOR",
        "value": 264131,
        "color": "#2484c1"
      },
*/	
      	//$data['curso_id'] = $input['curso'];

		$arr_data = [];
		//echo "<pre>";
		foreach ($data as $value) {
		//	print_r($value);
			$curso['color'] = "#2484c1";
			$curso['value'] = (integer)$value->cantidad;
			$curso['label'] = $value->car_nombre;
			$arr_data[]=(object)$curso;
		}
		//echo "<pre>";
		//$json_array['content'] = $arr_data ; 
		//print_r($arr_data);
		//print_r(json_encode($json_array));
		//echo "<pre>";
		//print_r($input);
		return view('tablero.cursos')->with('data',$data)->with('json_data',json_encode($arr_data))
		->with('curso_id',$p_curso_id);	
		//return response()->json(['name' => 'Abigail', 'state' => 'CA']);
	}

	public function traeCargoCurso($cur_id,$car_id){
		/*select usi_email from curso c , curso_usuario_sitio cus, usuario_sitio us, cargo as ca  
where c.cur_id = cus.cus_cur_id 
and us.usi_id = cus.cus_usi_id
and us.usi_car_id = ca.car_id
and c.cur_id=220 
AND cus.cus_validado =  'Si'
and usi_car_id=-1
*/
		

		//$input = Request::all();
		//print_r($x);
		//print_r($y);
		
		$data = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            ->where('curso.cur_id', '=', $cur_id)
            ->where('usuario_sitio.usi_car_id', '=', $car_id)
            //->toSql();
            ->get();
//echo "<pre>";
//print_r($data);
//exit;
		return view('tablero.cargocurso')->with('data',$data)->with('curso_id',$cur_id);

	}

	//Trae los cursos por intervalo de fechas (años)
	public function cursoFecha(){
		//inicializo data
		$data = [];
		$input = Request::all();
		$data['anio'] = isset($input['anio'])?$input['anio']: '2015'; 

/*select g3.gcu3_id,g3.gcu3_titulo,count(*) from curso c , curso_usuario_sitio cus, usuario_sitio us, grupo_curso3 g3 
where c.cur_id = cus.cus_cur_id 
and us.usi_id = cus.cus_usi_id
and c.cur_gcu3_id = g3.gcu3_id
AND cus.cus_validado =  'Si'
and YEAR(c.cur_fechaInicio) ='2014'
group by g3.gcu3_titulo*/

		$res = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->join('grupo_curso3','curso.cur_gcu3_id','=','grupo_curso3.gcu3_id')
            ->select('curso.cur_id','grupo_curso3.gcu3_titulo',DB::raw('count(*) as cantidad'))
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=', $data['anio'])
            ->where('curso_usuario_sitio.cur_asistio','=','Si')
            ->where('curso_usuario_sitio.cus_habilitado','=','1')
            //->where(DB::raw('YEAR(curso.cur_fechaInicio)', '=', date('Y') ))
            ->groupBy('grupo_curso3.gcu3_titulo')
            //->toSql();
            ->get();
			//echo $res;
			//exit;
	    
		usort($res,function($a,$b){
			if ( $a->cantidad == $b->cantidad){ return 0; } 

			return ($a->cantidad > $b->cantidad) ? -1 : 1;	
		});
		
		$data['res'] = $res;    

		return view('tablero.cursofecha')->with('data',$data); 
	}
	

public function inscriptosCurso(){

/*
		SELECT * 
FROM curso c, curso_usuario_sitio cus, usuario_sitio us
WHERE c.cur_id = cus.cus_cur_id
AND us.usi_id = cus.cus_usi_id
AND c.cur_id =220
AND cus.cus_validado =  'Si'
*/
			$input = Request::all();
			$curso_id = ( isset($input['curso_id']) )? $input['curso_id'] : null;

			$data = [];

			$res = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->select('*')
            ->where('curso.cur_id', '=', $curso_id )
            //->toSql();
            ->get();
          //print_r($res);
          $data['res'] = $res;
          $data['anio'] = $input['anio']; 
		return view('tablero.inscriptoscurso')->with('data',$data); ;
	}

	public function area(){

		return view('tablero.area');

	}
	public function categorias(){

		return view('tablero.categorias');

	}
	

	public function grupo(){
		
		/*SELECT gcu_id,gcu_nombre, count(*) as cant
			FROM curso
			INNER JOIN grupo_curso3 ON curso.cur_gcu3_id = grupo_curso3.gcu3_id  
			INNER JOIN grupo_curso2 ON grupo_curso3.gcu3_gcu2_id = grupo_curso2.gcu2_id
			INNER JOIN grupo_curso ON grupo_curso2.gcu2_gcu_id = grupo_curso.gcu_id
			where YEAR(curso.cur_fechaInicio) = '2014' 
			group by gcu_nombre
			ORDER BY cant
		*/
		$input = Request::all();
		//print_r($input);
		$data = [];

			$res = DB::table('curso')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
            ->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
            ->select('gcu_id','gcu_nombre',DB::raw('count(*) as cantidad') )
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=', $input['data'])
            ->groupBy('gcu_nombre')
            ->orderBy('cantidad','DESC')
            //->toSql();
            ->get();	

            $data['res'] = $res;
            $data['anio'] = $input['data'];

		return view('tablero.resgrupo')->with('data',$data);

	}


	public function resarea(){
		
		/*SELECT gcu_id,gcu_nombre, count(*) as cant
			FROM curso
			INNER JOIN grupo_curso3 ON curso.cur_gcu3_id = grupo_curso3.gcu3_id  
			INNER JOIN grupo_curso2 ON grupo_curso3.gcu3_gcu2_id = grupo_curso2.gcu2_id
			INNER JOIN grupo_curso ON grupo_curso2.gcu2_gcu_id = grupo_curso.gcu_id
			where YEAR(curso.cur_fechaInicio) = '2014' 
			group by gcu_nombre
			ORDER BY cant
		*/
		$input = Request::all();
		//print_r($input);
		$data = [];

			$res = DB::table('curso')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
            ->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
            ->select('gcu_id','gcu_nombre',DB::raw('count(*) as cantidad') )
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=', $input['data'])
            ->groupBy('gcu_nombre')
            //->toSql();
            ->get();	

            $data['res'] = $res;
            $data['anio'] = $input['data'];

		return view('tablero.resarea')->with('data',$data);

	}


	public function listadoGrupoDosCursos(){

		/*SELECT gcu2_id,gcu2_nombre ,COUNT( * ) AS cantidad
			FROM curso
			INNER JOIN grupo_curso3 ON curso.cur_gcu3_id = grupo_curso3.gcu3_id
			INNER JOIN grupo_curso2 ON grupo_curso3.gcu3_gcu2_id = grupo_curso2.gcu2_id
			INNER JOIN grupo_curso ON grupo_curso2.gcu2_gcu_id = grupo_curso.gcu_id
			WHERE YEAR( curso.cur_fechaInicio ) =  '2014'
			and gcu_id = 10
			GROUP BY gcu2_id
		*/

		$input = Request::all();
		//print_r($input);
		$data = [];

			$res = DB::table('curso')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
            ->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
            ->select('gcu2_id','gcu_nombre','gcu2_nombre',DB::raw('count(*) as cantidad'))
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=',  $input['anio'])
            ->where('gcu_id', '=', $input['gcu_id'])
            ->groupBy('gcu2_id')
            ->orderBy('cantidad','DESC')
            //->toSql();
            ->get();	

            $data['res'] = $res;
            $data['anio'] = $input['anio'];
		return view('tablero.reslistadogrupodoscursos')->with('data',$data);

	}

	public function listadoCursos(){

		/*
		SELECT gcu2_id, gcu3_id, gcu3_titulo, COUNT( * ) AS cantidad
		FROM curso
		INNER JOIN grupo_curso3 ON curso.cur_gcu3_id = grupo_curso3.gcu3_id
		INNER JOIN grupo_curso2 ON grupo_curso3.gcu3_gcu2_id = grupo_curso2.gcu2_id
		INNER JOIN grupo_curso ON grupo_curso2.gcu2_gcu_id = grupo_curso.gcu_id
		WHERE YEAR( curso.cur_fechaInicio ) =  '2014'
		group by gcu3_id
		*/

		$input = Request::all();
		//print_r($input);
		$data = [];

			$res = DB::table('curso')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
            ->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
            ->select('*',DB::raw('count(*) as cantidad'))
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=',  $input['anio'])
            ->where('gcu2_id', '=', $input['gcu2_id'])
            ->groupBy('gcu3_id')
            ->orderBy('cantidad','DESC')
            //->toSql();
            ->get();	

            $data['res'] = $res;
            $data['anio'] = $input['anio'];
		return view('tablero.reslistadocurso')->with('data',$data);
	}


	public function listCursos(){

		/*
		SELECT *
		FROM curso
		INNER JOIN grupo_curso3 ON curso.cur_gcu3_id = grupo_curso3.gcu3_id
		INNER JOIN grupo_curso2 ON grupo_curso3.gcu3_gcu2_id = grupo_curso2.gcu2_id
		INNER JOIN grupo_curso ON grupo_curso2.gcu2_gcu_id = grupo_curso.gcu_id
		WHERE YEAR( curso.cur_fechaInicio ) =  '2014'
		*/

		$input = Request::all();
		//print_r($input);
		$data = [];

			$res = DB::table('curso')
            ->join('grupo_curso3', 'curso.cur_gcu3_id', '=', 'grupo_curso3.gcu3_id')
            ->join('grupo_curso2', 'grupo_curso3.gcu3_gcu2_id', '=', 'grupo_curso2.gcu2_id')
            ->join('grupo_curso', 'grupo_curso2.gcu2_gcu_id', '=', 'grupo_curso.gcu_id')
            ->select('*')
            ->where(DB::raw('YEAR(curso.cur_fechaInicio)'), '=',  $input['anio'])
            ->where('cur_gcu3_id', '=', $input['cur_gcu3_id'])
  //          ->toSql();
            ->get();	

            $data['res'] = $res;

		return view('tablero.reslistcurso')->with('data',$data);


	}

	public function alumnosCurso(){

		$input = Request::all();

		$data = [];

		/*SELECT * 
			FROM curso c, curso_usuario_sitio cus, usuario_sitio us
			WHERE c.cur_id = cus.cus_cur_id
			AND us.usi_id = cus.cus_usi_id
			AND c.cur_id =220
			AND cus.cus_validado =  'Si'
			AND cus.cus_habilitado = 1
		*/

		$res = DB::table('curso')
        ->join('curso_usuario_sitio', 'curso_usuario_sitio.cus_cur_id', '=', 'curso.cur_id')
        ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
        ->select('*')
        ->where('curso.cur_id', '=',  $input['cur_id'])
        ->where('curso_usuario_sitio.cus_validado', '=', 'Si')
        ->where('curso_usuario_sitio.cus_habilitado', '=', 1)
        //->toSql();
        ->get();	

        $data['res'] = $res;
            	
		return view('tablero.resalumnoscurso')->with('data',$data);

	}

	public function fichaCurso(){

		/*
select ca.car_id,count(*),ca.car_nombre from curso c , curso_usuario_sitio cus, usuario_sitio us, cargo as ca  
where c.cur_id = cus.cus_cur_id 
and us.usi_id = cus.cus_usi_id
and us.usi_car_id = ca.car_id
and c.cur_id=220 
AND cus.cus_validado =  'Si'
group by ca.car_nombre
*/
		$input = Request::all();
		$curso_id = $input['cur_id'];

		$data = DB::table('curso_usuario_sitio')
            ->join('curso', 'curso.cur_id', '=', 'curso_usuario_sitio.cus_cur_id')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'curso_usuario_sitio.cus_usi_id')
            ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select(DB::raw('count(*) as cantidad, cargo.car_nombre,cargo.car_id'))
            ->where('curso.cur_id', '=',$input['cur_id'])
            ->groupBy('cargo.car_nombre')
            //->toSql();
            ->get();


		$arr_data = [];
		$cantidad_total = 0;
		foreach ($data as $value) {
			$curso['color'] = "#2484c1";
			$curso['value'] = (integer)$value->cantidad;
			$curso['label'] = $value->car_nombre;
			$arr_data[]=(object)$curso;
			$cantidad_total = $cantidad_total +  $value->cantidad;
		}

		//echo "<pre>";
		//print_r($data);
		//exit;
		return view('tablero.resfichacurso')->with('data',$data)->with('json_data',json_encode($arr_data))
		->with('curso_id',$curso_id)->with('cantidad_total',$cantidad_total);	
		

	}


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
