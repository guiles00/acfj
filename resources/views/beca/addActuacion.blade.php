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
				<form method="POST" action="{{action('BecaController@saveActuacion')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="beca_id" value='{{$beca_id}}' />
					<input type="hidden" name="actuacion_id" value='' id="b_actuacion_id" />
				
					
						<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h3 >Agregar Actuaci&oacute;n</h3> 
							</div>
						</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Prefijo</label>
								<div class="col-md-8"><input class="form-control input-sm" name="prefijo_actuacion" value='' id='b_prefijo_actuacion' disabled></div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Nro Actuaci&oacute;n</label>
								<div class="col-md-8"><input class="form-control input-sm" name="numero_actuacion" value='' id='b_numero_actuacion'></div>
							</div>
						</div>
					
					 <div class="form-group">
					      <label class="control-label col-sm-2">Fecha</label>
					      <div class="col-sm-4">          
					        <input type="text" class="form-control"  name="actuacion_fecha" id="b_actuacion_fecha" value="" disabled>
					      </div>
					    </div>

					    <div class="form-group">
					      <label class="control-label col-sm-2">Asunto</label>
					      <div class="col-sm-8">          
					        <textarea type="text" class="form-control"  name="actuacion_asunto" id="b_asunto" disabled></textarea>
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <label class="control-label col-sm-2">Dirigido</label>
					      <div class="col-sm-6">          
					        <input type="text" class="form-control"  name="actuacion_dirigido" value='' id='b_actuacion_dirigido' disabled>
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <label class="control-label col-sm-2">Remite</label>
					      <div class="col-sm-6">          
					        <input type="text" class="form-control"  name="actuacion_remite" value='' id='b_actuacion_remite' disabled>
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <label class="control-label col-sm-2">Recibi&oacute;</label>
					      <div class="col-sm-6">          
					        <input type="text" class="form-control"  name="actuacion_conste" value='' id='b_actuacion_conste' disabled>
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <label class="control-label col-sm-2">Fojas</label>
					      <div class="col-sm-2">          
					        <input type="text" class="form-control"  name="actuacion_fojas" value='' id='b_actuacion_fojas' disabled>
					      </div>
					    </div>

					    <div class="form-group">
					      <label class="control-label col-sm-2">Observaciones</label>
					      <div class="col-sm-8">          
					        <textarea type="text" class="form-control"  name="actuacion_observaciones" value='' id='b_actuacion_observaciones' disabled></textarea>
					      </div>
					    </div>
					    



						
			</div>	
						
				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Agregar</button>
						<!--a href="{!! URL::action('BecaController@verSolicitud',$beca_id); !!}" class="btn btn-default">Agregar</a-->
						<a href="{!! URL::action('BecaController@verSolicitud',$beca_id); !!}" class="btn btn-default">Cancel</a>
					</div>
				</div>	

			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {

	            
              $('#b_numero_actuacion').on('change', function(d) {
              
                //alert('busco');
                var numero_actuacion = $('#b_numero_actuacion').val();
                
              
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: '../getDatosActuacion',
                          data: {'numero_actuacion':numero_actuacion},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                            	alert('El número de actuación no existe');
                            	return false;
                            } 

                            $('#b_actuacion_fecha').val(data.actuacion_fecha);
                            $('#b_asunto').val(data.asunto);
                            $('#b_actuacion_id').val(data.actuacion_id);
                            $('#b_prefijo_actuacion').val(data.prefijo);
                            $('#b_actuacion_remite').val(data.remite);

                            $('#b_actuacion_dirigido').val(data.dirigido);
                            $('#b_actuacion_conste').val(data.conste);
                            $('#b_actuacion_fojas').val(data.fojas);
                            $('#b_conste_actuacion').val(data.conste);
                            $('#b_actuacion_observaciones').val(data.observaciones);
                            console.debug(data);

                          }
                        });

              
                });

});
</script>
@stop