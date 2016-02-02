@extends('app')

@section('content')

<? use App\domain\Utils;
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
                <button type="button" class="btn btn-default pull-left" aria-label="Left Align">
                <a href="{!! URL::action('ActuacionController@altaActuacion'); !!}" aria-label="Left Align">Alta Actuaci&oacute;n</a></button>
              </div>
     <div class="row">      
        <form method="GET" action="{{action('ActuacionController@listActuacion')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
              <div class="form-group">
                    <input type="text" class="form-control " name="str_actuacion" placeholder="" id="search_actuacion">
                    <button type="submit" class="btn btn-default" id="buscar_actuacion">Buscar</button>
              </div>   
         </div>
        </form>
    </div>
</div>

<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-responsive table-striped table-bordered table-hover" id="actuacion">
            <thead>
                <tr>                   
                   <!--th>actuacion_id</th-->
                   <th>PREF.</th>
                   <th>ACTUACI&Oacute;N</th>
                   <th>FECHA</th>
                   <th>ASUNTO</th>
                   <th>DIRIGIDO</th>  
                   <th>REMITE</th>
                   <th>RECIBIO</th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
            @foreach ($actuaciones as $actuacion)
            <tr>
                <td> {{ $actuacion->prefijo }} </td>
                <td> {{ $actuacion->numero_actuacion  }} </td>
                <td> {{ Utils::formatDate($actuacion->actuacion_fecha) }} </td>
                <td> {{ $actuacion->asunto}} </td>
                <td> {{ $actuacion->dirigido}} </td>
                <td> {{ $actuacion->remite}} </td>
                <td> {{ $actuacion->conste}} </td>
                <!--td> {{ $actuacion->actuacion_id}} </td-->
                <td> <a href="{!! URL::action('ActuacionController@edit',$actuacion->actuacion_id); !!}">Ver</a></td>

            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php //echo $becas->render(); ?>

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

            });
</script>
@stop