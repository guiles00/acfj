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
	<div class="panel-heading">
		<button type="button" class="btn btn-default" aria-label="Left Align">
			<a href="" class="glyphicon glyphicon-arrow-left"></a>
		</button>
		
	</div>

  <div class="panel-body">
	  
 	<form class="form-horizontal" role="form" method="POST" action="{{action('ActuacionController@store')}}">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

	  <div class="form-group">
      <label class="control-label col-sm-2" >Nro Actuaci&oacute;n:</label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="" name="nro_actuacion" required>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Fecha</label>
      <div class="col-sm-2">          
        <input type="date" class="form-control" id="" name="actuacion_fecha">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Fojas</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="actuacion_fojas">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2">Observaciones</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="actuacion_observaciones"></textarea>
      </div>
    </div>
    		<div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="">Guardar</button>
							<a href="" class="btn btn-default">Cancelar</a>
						</div>
			</div>
	</div>
</form>
</div> <!-- panel body -->
<script>



$('document').ready(function(){
	
});

</script>
@stop
