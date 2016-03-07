@extends('app')

@section('content')

<? 
use App\domain\Utils;
use App\domain\Actuacion;
?>

  <!--div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"> Centro de Formaci&oacute;n Judicial > Mesa de Entrada > Actuaciones </h3>
                </div>
                <!-- /.col-lg-12 -->
 <!--/div-->
 <ul class="breadcrumb">
    <li>Mesa de Entrada</li>
    <li class="active">Listado</li>
</ul>

<div class="panel panel-default">
 
 <div class="panel-heading">
      <div class="form-group pull-left">
                <!--button type="button" class="btn btn-default pull-left" aria-label="Left Align"-->
                <a  class="btn btn-default pull-left" href="{!! URL::action('ActuacionController@altaActuacion'); !!}" aria-label="Left Align">Alta Actuaci&oacute;n</a><!--/button-->
              </div>
     <div class="row">      
      
        <div class="row">
              <div class="form-group">
                <!--button type="submit" class="btn btn-default glyphicon glyphicon-search" id="a_abuscar_actuacion" data-target="#basicModal"></button-->
                <a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a>

                <form method="GET" action="{{action('ActuacionController@listActuacion')}}" class="navbar-form navbar-left pull-right" role="search">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <input type="text" class="form-control " name="str_actuacion" placeholder="" id="search_actuacion">
                            <button type="submit" class="btn btn-default" id="buscar_actuacion">Buscar</button>
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
            <h4 class="modal-title" id="myModalLabel">B&uacute;squeda de Actuaciones</h4>
            </div>
            <form method="GET" action="{{action('ActuacionController@listActuacion')}}" role="search">
                <div class="modal-body">
        

        <div class="row">
          <div class="col-lg-12 col-md-12">
            
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Asignaci&oacute;n Inicial</label>
                <div class="col-md-8"><input class="form-control input-sm" name="str_destino" value=''></div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Recibi&oacute;</label>
                <div class="col-md-8"><input class="form-control input-sm" name="str_actuacion" value=''></div>
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
        <table class="table table-responsive table-striped table-bordered table-hover" id="actuacion">
            <thead>
                <tr>                   
                   <!--th>actuacion_id</th-->
                   <!--th></th-->
                   <th>PREF.</th>
                   <th>ACTUACI&Oacute;N</th>
                   <th>FECHA</th>
                   <th>ASUNTO</th>
                   <th>DIRIGIDO</th>  
                   <th>ASIGNACI&Oacute;N INICIAL</th>
                   <th>CAUSANTE</th>
                   <th>RECIBI&Oacute;</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
              <?php $total = count($actuaciones);?> 
            @foreach ($actuaciones as $actuacion)
            <tr>
                <!--td> {{ $total-- }} </td-->
                <td> {{ $actuacion->prefijo }} </td>
                <td> {{ $actuacion->numero_actuacion  }} </td>
                <td> {{ Utils::formatDate($actuacion->actuacion_fecha) }} </td>
                <td> {{ $actuacion->asunto}} </td>
                <td> {{ $actuacion->dirigido}} </td>
                <td> {{ Actuacion::getDestinoById($actuacion->area_destino_id) }} ( {{ Actuacion::getResponsableByAreaId($actuacion->area_destino_id)}} )</td>
                <td> {{ $actuacion->remite}} </td>
                <td> {{ Actuacion::getAgenteById($actuacion->conste_agente_id)}} </td>
                <!--td> {{ $actuacion->actuacion_id}} </td-->
                <td> <a href="{!! URL::action('ActuacionController@edit',$actuacion->actuacion_id); !!}">Ver</a></td>

            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php echo $actuaciones->render(); ?>

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
              $('#search_actuacion').on('change', function(d) {
                //alert('change');

                $('#buscar_actuacion').click();

                });
              /*
              $('#estado_id').on('change', function(d) {
                //alert('change');
                console.debug($('#estado_id').val());
                $('#buscar_actuacion').click();

                });
              */
              $('#a_buscar_actuacion').on('click', function(d) {
                alert('buscala');
               });  
            });
</script>
@stop