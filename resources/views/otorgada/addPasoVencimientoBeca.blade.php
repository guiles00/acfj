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
				<form method="POST" action="{{action('BecaOtorgadaController@savePasoBeca')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="beca_id" value='{{$beca_id}}' id="b_paso_beca_id" />
				
					
						<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h3 >Agregar Acci&oacute;n</h3> 
							</div>
						</div>
						</div>

						<!--div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Tipo Accion</label>
								<div class="col-md-8"><input class="form-control input-sm" name="tipo_paso_beca_id" value='' id='b_tipo_paso_beca_id' ></div>
							</div>
						</div-->
						
				   <div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo Acci&oacute;n</label>
					<div class="col-md-8">
								<select id="b_tipo_paso_beca_id" class="form-control" name="tipo_paso_beca_id">
								@foreach($t_pasos as $key=>$t_paso)
								<option value="{{$t_paso->t_paso_beca_id}}">{{$t_paso->t_paso_beca}}</option>
								@endforeach
								</select>
							</div>
						</div>
					</div>
					
				 	<div class="form-group">
				      <label class="control-label col-sm-2">Fecha Ingreso</label>
				      <div class="col-sm-4">          
				        <input type="text" class="form-control datepicker"  name="paso_beca_fecha" id="b_paso_beca_fecha" value="{{ date('Y-m-d') }}" >
				      </div>
				    </div>
					<div class="form-group">
				      <label class="control-label col-sm-2">Fecha Vencimiento</label>
				      <div class="col-sm-4">          
				        <input type="text" class="form-control datepicker"  name="paso_beca_fecha_vencimiento" id="b_paso_beca_fecha_vencimiento" value="{{ date('Y-m-d') }}" >
				      </div>
				    </div>	
					    <div class="form-group">
					      <label class="control-label col-sm-2">Observaciones</label>
					      <div class="col-sm-8">          
					        <textarea type="text" class="form-control"  name="paso_beca_observaciones" value='' id='b_paso_beca_observaciones' ></textarea>
					      </div>
					    </div>
					    			
			</div>	
						
				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Agregar</button>
						<!--a href="{!! URL::action('BecaController@verSolicitud',$beca_id); !!}" class="btn btn-default">Agregar</a-->
						<a href="{!! URL::action('BecaOtorgadaController@verBecaOtorgada',$beca_id); !!}" class="btn btn-default">Cancel</a>
					</div>
				</div>	

			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {


$('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                    ,orientation: 'auto bottom'
                  }
                );
	
});
</script>
@stop