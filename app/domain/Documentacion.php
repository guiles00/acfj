<?php namespace App\Domain;

use DB;

class Documentacion {

	public static function tieneFormularioSolicitud($beca_id){
	
		$res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->formulario_solicitud;
            
	}

  public static function tieneCurriculum($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->curriculum;
            
  }

  public static function tieneInformacionActividad($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->informacion_actividad;
            
  }

  public static function tieneCertificadoLaboral($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->certificado_laboral;
            
  }
  
  public static function tieneCopiaTitulo($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->copia_titulo;
            
  }

  public static function tieneDictamenEvaluativo($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0]->dictamen_evaluativo;
            
  }

	public static function traeDocumentacion($beca_id){
  
    $res = DB::table('documentacion')
            ->select('*')
            ->where('beca_id','=',$beca_id)   
            ->get();

  if( empty($res[0]) ) return false;

      return $res[0];
            
  }

  
}
