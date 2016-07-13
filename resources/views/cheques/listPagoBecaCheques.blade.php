@extends('app')

@section('content')

<? 
use App\domain\Utils;
use App\domain\Actuacion;
use App\domain\PagoCheque;
?>

  <!--div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"> Centro de Formaci&oacute;n Judicial > Mesa de Entrada > Actuaciones </h3>
                </div>
                <!-- /.col-lg-12 -->
 <!--/div-->
 <ul class="breadcrumb">
    <li>Pago Cheques</li>
    <li class="active">Listado Pago Becas</li>
</ul>

<div class="panel panel-default">
 
 <div class="panel-heading">
      <div class="form-group pull-left">
                <a  class="btn btn-default pull-left" href="{!! URL::action('ChequesController@altaPagoBecaCheque'); !!}" aria-label="Left Align">Alta Pago Cheque</a>
              </div>
     <div class="row">      
      
        <div class="row">
              <div class="form-group">
                
                <a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a>

                <form method="GET" action="{{action('ChequesController@listPagoBecaCheques')}}" class="navbar-form navbar-left pull-right" role="search">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="hidden" name="search"/>
                            <input type="text" class="form-control " name="str_cheque" placeholder="" id="search_cheque">
                            <button type="submit" class="btn btn-default" id="buscar_cheque">Buscar</button>
                </form>
              </div>   
         </div>
        
    </div>
</div>
<!-- Modal Busqueda -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" id="myModalLabel">B&uacute;squeda</h4>
            </div>
            <form method="GET" action="{{action('ChequesController@busquedaAvanzadaBecaPagoCheque')}}" role="search">
                <div class="modal-body">
        
<!-- Nro Disposición Aprueba  Nro. Memo Reintegro Monto Beneficiario  Disponible  Nro. Cheque Entregado-->
        <div class="row">
          <div class="col-lg-12 col-md-12">
            
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Disponible</label>
                <div class="col-md-8">
                  <select class="form-control" name="disponible_id" id="b_disponible_id">
                      <option value="" selected>-</option>
                      <option value="0">NO</option>
                      <option value="1">SI</option>
                  </select>
                </div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Entregado</label>
                <div class="col-md-8">
                  <select class="form-control" name="entregado" id="entregado">
                      <option value="" selected>-</option>
                      <option value="0">NO</option>
                      <option value="1">SI</option>
                  </select>
                </div>
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
<!--
[pago_cheque_id] => 1
                                    [curso_id] => 1
                                    [docente_id] => 1
                                    [nro_cheque] => 1
                                    [nro_expediente] => 1
                                    [orden_pago] => 1
                                    [importe] => 1000
                                    [fecha_retiro] => 2016-06-21 00:00:00
                                    [retirado_por] => pepe
                                    [entregado_por_id] => 1
                                    [nro_meno_id] => 2
                                    [aprobado_por] => resoluciÃ³n nro XXXX
                                    [timestamp] => 2016-06-21 14:22:08
-->


<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-bordered table-hover" id="cheque">
            <thead>
                <tr>                   
                   <!--th>Nro Disposición Otorga</th-->
                   <th>Nro Disposición Pago</th>
                   <th>Nro. Memo</th>
                   <th>Reintegro</th>
                   <th>Monto</th>
                   <th>Beneficiario</th> 
                   <th>Disponible</th> 
                   <!--th>Fecha</th-->
                   <th>Nro. Cheque</th>
                   <!--th>Nro. Expediente(TSJ)</th>
                   <th>Nro. Orden Pago (TSJ)</th-->
                    
                   <th>Entregado</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
            @foreach ($cheques as $cheque)
            <tr>
                
                <!--td> {{ $cheque->nro_disp_otorga }} </td-->
                <td> {{ $cheque->nro_disp_aprueba }} </td>
                <td> {{ PagoCheque::getNroMemoById($cheque->nro_memo_id) }} </td>
                <td> {{ $cheque->numero_reintegro}} </td>
                <td> {{ $cheque->importe}} </td>
                <td> {{ PagoCheque::getNombreBecario($cheque->beca_id)}}</td>
                <td> {{ PagoCheque::getDisponibleChequeById($cheque->disponible_id) }}</td>
                <!--td> {{ Utils::formatDate($cheque->fecha_retiro) }} </td-->
                <td> {{ $cheque->nro_cheque }} </td>
                <!--td> {{ $cheque->nro_expediente }} </td>
                <td> {{ $cheque->orden_pago }} </td-->
                
                
                 <td> {{ PagoCheque::getEntregadoChequeById($cheque->entregado_por_id) }}</td>
                <td> <a href="{!! URL::action('ChequesController@editPagoBecaCheque',$cheque->pago_cheque_id); !!}">Ver</a></td>

            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php echo $cheques->render(); ?>

<div id="res"></div>

<script type="text/javascript">
$(document).ready(function() {

              $('#search_cheque').on('change', function(d) {
                //alert('change');

                $('#buscar_cheque').click();

                });

              $('#a_buscar_cheque').on('click', function(d) {
                alert('buscala');
               });  
            });
</script>
@stop