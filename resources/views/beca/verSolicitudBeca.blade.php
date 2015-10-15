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
$generos = ["1"=>"Masculino","2"=>"Femenino","3"=>"Otro"];
?>
<div class="panel-body">

	<div class="row">
	
	<form method="POST" action="{{action('AlumnosController@store')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="_id" value='' />

		<div class="col-lg-6 col-md-6">
			
				<div class="row">
						<div class="col-sm-12">
							<div class="form-group" style="background-color:#d1dfee">
								<h3 >Datos Personales</h3> 
							</div>
						</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">DNI</label>
						<div class="col-md-8"><input class="form-control input-sm" name="dni" value='<?=$beca->usi_dni?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Apellido y Nombre</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value='<?=$beca->usi_nombre?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Legajo</label>
						<div class="col-md-8"><input class="form-control input-sm" name="legajo" value='<?=$beca->usi_legajo?>'></div>
					</div>
				</div>	
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Domicilio</label>
						<div class="col-md-8"><input class="form-control input-sm" name="domicilio" value='<?=$beca->domicilio_constituido?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tel Particular</label>
						<div class="col-md-8"><input class="form-control input-sm" name="tel_particular" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">G&eacute;nero</label>
					<div class="col-md-8">
						<select class="form-control" name="car_id">
						@foreach($generos as $key=>$genero)
						<?php if( $key == $beca->usi_genero ){?>
						<option value="{{$key}}" selected>{{$genero}}</option>
						<?php }else{?>
						<option value="{{$key}}">{{$genero}}</option>
						<?php }?>
						@endforeach
						</select>
					</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Fecha de Nacimiento</label>
						<div class="col-md-8"><input class="form-control input-sm" name="celular" value='<?=$beca->usi_fecha_nacimiento?>'></div>
					</div>
				</div>

	</div>
					<div class="col-lg-6 col-md-6">
								<div class="row">
										<div class="col-sm-12">
											<div class="form-group" style="background-color:#d1dfee">
												<h3  >Datos Laborales</h3> 
											</div>
										</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Fecha Ingreso PJCABA</label>
										<div class="col-md-8"><input class="form-control input-sm" name="dni" value='<?=$beca->f_ingreso_caba?>'></div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
									<label class="control-label col-md-2">Fuero</label>
									<div class="col-md-8">
										<select class="form-control" name="car_id">
											@foreach($helpers['fuero'] as $key=>$fuero)
											<?php if( $fuero->fuero_id == $beca->fuero_id ){?>
											<option value="{{$fuero->fuero_id}}" selected>{{$fuero->fuero_nombre}}</option>
											<?php }else{?>
											<option value="{{$fuero->fuero_id}}">{{$fuero->fuero_nombre}}</option>
											<?php }?>
											@endforeach
										</select>
									</div>
								</div>
								</div>
								<div class="row">	
								<div class="form-group">
									<label class="control-label col-md-2">Dependencia</label>
									<div class="col-md-8">
										<select class="form-control" name="car_id">
											@foreach($helpers['cargos'] as $key=>$cargo)
											<?php if( $cargo->car_id == $beca->cargo_id ){?>
											<option value="{{$cargo->car_id}}" selected>{{$cargo->car_nombre}}</option>
											<?php }else{?>
											<option value="{{$cargo->car_id}}">{{$cargo->car_nombre}}</option>
											<?php }?>
											@endforeach
										</select>
									</div>
								</div>
								<div class="row">	
										<div class="form-group">
										<label class="control-label col-md-2">Cargo</label>
										<div class="col-md-8">
											<select class="form-control" name="car_id">
												@foreach($helpers['cargos'] as $key=>$cargo)
												<?php if( $cargo->car_id == $beca->cargo_id ){?>
												<option value="{{$cargo->car_id}}" selected>{{$cargo->car_nombre}}</option>
												<?php }else{?>
												<option value="{{$cargo->car_id}}">{{$cargo->car_nombre}}</option>
												<?php }?>
												@endforeach
											</select>
										</div>
									</div>
								</div>	
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Tel. Laboral</label>
										<div class="col-md-8"><input class="form-control input-sm" name="tel_particular" value=''></div>
									</div>
								</div>
								<div class="row">
										<div class="form-group">
											<label class="control-label col-md-2">Universidad</label>
											<div class="col-md-8">
												<select class="form-control" name="universidad_id">
													@foreach($helpers['universidades'] as $key=>$universidad)
													<?php if( $universidad->universidad_id == $beca->universidad_id ){?>
													<option value="{{$universidad->universidad_id}}" selected>{{$universidad->universidad}}</option>
													<?php }else{?>
													<option value="{{$universidad->universidad_id}}">{{$universidad->universidad}}</option>
													<?php }?>
													@endforeach
												</select>
											</div>
										</div>
								</div>
								<div class="row">
										<div class="form-group">
											<label class="control-label col-md-2">Facultad:</label>
											<div class="col-md-8">
												<select class="form-control" name="facultad_id">
													@foreach($helpers['facultades'] as $key=>$facultad)
													<?php if( $facultad->facultad_id == $beca->facultad_id ){?>
													<option value="{{$facultad->facultad_id}}" selected>{{$facultad->facultad}}</option>
													<?php }else{?>
													<option value="{{$facultad->facultad_id}}">{{$facultad->facultad}}</option>
													<?php }?>
													@endforeach
												</select>
											</div>
										</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Titulo:</label>
										<div class="col-md-8">
											<select class="form-control" name="titulo_id">
												@foreach($helpers['titulos'] as $key=>$titulo)
												<?php if( $titulo->titulo_id == $beca->titulo_id ){?>
												<option value="{{$titulo->titulo_id}}" selected>{{$titulo->titulo}}</option>
												<?php }else{?>
												<option value="{{$titulo->titulo_id}}">{{$titulo->titulo}}</option>
												<?php }?>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									
								</div>
								<div class="row">
									
								</div>
					</div>
			</div>
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<h3 >Datos Beca</h3> 
						</div>
					</div>
				</div>
			</div>
		<div class="col-lg-6 col-md-6">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Renovaci&oacute;n</label>
						<div class="col-md-4"><input class="form-control input-sm" name="dni" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo de Beca</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo de Actividad</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Instituci&oacute;n propuesta</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Costo</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
					<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Monto</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
		</div>
		<div class="col-lg-6 col-md-6">
			<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Inicio</label>
						<div class="col-md-8"><input class="form-control input-sm" name="dni" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Fin</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Nombre</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>

				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Duraci&oacute;n</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Dictamen</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
					<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Superposici&oacute;n</label>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value=''></div>
					</div>
				</div>
		</div>

			<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-offset-1 col-md-10">
							<button type="submit" class="btn btn-default">Guardar</button>
							<button type="button" class="btn btn-default">Solicitud Completa</button>
							<a href="{!! URL::action('BecaController@index'); !!}" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@stop