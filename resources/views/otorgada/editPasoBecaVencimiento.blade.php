@extends('app')

@section('content')

<!--div class="container"-->
<style>
.btn span.glyphicon {    			
	opacity: 0;				
}
.btn.active span.glyphicon {				
	opacity: 1;				
}
</style>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<form method="POST" action="{{action('BecaOtorgadaController@updatePasoBecaVencimiento')}}" accept-charset="UTF-8" class="form-horizontal" role="form" id="ps_form_edit">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="beca_id" value='{{$paso_beca->beca_id}}' id="b_beca_id" />
					<input type="hidden" name="paso_beca_id" value='{{$paso_beca->paso_beca_id}}' id="b_paso_beca_id" />
				
					
						<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h3>&nbsp;&nbsp;Acci&oacute;n  {{$paso_beca->paso_beca_id}}</h3> 
							</div>
						</div>
						</div>
						
				   <div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo Acci&oacute;n</label>
					<div class="col-md-8">
								<select id="b_tipo_paso_beca_id" class="form-control" name="tipo_paso_beca_id">
								@foreach($t_pasos as $key=>$t_paso)
								
								<?php if( $paso_beca->tipo_paso_beca_id == $t_paso->t_paso_beca_id ){?>
								<option value="{{$t_paso->t_paso_beca_id}}" selected>{{$t_paso->t_paso_beca}}</option>
 								<?php }else{?>
 								<option value="{{$t_paso->t_paso_beca_id}}">{{$t_paso->t_paso_beca}}</option>
 								<?php }?>
								@endforeach
								</select>
							</div>
						</div>
					</div>

				 	<div class="form-group">
				      <label class="control-label col-sm-2">Fecha Auto</label>
				      <div class="col-sm-4">          
				        <input type="text" class="form-control datepicker"  name="paso_beca_fecha" id="b_paso_beca_fecha" value="{{ date('Y-m-d') }}" >
				      </div>
				    </div>
					<div class="form-group">
				      <label class="control-label col-sm-2">Fecha Vencimiento</label>
				      <div class="col-sm-4">          
				        <input type="text" class="form-control datepicker"  name="paso_beca_fecha_vencimiento" id="b_paso_beca_fecha_vencimiento" value="{{ $paso_beca->fecha_vencimiento }}" >
				      </div>
				    </div>

				    <div class="form-group">
				      <label class="control-label col-sm-2">Fecha Envio</label>
				      <div class="col-sm-4">          
				        <input type="text" class="form-control datepicker"  name="paso_beca_fecha_envio" id="b_paso_beca_fecha_envio" value="{{ $paso_beca->fecha_envio }}" disabled>
				      </div>
				    </div>	


				    <div class="form-group">
						<label class="control-label col-md-2">Firmante</label>
						<div class="col-md-8">
									<select id="b_firmante_id" class="form-control" name="firmante_id">
									@foreach($firmantes as $key=>$agente)
									<?php if( $paso_beca->firmante_id == $agente->agente_id ){?>
									<option value="{{$agente->agente_id}}" selected>{{$agente->agente_nombre}}</option>
	 								<?php }else{?>
	 								<option value="{{$agente->agente_id}}">{{$agente->agente_nombre}}</option>
	 								<?php }?>
									@endforeach
									</select>
						</div>
					</div>

					<div class="form-group">
					     <label class="control-label col-sm-2">Observaciones</label>
					     <div class="col-sm-8">          
					        <textarea type="text" class="form-control"  name="paso_beca_observaciones" value='' id='b_paso_beca_observaciones' >{{ $paso_beca->observaciones}}</textarea>
					      </div>
					</div>
					<div class="form-group">
					      <label class="control-label col-sm-2">Texto</label>
					      <div class="col-sm-10">          <!-- id='b_paso_texto_email' -->
					        <textarea id="b_paso_texto_email" type="text" rows="15" class="form-control"  name="paso_texto_email" value=''  >{{ $paso_beca->texto_email}}</textarea>
					      </div>
					</div>
					    			
			</div>	

				<div class="form-group"> 
					<div class="col-sm-offset-1 col-sm-10">
						<button type="button" class="btn btn-default" id="pv_submit">Guardar</button>
						<a href="{!! URL::action('BecaOtorgadaController@verBecaOtorgada',$paso_beca->beca_id); !!}" class="btn btn-default">Volver</a>
						<button type="button" class="btn btn-default" id="b_enviar_email">Enviar Email Documentaci&oacute;n</button>
					</div>
					<div id="pv_add_res" class="col-sm-offset-1 col-sm-10">
						
					</div>
				</div>
				
			</form>
		</div>
	</div>
</div>


<script>
$(document).ready(function() {


$('#pv_submit').click(function(){

	//alert('guardo');

var data = $('#ps_form_edit').serializeArray();
//Traigo la data del editor y reemplazo el contenido para que este el actual
var editorData = CKEDITOR.instances.b_paso_texto_email.getData();
console.debug(data);
data[8].value = editorData; //OJO QIE CADA VEZ QUE AGREGO UN CAMPO TENGO QUE MODIFICAR LA UBICACION DEL ARRAY

	$.ajax({
		                url : "../updatePasoBecaVencimiento"
		                ,data: data
		                ,type:'POST'
		                ,success : function(result) {
		                	
		                	var msg = (result == true)?'modificado con exito':'ocurrio un error intente mas tarde'; 
		                	
 		                	$('#pv_add_res').html(msg);
		                	
		                }
     			});  
	
})

$('#b_tipo_paso_beca_id').change(function(data){

	var t_paso_id = data.target.value;

				$.ajax({
		                url : "../traeTextoPaso"
		                ,data: {'id':t_paso_id}
		                ,success : function(result) {
		                	//$('#b_paso_texto_email').html(result);
		                	//console.debug(result);

		                	CKEDITOR.instances.b_paso_texto_email.setData(result);
		                }
     			});   



});

$('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                    ,orientation: 'auto bottom'
                  }
                );

	

CKEDITOR.replace('b_paso_texto_email', {
                  language: 'es',
});



	$('#b_enviar_email').click(function(){
		
		var paso_beca_id = $('#b_paso_beca_id').val();

			$.ajax({
		                url : "../enviarEmailIntimacion"
		                ,data: {'paso_beca_id':paso_beca_id}
		                ,success : function(result) {
		                	
		                	$('#pv_add_res').html(result);

		                }
		              });   

	});
	
            

});
</script>
@stop