@extends('app')

@section('content')

<!--div class="container"-->
<div class="panel panel-default">
	<div class="panel-heading">
		<button type="button" class="btn btn-default" aria-label="Left Align">
			<a href="{!! URL::action('AlumnosController@index'); !!}" class="glyphicon glyphicon-arrow-left"></a>
			<!--a href="{!! URL::previous(); !!}" class="glyphicon glyphicon-arrow-left"></a-->

			<!--a href="{{action('AlumnosController@create')}}" class="glyphicon glyphicon-plus" align="right"></a-->

			<!--span class="glyphicon glyphicon-plus" aria-hidden="true"></span-->
		</button>
		Alumnos
	</div>
	<?php $alumno = $data['alumno']; 
	      $cargos = $data['cargos'] 
	?>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<form method="POST" action="{{action('AlumnosController@store')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="_id" value=<?=$alumno['usi_id']?> />
				
					<div class="form-group">
						<label class="control-label col-sm-2">DNI</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="dni" value='<?=$alumno['usi_dni']?>'></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Apellido</label>
						<div class="col-sm-10"><input class="form-control input-sm"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Nombre</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="nombre" value='<?=$alumno['usi_nombre']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Legajo</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="legajo" value='<?=$alumno['usi_legajo']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Email</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="email" value='<?=$alumno['usi_email']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Contrase&ntilde;a</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="contrasena" value=''></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Telefono</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="telefono" value='<?=$alumno['usi_telefono']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Celular</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="celular" value='<?=$alumno['usi_celular']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">C&oacute;digo Postal</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="cp" value='<?=$alumno['usi_cp']?>'></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Direcci&oacute;n</label>
						<div class="col-sm-10"><input class="form-control input-sm" name="direccion" value='<?=$alumno['usi_direccion']?>'></div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Area</label>
						<div class="col-sm-4">
						<select class="form-control input-sm" name="are_id">
							<option>JUEZ</option>
							<option>FISCAL</option>
							<option>DEFENSOR</option>
						</select>
					</div>
				</div>
				<div class="form-group">
						<label class="control-label col-sm-2">Cargo</label>
						<div class="col-sm-6">
						<select class="form-control" name="car_id">
						@foreach($cargos as $key=>$cargo)
						<?php if( $key == $alumno['usi_car_id'] ){?>
						<option value="{{$key}}" selected>{{$cargo}}</option>
						<?php }else{?>
						<option value="{{$key}}">{{$cargo}}</option>
						<?php }?>
						@endforeach
							</select>
					</div>
				</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Dependencia</label>
						<div class="col-sm-6" >
						<select class="form-control" name="dep_id">
						@foreach($cargos as $key=>$cargo)
						<?php if( $key == $alumno['usi_car_id'] ){?>
						<option value="{{$key}}" selected>{{$cargo}}</option>
						<?php }else{?>
						<option value="{{$key}}">{{$cargo}}</option>
						<?php }?>
						@endforeach
							</select>
					</div>
				</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Registrado</label>
					 <div class="col-sm-3">
						<select class="form-control input-sm" name="registrado">
						   <option>SI</option>
                           <option>NO</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
						<label class="control-label col-sm-2">Obligar Clave</label>
						<div class="col-sm-3">
						<select class="form-control input-sm" name="obligar_clave">
						   <option>SI</option>
                           <option>NO</option>
						</select>
					</div>
					</div>
				<div class="form-group">
						<label class="control-label col-sm-2">Validado</label>
						<div class="col-sm-3">
						<select class="form-control input-sm" name="validado">
						   <option>SI</option>
                           <option>NO</option>
						</select>
					</div>
				</div>

				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">Aceptar</button>
						<a href="{!! URL::action('AlumnosController@index'); !!}" class="btn btn-default">Cancel</a>
					</div>

						<!--div class="col-sm-offset-4 col-sm-10">
							
					</div-->
				</div>	
			</form>
		</div>
	</div>
</div>
<!--/div-->
@stop