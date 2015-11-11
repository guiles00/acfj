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
//echo "<pre>";
//print_r($beca);
?>

<?php if(Session::get('edited') == true){?>
<div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Beca Editada!</b>
            </div>
<?php } ?>            
<div class="panel-body">

	<div class="row">
	
	<form method="POST" action="{{action('BecaController@save')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="_id" value="{{$beca->beca_id}}" />

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
										<div class="col-md-8"><input class="form-control input-sm" name="f_ingreso_caba" value='<?=$beca->f_ingreso_caba?>'></div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
									<label class="control-label col-md-2">Fuero</label>
									<div class="col-md-8">
										<select class="form-control" name="fuero_id">
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
										<select class="form-control" name="dependencia_id">
											@foreach($helpers['dependencias'] as $key=>$dependencia)
											<?php if( $dependencia->dep_id == $beca->dependencia_id ){?>
											<option value="{{$dependencia->dep_id}}" selected>{{$dependencia->dep_nombre}}</option>
											<?php }else{?>
											<option value="{{$dependencia->dep_id}}">{{$dependencia->dep_nombre}}</option>
											<?php }?>
											@endforeach
										</select>
									</div>
								</div>
								</div>
								<div class="row">	
									<div class="form-group">
										<label class="control-label col-md-2">Cargo</label>
										<div class="col-md-8">
											<select class="form-control" name="car_id" id="b_car_id">
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
									<div class="row" id="otroCargo">	
									<div class="form-group">
										<label class="control-label col-md-2">Otro Cargo</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="otro_cargo" value='<?=$beca->telefono_laboral?>'>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Tel. Laboral</label>
										<div class="col-md-8"><input class="form-control input-sm" name="tel_laboral" value='<?=$beca->telefono_laboral?>'></div>
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
						<div class="col-md-4">
						<select class="form-control" name="renovacion_id">
												@foreach($helpers['renovacion'] as $key=>$renovacion)
												<?php if( $renovacion->dominio_id == $beca->renovacion_id ){?>
												<option value="{{$renovacion->dominio_id}}" selected>{{$renovacion->nombre}}</option>
												<?php }else{?>
												<option value="{{$renovacion->dominio_id}}">{{$renovacion->nombre}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo de Beca</label>
						<div class="col-md-8">
							
								<select class="form-control" name="tipo_beca_id">
												@foreach($helpers['tipo_becas'] as $key=>$tipo_beca)
												<?php if( $tipo_beca->dominio_id == $beca->tipo_beca_id ){?>
												<option value="{{$tipo_beca->dominio_id}}" selected>{{$tipo_beca->nombre}}</option>
												<?php }else{?>
												<option value="{{$tipo_beca->dominio_id}}">{{$tipo_beca->nombre}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Tipo de Actividad</label>
						<div class="col-md-8">
								<select class="form-control" name="tipo_actividad_id">
												@foreach($helpers['tipo_actividad'] as $key=>$tipo_actividad)
												<?php if( $tipo_actividad->dominio_id == $beca->tipo_actividad_id ){?>
												<option value="{{$tipo_actividad->dominio_id}}" selected>{{$tipo_actividad->nombre}}</option>
												<?php }else{?>
												<option value="{{$tipo_actividad->dominio_id}}">{{$tipo_actividad->nombre}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Instituci&oacute;n propuesta</label>
						<div class="col-md-8">
								<select class="form-control" name="inst_prop_id">
												@foreach($helpers['universidades'] as $key=>$inst_prop)
												<?php if( $inst_prop->universidad_id == $beca->institucion_propuesta ){?>
												<option value="{{$inst_prop->universidad_id}}" selected>{{$inst_prop->universidad}}</option>
												<?php }else{?>
												<option value="{{$inst_prop->universidad_id}}">{{$inst_prop->universidad}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Costo</label>
						<div class="col-md-8"><input class="form-control input-sm" name="costo" value='<?=$beca->costo?>'></div>
					</div>
				</div>
					<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Monto</label>
						<div class="col-md-8"><input class="form-control input-sm" name="monto" value='<?=$beca->monto?>'></div>
					</div>
				</div>
		</div>
		<div class="col-lg-6 col-md-6">
			<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Inicio</label>
						<div class="col-md-8"><input class="form-control input-sm" name="fecha_inicio" value='<?=$beca->fecha_inicio?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Fin</label>
						<div class="col-md-8"><input class="form-control input-sm" name="fecha_fin" value='<?=$beca->fecha_fin?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Nombre Actividad</label>
						<div class="col-md-8"><input class="form-control input-sm" name="actividad_nombre" value='<?=$beca->actividad_nombre?>'></div>
					</div>
				</div>

				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Duraci&oacute;n</label>
						<div class="col-md-8"><input class="form-control input-sm" name="duracion" value='<?=$beca->duracion?>'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Dictamen</label>
						<div class="col-md-8"><input class="form-control input-sm" name="dictamen_por" value='<?=$beca->dictamen_por?>'></div>
					</div>
				</div>
					<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Superposici&oacute;n</label>
						<div class="col-md-8">
								<select class="form-control" name="s_horaria">
												@foreach($helpers['s_horaria'] as $key=>$s_horaria)
												<?php if( $s_horaria->dominio_id == $beca->sup_horaria ){?>
												<option value="{{$s_horaria->dominio_id}}" selected>{{$s_horaria->nombre}}</option>
												<?php }else{?>
												<option value="{{$s_horaria->dominio_id}}">{{$s_horaria->nombre}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
				</div>
		</div>
		
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<h3 >Documentaci&oacute;n</h3>
						</div>
					</div>
				</div>
			</div>

<div class="col-sm-12">
        <div class="row">
        	<div class="form-group">
					
						<label class="control-label col-sm-2">Formulario de Solicitud</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>

						<label class="control-label col-sm-2">Informaci&oacute;n de Actividad</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					
						<label class="control-label col-sm-2">Copia Certificada T&iacute;tulo Universitario</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
		    </div>
       
        </div>
        <div class="row">
        	<div class="form-group">
					
						<label class="control-label col-sm-2">Curriculum Vitae</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>

						<label class="control-label col-sm-2">Certificado Laboral</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
					
						<label class="control-label col-sm-2">Dictamen Evaluativo</label>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-default">
							<input type="checkbox" autocomplete="off">
							<span class="glyphicon glyphicon-ok"></span>
							</label>
						</div>
		    </div>
       
        </div>
        <!--div class="row">
        	<div class="col-sm-12">
        		<hr>
        	</div>
        </div-->
        <div class="row">
        	<div class="form-group">
						<label class="control-label col-md-2">Estado de la Solicitud</label>
						<div class="col-md-4">
						<select class="form-control" name="estado_id">
												@foreach($helpers['estado_beca'] as $key=>$estado_beca)
												<?php if( $estado_beca->dominio_id == $beca->estado_id ){?>
												<option value="{{$estado_beca->dominio_id}}" selected>{{$estado_beca->nombre}}</option>
												<?php }else{?>
												<option value="{{$estado_beca->dominio_id}}">{{$estado_beca->nombre}}</option>
												<?php }?>
												@endforeach
								</select>
						</div>
					</div>
        </div>

</div>
	<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<hr>
						</div>
					</div>
				</div>
	</div>


			<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-offset-1 col-md-10">
							<button type="submit" class="btn btn-default" id="b_save_beca">Guardar</button>
							<a href="{!! URL::action('BecaController@index'); !!}" class="btn btn-default">Cancelar</a>
							<button type="button" class="btn btn-default">Enviar Email Documentaci&oacute;n</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>



$('document').ready(function(){

	var token =  '<?php echo Session::token() ; ?>';
	
		var car_id = $('#b_car_id').val();

		if( car_id == '-1'){
		$('#otroCargo').show();	
		}else{
		$('#otroCargo').hide();	
		} 

		$('#b_car_id').change(function(){

		var car_id = $('#b_car_id').val();

		if( car_id == '-1') $('#otroCargo').show();

		if( car_id != '-1') $('#otroCargo').hide();

		});

	/*	$('#b_save_beca').click(function(){
			$.ajax({
		                url : "./saveBeca"
		                ,method: 'POST'
		                ,data:{ '_token': token }
		                ,success : function(result) {
		                	console.debug('exito');
		                }
		              });    	

		});
	*/

});

</script>
@stop
