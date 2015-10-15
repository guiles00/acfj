<?php namespace App\Http\Controllers;
use App\Beca;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
//use App\Alumno;
//use App\Cargo;
use DB;
use Request;

class BecaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$becas = Beca::all();
		

		$input = Request::all();
		
		$str = (isset($input['str_beca']))?$input['str_beca']:'';
		

		/*$becas = Beca::where('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_dni', 'LIKE', "%$str%")
		->orWhere('usi_nombre', 'LIKE', "%$str%")
		->orWhere('usi_legajo', 'LIKE', "%$str%")
		->paginate(30);
		*/
		//$alumnos->setPath('alumnos');


		$data = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->join('estado_beca', 'beca.estado_id', '=', 'estado_beca.estado_beca_id')
           // ->join('cargo','usuario_sitio.usi_car_id','=','cargo.car_id')
            ->select('*')
            ->where('usuario_sitio.usi_nombre', 'LIKE', "%$str%")
           // ->groupBy('cargo.car_nombre')
            ->orderBy('beca.beca_id','DESC')
            //->toSql();
            ->paginate(20); // El paginate funciona como get()
            //->get(); 
            
            $becas = $data;

            $becas->setPath('listBecas');

		return view('beca.index')->with('becas',$becas);
	}

	public function verSolicitud($id){

		//$input = Request::all();
		//echo "<pre>";
		//print_r($id);


		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*')
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            /*echo "<pre>";
            print_r($solicitud_beca);
            exit;*/

            $cargos = DB::table('cargo')->get();
            $universidades = DB::table('universidad')->get();
            $fuero = DB::table('fuero')->get();
			$titulos = DB::table('titulo')->get();
			$facultades = DB::table('facultad')->get();

			$helpers['cargos']=$cargos;
			$helpers['universidades']=$universidades;
			$helpers['fuero']=$fuero;
			$helpers['titulos']=$titulos;
			$helpers['facultades']=$facultades;
			/*echo "<pre>";
            print_r($cargos);
            exit;*/

		return view('beca.verSolicitudBeca')->with('beca',$solicitud_beca[0])->with('helpers',$helpers);

	}

	public function verDocAdjunta($id){

		//$input = Request::all();
		//echo "<pre>";
		//print_r($id);


		$solicitud_beca = DB::table('beca')
            ->join('usuario_sitio', 'usuario_sitio.usi_id', '=', 'beca.alumno_id')
            ->select('*')
            ->where('beca.beca_id', '=', $id)
            ->get(); 
            
            /*echo "<pre>";
            print_r($solicitud_beca);
            exit;*/
		return view('beca.verDocAdjunta')->with('beca',$solicitud_beca[0]);

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
