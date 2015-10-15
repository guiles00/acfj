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
			<a href="{!! URL::action('BecaController@index'); !!}" class="glyphicon glyphicon-arrow-left"></a>

			<!--a href="{{action('AlumnosController@create')}}" class="glyphicon glyphicon-plus" align="right"></a-->

			<!--span class="glyphicon glyphicon-plus" aria-hidden="true"></span-->
		</button>
		Volver a Becas
	</div>
<?php  
/*echo "<pre>"; //print_r($beca);//
print_r($beca);
exit;*/

$generos = ["1"=>"Masculino","2"=>"Femenino","3"=>"Otro"];
?>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<form method="POST" action="{{action('AlumnosController@store')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="_id" value='' />
				
				
					<!--div class="row">
						<div class="col-lg-4">
							<label class="control-label">Beca Nro:</label>
						</div>
						<div class="col-lg-6">
								<span>456</span> 
						</div>
						<div class="col-lg-4">
							<label class="control-label">Beca Nro:</label>
						</div>
						<div class="col-lg-6">
								<span>456</span> 
						</div>
						<div class="col-lg-4">
							<label class="control-label">Beca Nro:</label>
						</div>
						<div class="col-lg-6">
								<span>456</span> 
						</div>
						
					</div-->	
						<!--label class="control-label col-sm-4">Apellido y Nombre:</label>
						<span>Carlos Perez</span>
						<label class="control-label col-sm-4">Tipo de Beca</label>
						<span>Beca Comun</span-->
				


					<div class="form-group">
						<label class="control-label col-sm-6">Formulario de Solicitud</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-6">Informaci&oacute;n de Actividad</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-6">Copia Certificada T&iacute;tulo Universitario</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-6">Curriculum Vitae</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-6">Certificado Laboral</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-6">Dictamen Evaluativo</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					</div>
				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Aceptar</button>
						<a href="{!! URL::action('BecaController@index'); !!}" class="btn btn-default">Cancel</a>
					</div>
				</div>	

			</form>
		</div>
	</div>
</div>
<!--/div-->
@stop