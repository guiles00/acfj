@extends('app')

@section('content')

<? use App\domain\Actuacion;
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
    <li class="active">Alta Actuaci&oacute;n</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ActuacionController@listActuacion')}}"></a>
		</div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="a_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>El N&uacute;mero de Actuaci&oacute;n ya existe en la base!!</b>
    </div>

  <div class="panel-body">
	 
 	<form class="form-horizontal" role="form" method="POST" action="{{action('ActuacionController@store')}}" id="a_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

	  <div class="form-group">
      <label class="control-label  col-sm-2" >Actuaci&oacute;n</label>
         <div class="col-sm-2">
        
         <select class="form-control" name="codigo_actuacion" id="a_codigo_actuacion">
            <option value="" selected></option>
            <option value="BEC">BEC</option>
            <option value="CAP">CAP</option>
            <option value="CNV">CNV</option>
            <option value="ADM">ADM</option>
            </select>
      </div>
      <div class="col-sm-2">
        <input type="number" class="form-control" id="a_numero_actuacion" name="nro_actuacion" required value="{{ Actuacion::getLastNumber() }}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="actuacion_fecha" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Asunto</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="actuacion_asunto"></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Dirigido</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_dirigido" value="Molina Quiroga, Eduardo">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">Asignaci&oacute;n Inicial</label>
        <div class="col-md-6">
          <select class="form-control select2" name="area_destino_id" id="a_area_destino_id">
          <option value="0">-</option>
          @foreach($area_cfj as $key=>$area)
          <option value="{{$area->area_cfj_id}}">{{$area->area_nombre}} ( {{$area->area_responsable}} )</option>
          @endforeach
          </select>
        </div>
    </div>    
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Causante</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_remite">
      </div>
    </div>
    
    <!--div class="form-group">
      <label class="control-label  col-sm-2">Recibi&oacute;</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_conste">
      </div>
    </div-->
   
   <div class="form-group">
      <label class="control-label col-md-2">Recibi&oacute;</label>
        <div class="col-md-6">
          <select class="form-control select2" name="conste_agente_id">
          <option value="0">-</option>
          @foreach($conste_agente as $key=>$agente)
          <option value="{{$agente->agente_id}}">{{$agente->agente_nombre}}</option>
          @endforeach
          </select>
        </div>
    </div>      

    <div class="form-group">
      <label class="control-label  col-sm-2">Fojas</label>
      <div class="col-sm-2">          
        <input type="number" class="form-control" id="" name="actuacion_fojas">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Observaciones</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="actuacion_observaciones"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Archivo</label>
        <div class="col-md-4">
          <select class="form-control select2" name="archivo_actuacion_id">
          <option value="0">-</option>
          @foreach($archivo_actuacion as $key=>$archivo)
          <option value="{{$archivo->archivo_actuacion_id}}">{{$archivo->nombre_archivo}}</option>
          @endforeach
          </select>
        </div>
    </div>
    
    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="a_alta_actuacion">Guardar</button>
							<a href="{{action('ActuacionController@listActuacion')}}" class="btn btn-default">Cancelar</a>
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
              $('.datepicker').datepicker('setDate', new Date());
              $('.datepicker').datepicker('update');
              $('.datepicker').val('');
              

              $('#a_numero_actuacion').on('change', function(d) {
              
               //alert('busco');
                var numero_actuacion = $('#a_numero_actuacion').val();
               // return false;
              
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroActuacion',
                          data: {'numero_actuacion':numero_actuacion},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#a_alert_esta').hide();
                              $('#a_alta_actuacion').removeAttr('disabled');
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#a_alert_esta').show();
                              $('#a_alta_actuacion').attr('disabled','disabled');
                            }
                          }
                        });
                });

            $("#a_form_alta").submit(function(e) {
                 var self = this;
                 e.preventDefault();
                 
                 //Chequeo que el numero no este en la base

               var numero_actuacion = $('#a_numero_actuacion').val();
               
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroActuacion',
                          data: {'numero_actuacion':numero_actuacion},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#a_alert_esta').hide();
                            //  $('#a_alta_actuacion').removeAttr('disabled');
                              self.submit();
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#a_alert_esta').show();
                             // $('#a_alta_actuacion').attr('disabled','disabled');
                            }
                           
                          }
                        });

                 return false; //is superfluous, but I put it here as a fallback
            });
  
            //Esta harcodeado para ver si es asi como deberia funcionar
            //Las constantes BEC,ADM,CAP y CNV las dejo
            // Traer de la base (SI ES NECESARIO) las relaciones entre codigo y area 
            $("#a_codigo_actuacion").on('change', function(d) {

              var codigo_actuacion = $("#a_codigo_actuacion").val();
               
               if( codigo_actuacion == 'BEC' || codigo_actuacion == 'CNV' ){
                $("#a_area_destino_id").val(3).change();;     
               }

               if( codigo_actuacion == 'ADM' || codigo_actuacion == 'CAP' ){
                $("#a_area_destino_id").val(4).change();;     
               }

               if( codigo_actuacion == '' ){
                $("#a_area_destino_id").val(0).change();;     
               }                

            });

});
</script>

@stop
