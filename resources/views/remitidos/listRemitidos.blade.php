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
  

        <a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a> 

        <form method="GET" action="{{action('RemitidosController@listRemitidos')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="busqueda"/>
             <div class="row">
  


              <div class="form-group">
                    <input type="text" class="form-control " name="str_remitido" placeholder="" id="search_remitido">
                    <button type="submit" class="btn btn-default" id="buscar_remitido">Buscar</button>
              </div>   

         </div>
        </form>
    </div>
  </div>
    


<!-- Modal Busqueda -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" id="myModalLabel">B&uacute;squeda de Remitidos</h4>
            </div>
            <form method="GET" action="{{action('RemitidosController@busquedaAvanzada')}}" role="search">
                <div class="modal-body">
        

        <div class="row">
          <div class="col-lg-12 col-md-12">
            
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">A&ntilde;o</label>
                <div class="col-md-8">
                   <select class="form-control" name="anio">
                      <option value="">-</option>
                      <option value="2016">2016</option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                    </select>
                </div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">N&uacute;mero</label>
                <div class="col-md-8"><input class="form-control input-sm" name="str_numero" value=''></div>
              </div>
            </div> 
        </div>
      </div>

                </div>
                <div class="modal-footer">
             
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Buscar</button>
             
            </div>
         </form>
    </div>
  </div>
</div>

<!-- -->



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
                      <td> {{ $remitido->numero_memo }}/{{ $remitido->anio }} </td>
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