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
