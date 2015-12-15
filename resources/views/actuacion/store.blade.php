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
			<a href="{!! URL::asset('/altaActuacion') !!}" class="glyphicon glyphicon-arrow-left"></a>
		</button>
		Dar de Alta otra Actuaci&oacute;n
	</div>

  	<div class="panel-body">
	Actuaci&oacute;n Creada Con &eacute;xito!!!!! MADERFACAAAAAAA!!!!
	El Id es el siguiente : {{ $actuacion->actuaacion_id }}  
	</div> <!-- panel body -->
<script>



$('document').ready(function(){
	
});

</script>
@stop
