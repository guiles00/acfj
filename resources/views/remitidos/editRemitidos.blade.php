@extends('app')

@section('content')

<? use App\domain\Remitidos;
?>
<!--div class="container"-->
<style>
.btn span.glyphicon {    			
	opacity: 0;				
}
.btn.active span.glyphicon {				
	opacity: 1;				
}
</style>
 <ul class="breadcrumb">
    <li>Mesa de Entrada</li>
    <li class="active">Editar Remitidos</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
		<button type="button" class="btn btn-default" aria-label="Left Align">
			<a href="{{action('RemitidosController@listRemitidos')}}" class="glyphicon glyphicon-arrow-left"></a>
		</button>
		
	</div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="r_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>El N&uacute;mero de Actuaci&oacute;n ya existe en la base!!</b>
    </div>

  <div class="panel-body">
	 
       <?php if(isset($edited)){?>
        <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Registro Editado!</b>
        </div>
      <?php } ?> 



 	<form class="form-horizontal" role="form" method="POST" action="{{action('RemitidosController@update')}}" id="r_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$remitido->remitidos_id}}" />

	  
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="remitidos_fecha" value="{{$remitido->fecha_remitidos}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">Tipo</label>
        <div class="col-md-4">
          <select class="form-control select2" name="tipo_remitido_id" id="r_tipo_remitido_id">
          @foreach($tipos_memo as $key=>$tipo_memo)
          <?php if( $remitido->tipo_remitido_id == $tipo_memo->dominio_id ){?>
          <option value="{{$tipo_memo->dominio_id}}" selected>{{$tipo_memo->nombre}}</option>
          <?php }else{?>
          <option value="{{$tipo_memo->dominio_id}}">{{$tipo_memo->nombre}}</option>
          <?php }?>
          @endforeach
          </select>
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">N&uacute;mero</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="numero_memo" value="{{$remitido->numero_memo}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Asunto</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="remitidos_asunto" >{{$remitido->asunto}}</textarea>
      </div>
    </div>
    


    <div class="form-group">
      <label class="control-label  col-md-2">Firmado</label>
        <div class="col-md-4">
          <select class="form-control select2" name="area_destino_id" id="r_area_destino_id">
          <option value="0">-</option>
          @foreach($area_cfj as $key=>$area)
          <?php if( $area->area_cfj_id == $remitido->firmado_id ){?>
          <option value="{{$area->area_cfj_id}}" selected>{{$area->area_nombre}} ( {{$area->area_responsable}} )</option>
          <?php }else{?>
          <option value="{{$area->area_cfj_id}}">{{$area->area_nombre}} ( {{$area->area_responsable}} )</option>
          <?php }?>
          @endforeach
          </select>
        </div>
    </div>    
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Dirigido</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="remitidos_dirigido" value="{{$remitido->dirigido}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Archivo</label>
        <div class="col-md-4">
          <select class="form-control select2" name="archivo_remitidos_id">
          @foreach($archivo_remitidos as $key=>$archivo)
           <?php if( $archivo->archivo_actuacion_id == $remitido->archivo_remitidos_id ){?>
           <option value="{{$archivo->archivo_actuacion_id}}" selected>{{$archivo->nombre_archivo}}</option>
           <?php }else{?>
           <option value="{{$archivo->archivo_actuacion_id}}">{{$archivo->nombre_archivo}}</option>
           <?php }?>
          @endforeach
          </select>
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Conste</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="remitidos_conste" value="{{$remitido->conste}}">
      </div>
    </div>

    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="r_alta_remitidos">Guardar</button>
							<a href="{{action('RemitidosController@listRemitidos')}}" class="btn btn-default">Cancelar</a>
						</div>
		</div>
	</div>
</form>
</div> <!-- panel body -->

<script>
$(document).ready(function() {

              $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                  }
                );

              $('#r_numero_remitidos').on('change', function(d) {
              
               //alert('busco');
                var numero_remitidos = $('#r_numero_remitidos').val();
               // return false;
              
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroRemitidos',
                          data: {'numero_remitidos':numero_remitidos},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#r_alert_esta').hide();
                              $('#r_alta_remitidos').removeAttr('disabled');
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#r_alert_esta').show();
                              $('#r_alta_remitidos').attr('disabled','disabled');
                            }
                          }
                        });
                });

           /* $("#r_form_alta").submit(function(e) {
                 var self = this;
                 e.preventDefault();
                 
                 //Chequeo que el numero no este en la base

               var numero_remitidos = $('#r_numero_remitidos').val();
               
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroRemitidos',
                          data: {'numero_remitidos':numero_remitidos},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#r_alert_esta').hide();
                            //  $('#r_alta_remitidos').removeAttr('disabled');
                              self.submit();
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#r_alert_esta').show();
                             // $('#r_alta_remitidos').attr('disabled','disabled');
                            }
                           
                          }
                        });

                 return false; //is superfluous, but I put it here as a fallback
            });
            */
            //Esta harcodeado para ver si es asi como deberia funcionar
            //Las constantes BEC,ADM,CAP y CNV las dejo
            // Traer de la base (SI ES NECESARIO) las relaciones entre codigo y area 
            $("#r_codigo_remitidos").on('change', function(d) {

              var codigo_remitidos = $("#r_codigo_remitidos").val();
               
               if( codigo_remitidos == 'BEC' || codigo_remitidos == 'CNV' ){
                $("#r_area_destino_id").val(1).change();;     
               }

               if( codigo_remitidos == 'ADM' || codigo_remitidos == 'CAP' ){
                $("#r_area_destino_id").val(2).change();;     
               }

               if( codigo_remitidos == '' ){
                $("#r_area_destino_id").val(0).change();;     
               }                

            });

});
</script>

@stop
