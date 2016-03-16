@extends('app')

@section('content')

<? 
use App\domain\Utils;
use App\domain\Remitidos;
use App\domain\Helper;
use App\domain\Agente;
use App\domain\ArchivoActuacion;

$helper = new Helper();
?>

 <ul class="breadcrumb">
    <li>Mesa de Entrada - Remitidos</li>
    <li class="active">Listado de Remitidos</li>
</ul>

<div class="panel panel-default">
 
  <div class="panel-heading">
    <div class="form-group pull-left">
                <!--button type="button" class="btn btn-default pull-left" aria-label="Left Align"-->
                <a class="btn btn-default pull-left" href="{!! URL::action('RemitidosController@altaRemitidos'); !!}" aria-label="Left Align">Agregar Remitidos</a><!--/button-->
      </div>
     <div class="row">      
        <form method="GET" action="{{action('RemitidosController@listRemitidos')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
              <div class="form-group">
                    <input type="text" class="form-control " name="str_remitido" placeholder="" id="search_remitido">
                    <button type="submit" class="btn btn-default" id="buscar_remitido">Buscar</button>
              </div>   
         </div>
        </form>
    </div>
  </div>
    
      <div class="panel-body">
        <div class="table-responsive">
              <table class="table table-responsive table-striped table-bordered table-hover" id="remitido">
                  <thead>
                      <tr>                   
                         <!--th>remitido_id</th-->
                         <!--th></th--> 
                         <th>FECHA</th>
                         <th>TIPO</th>
                         <th>NUMERO</th>
                         <th>ASUNTO</th>
                         <th>FIRMADO</th>
                         <th>DIRIGIDO</th>
                         <th>ARCHIVO</th>
                         <th>CONSTE</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                 
                 @foreach ($remitidos as $remitido)
                  <tr>
                      
                      
                      <td> {{ Utils::formatDate($remitido->fecha_remitidos) }} </td>
                      <td> {{ $helper->getHelperByDominioAndId('tipo_memo',$remitido->tipo_remitido_id) }} </td>
                      <td> {{ $remitido->numero_memo }} </td>
                      <td> {{ $remitido->asunto }} </td>
                      <td> {{ Agente::getResponsableByAreaId($remitido->firmado_id) }} </td>
                      <td> {{ $remitido->dirigido }} </td>
                      <td> {{ ArchivoActuacion::getArchivoNomnbreById($remitido->archivo_remitidos_id) }} </td>
                      <td> {{ $remitido->conste }} </td>
                      <td> <a href="{!! URL::action('RemitidosController@edit',$remitido->remitidos_id); !!}">Ver</a></td>

                  </tr>
                  @endforeach     

                 </tbody>
          </table>
        </div>
      </div>  

  

</div>
@stop