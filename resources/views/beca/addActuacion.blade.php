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
				
				
					
						<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<h3 >Agregar Actuaci&oacute;n</h3> 
							</div>
						</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Nro Actuaci&oacute;n</label>
								<div class="col-md-8"><input class="form-control input-sm" name="dni" value=''></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Fecha</label>
								<div class="col-md-8"><input class="form-control input-sm" name="dni" value=''></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label class="control-label col-md-2">Observaciones</label>
								<div class="col-md-8"><input class="form-control input-sm" name="dni" value=''></div>
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
@stop