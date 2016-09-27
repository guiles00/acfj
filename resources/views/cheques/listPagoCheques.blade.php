@extends('app')

@section('content')
@inject('pago_cheque','App\domain\PagoCheque')
<? 
//use App\domain\Utils;
//use App\domain\Actuacion;
//use App\domain\PagoCheque;
?>

  <!--div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"> Centro de Formaci&oacute;n Judicial > Mesa de Entrada > Actuaciones </h3>
                </div>
                <!-- /.col-lg-12 -->
 <!--/div-->
 <ul class="breadcrumb">
    <li>Pago Cheques</li>
    <li class="active">Listado Pago Cursos</li>
</ul>
<span style="color:red; font-size: medium;">&Uacute;timo n&uacute;mero de recibo registrado en el sistema: {{$nro_recibo}}</span>
<div class="panel panel-default">
 <div class="panel-heading">
      <div class="form-group pull-left">
        <a  class="btn btn-default pull-left" href="{!! URL::action('ChequesController@altaPagoCheque'); !!}" aria-label="Left Align">Alta Pago Cheque</a><!--/button-->
       
      </div>
     <div class="row">      
      
        <div class="row">
              <div class="form-group">
                
                <a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" onClick=" alert('filtro avanzado, NO LO HICE TODAVIA')" data-target="#basicModal"></a>

                <form method="GET" action="{{action('ChequesController@listPagoCheques')}}" class="navbar-form navbar-left pull-right" role="search">
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
            <form method="GET" action="{{action('ChequesController@busquedaAvanzadaCursoPagoCheque')}}" role="search">
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
                   <th>Nro Recibo</th>                   
                   <th>Nro Disposici&oacute;n Fija Fecha</th>                   
                   <th>Nro Disposici&oacute;n Pago</th>
                   <th>Nro. Memo</th>
                   <th>Monto Solicitado</th>
                   <th>Actividad</th> 
                   <th>Subgrupo</th>
                   <th>Beneficiario</th> 
                   <th>Disponible</th> 
                   <th>Importe Cheque</th>
                   <th>Entregado</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
            @foreach ($cheques as $cheque)
            <tr>
                <td> {{ $cheque->nro_recibo }} </td>
                <td> {{ $cheque->nro_disp_otorga }} </td>
                <td> {{ $cheque->nro_disp_aprueba }} </td>
                <td> {{  $pago_cheque::getNroMemoById($cheque->nro_memo_id) }} </td>
                <td> $ {{ $cheque->importe}} </td>
                <td> {{  $pago_cheque::getNombreCursoById($cheque->curso_id)}}</td>
                <td> {{  $pago_cheque::getNombreSubgrupoById($cheque->curso_id)}}</td>
                <td> {{  $pago_cheque::getNombreDocenteById($cheque->docente_id)}}</td>
                <td> {{  $pago_cheque::getDisponibleChequeById($cheque->disponible_id) }}</td>
                <td> $  {{ $cheque->importe_cheque}} </td>
                <td> {{  $pago_cheque::getEntregadoChequeById($cheque->entregado_por_id) }}</td>
                <td> <a href="{!! URL::action('ChequesController@editCursoPagoCheque',$cheque->pago_cheque_id); !!}">Ver</a></td>
            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php echo $cheques->render(); ?>

<div id="res"></div>

<script type="text/javascript">
$(document).ready(function() {
              /*
              $('.search_beca').on('change', function(d) { // keyup paste
                

                  console.log('I am pretty sure the text box changed');
                  //alert('okaaasasasa');
                  console.debug(d.target.value);
                  var str_beca = $('#str_beca').val();
                  var estado_id = $('#estado_id').val();

                  $.ajax({
                          url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listBecas',
                          data: {'str_beca':str_beca,'estado_id':estado_id},
                          success: function(data){
                           // console.debug(data);
                            $('#res').html(data);
                          }
                          //dataType: dataType
                        });

                });
              */
              $('#search_cheque').on('change', function(d) {
                //alert('change');

                $('#buscar_cheque').click();

                });
              /*
              $('#estado_id').on('change', function(d) {
                //alert('change');
                console.debug($('#estado_id').val());
                $('#buscar_cheque').click();

                });
              */
              $('#a_buscar_cheque').on('click', function(d) {
                //alert('buscala');
               });  
            });
</script>
@stop