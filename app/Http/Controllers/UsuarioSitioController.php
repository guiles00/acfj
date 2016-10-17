<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use DB;
use App\domain\Utils;
use App\UsuarioSitio;


class UsuarioSitioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function listarUsuarioSitio()
	{
		
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);
		//Trae cursos activos
		 $query = DB::table('usuario_sitio')
            ->select('*' )
            ->orderBy('usi_id','DESC');
        
            //Si uso el filtro
            if(isset($input['_search']))

            	$query->where(function($subquery) use($input){
            			
            			$subquery->where('usi_nombre','like',"%$input[str_usuario]%")
            		  		->orWhere('usi_email','like',"%$input[str_usuario]%")
            		  		->orWhere('usi_dni','like',"%$input[str_usuario]%");

            		  });

            if(isset($input['estado_id']) AND $input['estado_id'] == 0 ) $query->where('usi_validado','=',"-");
            
            //print_r($query->toSql());
            //exit;
            $usuarios_sitio = $query->paginate(30);
            
           
       	return view('usuariositio.listarUsuarioSitio')
			->with('usuarios_sitio',$usuarios_sitio);
			
	}


	public function validarUsuarioSitio(){

		return 'holis';
	}

	public function verUsuarioSitio($id){
		
		$input = Request::all();

		$usuario_sitio = UsuarioSitio::find($id);
		//echo "<pre>";
		//print_r($usuario_sitio);

		$cargos = DB::table('cargo')->get();
        $fueros = DB::table('fuero')->get();
		$dependencias = DB::table('dependencia')->get();

		$helpers['cargos']=$cargos;
		$helpers['fueros']=$fueros;
		$helpers['dependencias']=$dependencias;

		return view('usuariositio.verUsuarioSitio')
		->with('usuario_sitio',$usuario_sitio)
		->with('helpers',$helpers);
	}

	public function update(){
		
		$input = Request::all();
		//echo "<pre>";
		//print_r($input);

		$usuario_sitio = UsuarioSitio::find($input['_id']);

		$usuario_sitio->usi_nombre = $input['usuario_sitio_nombre'];
	    $usuario_sitio->usi_dni = $input['usuario_sitio_dni'];
	    $usuario_sitio->usi_email = $input['usuario_sitio_email'];
	    $usuario_sitio->usi_telefono = $input['usuario_sitio_telefono'];
	    $usuario_sitio->usi_celular = $input['usuario_sitio_celular'];
	    $usuario_sitio->usi_direccion = $input['usuario_sitio_domicilio'];
	    $usuario_sitio->usi_cp = $input['usuario_sitio_cp']; 
	    $usuario_sitio->usi_fuero_id = $input['fuero_id'];
	    $usuario_sitio->usi_fuero_otro = $input['area_otro'];
	    $usuario_sitio->usi_dep_id = $input['dependencia_id'];
	    $usuario_sitio->usi_dep_otro = $input['dependencia_otro'];
	    $usuario_sitio->usi_car_id = $input['car_id'];
	    $usuario_sitio->usi_cargo_otro = $input['cargo_otro'];
	    $usuario_sitio->save();

	    return redirect()->back();
	}


	public function resetPasswordUsuarioSitio($id){

		$usuario_sitio = UsuarioSitio::find($id);
		$usuario_sitio->usi_clave = $usuario_sitio->usi_dni;
		$usuario_sitio->save();

		return 'true';
	}
}
