@extends('app')

@section('content')
  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listado</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<div class="panel panel-default">
 <div class="panel-heading">
     <div class="row">      
         <form method="GET" action="{{action('BecaController@index')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
                  <div class="form-group">      
                    <div class="col-md-4">
                          <select class="form-control search_beca" name="estado_id" id="estado_id">
                                <option value="-1">-</option>
                                <option value="0">CONFIRMAR EMAIL</option>
                                <option value="1">PENDIENTE</option>
                          </select> 
                    </div>        
                  </div> 
                  <div class="form-group">
                    <input type="text" class="form-control search_beca" name="str_beca" placeholder="" id="str_beca">
                    <button type="button" class="btn btn-default" id="buscar_solicitud_beca">Buscar</button>
                  </div>   
         </div>
        </form>
    </div>
</div>

<div class="panel-body">

    <div class="table-responsive">
        <table class="table table-responsive table-striped table-bordered table-hover" id="beca">
            <thead>
                <tr>
                   <th>fecha</th>
                   <th>beca_id</th>
                   <th>tipo_beca_id</th>
                   <th>Nombre</th>
                   <th>Monto</th>
                   <th>estado</th>
                   <th></th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
            @foreach ($becas as $beca)
            <tr>
                <td> {{ $beca->timestamp}} </td>
                <td> {{ $beca->beca_id}} </td>
                <td> {{ $beca->tipo_beca_id}} </td>
                <td> {{ $beca->usi_nombre}} </td>
                <td> {{ $beca->monto}} </td>
                <td> {{ $beca->estado_beca}} </td>
                <td> <a href="{{action('BecaController@verSolicitud',$beca->beca_id)}}">Ver</a></td>
                <td> <a href="{{action('BecaController@verDocAdjunta',$beca->beca_id)}}">Doc. Adjunta</a></td>
            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php //echo $becas->render(); ?>

<div id="res"></div>

<script type="text/javascript">
$(document).ready(function() {
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

              /*$('#search_beca').on('change', function(d) {
                //alert('change');

                $('#buscar_solicitud_beca').click();

                });

              $('#estado_id').on('change', function(d) {
                //alert('change');
                console.debug($('#estado_id').val());
                $('#buscar_solicitud_beca').click();

                });
              */

            });
</script>
@stop