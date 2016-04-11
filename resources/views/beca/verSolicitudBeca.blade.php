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
 <ul class="breadcrumb">
    <li>Solicitud Becas</li>
    <li class="active">Ver Solicitud {{$beca->beca_id}}</li>
</ul>  
<div class="panel panel-default">
	<div class="panel-heading">
			<a class="btn btn-default glyphicon glyphicon-arrow-left" href="{!! URL::action('BecaController@index'); !!}" class="glyphicon glyphicon-arrow-left"></a>
			<!--a href="{{action('AlumnosController@create')}}" class="glyphicon glyphicon-plus" align="right"></a-->
			<!--span class="glyphicon glyphicon-plus" aria-hidden="true"></span-->		
	</div>
<?php  
use App\domain\PasoBeca;
use App\domain\Utils;

$generos = ["1"=>"Masculino","2"=>"Femenino","3"=>"Otro"];
//echo "<pre>";
//print_r($documentacion);
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
					<input type="hidden" name="_id" value="{{$beca->beca_id}}" id="b_beca_id"/>

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

						<div class="col-md-8"><input class="form-control input-sm" name="dni" value='<?=$beca->usi_dni?>' disabled></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Apellido y Nombre</label>
						<? $nombre_email = $beca->usi_nombre.' ( '.$beca->usi_email.' )'; ?>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value='<?=$nombre_email?>' disabled></div>
					</div>
				</div>
				
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Legajo</label>
						<div class="col-md-8"><input class="form-control input-sm" name="legajo" value='<?=$beca->usi_legajo?>'disabled></div>
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
						<div class="col-md-8"><input class="form-control input-sm" name="tel_particular" value='<?=$beca->telefono_particular?>'></div>
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
						<label class="control-label col-md-2">G&eacute;nero</label>
					<div class="col-md-8">
						<select class="form-control" name="car_id" disabled>
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
								<!--div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Email</label>
										<div class="col-md-8"><input class="form-control input-sm" name="email" value='<?=$beca->f_ingreso_caba?>'></div>
									</div>
								</div-->
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Fecha Ingreso PJCABA</label>
										<div class="col-md-8"><input class="form-control input-sm datepicker" name="f_ingreso_caba" value='<?=$beca->f_ingreso_caba?>'></div>
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
										<select class="form-control" name="dependencia_id" id="b_dep_id">
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
								<div class="row" id="b_dependencia_otro">
										<div class="form-group">
										<label class="control-label col-md-2">Otra Dependencia</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="dependencia_otro" value='<?=$beca->dependencia_otro?>'>
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
								<!--div class="row" id="b_cargo_otro">	
									<div class="form-group">
										<label class="control-label col-md-2">Otro Cargo</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="otro_cargo" value='<?=$beca->telefono_laboral?>'>
										</div>
									</div>
								</div-->
								
								<div class="row">
										<div class="form-group">
											<label class="control-label col-md-2">Universidad</label>
											<div class="col-md-8">
												<select class="form-control" name="universidad_id" id="b_universidad_id">
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
								<div class="row" id="b_universidad_otro">	
									<div class="form-group">
										<label class="control-label col-md-2">Otro Universidad</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="universidad_otro" value='<?=$beca->universidad_otro?>'>
										</div>
									</div>
								</div>

								<div class="row">
										<div class="form-group">
											<label class="control-label col-md-2">Facultad:</label>
											<div class="col-md-8">
												<select class="form-control" name="facultad_id" id="b_facultad_id">
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

								<div class="row" id="b_facultad_otro">
										<div class="form-group">
										<label class="control-label col-md-2">Otra Fac.</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="facultad_otro" value='<?=$beca->facultad_otro?>'>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Titulo:</label>
										<div class="col-md-8">
											<select class="form-control" name="titulo_id" id="b_titulo_id">
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
								<div class="row" id="b_titulo_otro">
										<div class="form-group">
										<label class="control-label col-md-2">Otro Tit.</label>
										<div class="col-md-8">
											<input class="form-control input-sm" name="titulo_otro" value='<?=$beca->titulo_otro?>'>
										</div>
									</div>
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
										<label class="control-label col-md-2">Fecha de Solicitud</label>
										<div class="col-md-8"><input class="form-control input-sm" name="fecha" value='<?=$beca->timestamp?>' disabled></div>
									</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Renovaci&oacute;n</label>
						<div class="col-md-4">
						<select class="form-control" name="renovacion_id" id="b_renovacion_id">
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
						<label class="control-label col-md-2">Monto Solicitado</label>
						<div class="col-md-8"><input class="form-control input-sm" name="monto" value='<?=$beca->monto?>'></div>
					</div>
				</div>
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
		<div class="col-lg-6 col-md-6">
			<div class="row">
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Inicio</label>
						<div class="col-md-8"><input class="form-control input-sm datepicker" name="fecha_inicio" value='<?=$beca->fecha_inicio?>' id="b_fecha_inicio"></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Fecha Fin</label>
						<div class="col-md-8"><input class="form-control input-sm datepicker" name="fecha_fin" value='<?=$beca->fecha_fin?>' id="b_fecha_fin"></div>
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
								<select class="form-control" name="s_horaria" id="b_sup_horaria">
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
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Monto Otorgado</label>
						<div class="col-md-8"><input class="form-control input-sm" name="monto_otorgado" value=''></div>
					</div>
				</div>

		</div>
		
			<!--div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<h3 >Documentaci&oacute;n</h3>
						</div>
					</div>
				</div>
			</div-->


	<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<hr>
						</div>
					</div>
				</div>
	</div>



	<!--div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" style="background-color:#d1dfee">
							<hr>
						</div>
					</div>
				</div>
	</div-->


			<!--div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-offset-1 col-md-10">
							<button type="submit" class="btn btn-default" id="b_save_beca">Guardar</button>
							<a href="{!! URL::action('BecaController@index'); !!}" class="btn btn-default">Cancelar</a>
							<button type="button" class="btn btn-default">Enviar Email Documentaci&oacute;n</button>
						</div>
					</div>
				</div>
			</div-->

		
	</div> <!-- row --> 

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#menu1">Documentaci&oacute;n</a></li>
  <li><a data-toggle="tab" href="#menu2">Actuaciones</a></li>
   <li><a data-toggle="tab" href="#b_paso_beca">Acciones</a></li>
</ul>

<div class="tab-content">
  <div id="menu1" class="tab-pane fade in active">
		<br>
		    <div class="col-sm-12">
		        <div class="row">
		        	<div class="form-group">
							
								<label class="control-label col-sm-2">Formulario de Solicitud</label>
								<div class="btn-group col-sm-2" data-toggle="buttons">
									<?php if($documentacion->formulario_solicitud == 1){ ?> 
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_formulario_solicitud" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_formulario_solicitud">
									<?php } ?>
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>
									<label class="control-label col-sm-2">Certificado Laboral</label>
								<div class="btn-group col-sm-2" data-toggle="buttons">
									<?php if($documentacion->certificado_laboral == 1){ ?>
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_certificado_laboral" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_certificado_laboral">
									<?php } ?> 
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>

								<label class="control-label col-sm-1">Dictamen Evaluativo</label>
								<div class="btn-group col-sm-1" data-toggle="buttons">
									<?php if($documentacion->dictamen_evaluativo == 1){ ?>
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_dictamen_evaluativo" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_dictamen_evaluativo">
									<?php } ?> 
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>
							
								<label class="control-label col-sm-1" id="b_autorizacion_label">Autorizaci&oacute;n Superposici&oacute;n Horaria</label>
								<div class="btn-group col-sm-1" data-toggle="buttons" id="b_autorizacion_div">
									<?php if($documentacion->autorizacion_superposicion == 1){ ?>
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_autorizacion_superposicion" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_autorizacion_superposicion">
									<?php } ?> 
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>
				    </div>
		       
		        </div>
		        <div class="row">
		        	<div class="form-group">
							
								<label class="control-label col-sm-2" id="b_curriculum_vitae_label">Curriculum Vitae</label>
								<div class="btn-group col-sm-2" data-toggle="buttons" id="b_curriculum_vitae_div">
									<?php if($documentacion->curriculum_vitae == 1){ ?>
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_curriculum_vitae" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_curriculum_vitae">
									<?php } ?> 
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>

								<label class="control-label col-sm-2" id="b_informacion_actividad_label">Informaci&oacute;n de Actividad</label>
								<div class="btn-group col-sm-2" data-toggle="buttons" id="b_informacion_actividad_div">
									<?php if($documentacion->informacion_actividad == 1){ ?>
									<label class="btn btn-default active">
									<input type="checkbox" name="doc_informacion_actividad" checked>
									
									<?php }else{ ?> 
									<label class="btn btn-default">
									<input type="checkbox" name="doc_informacion_actividad">
									<?php } ?>
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>

								<label class="control-label col-sm-1" id="b_copia_titulo_label">Copia Certificada T&iacute;tulo Universitario</label>
								<div class="btn-group col-sm-1" data-toggle="buttons" id="b_copia_titulo_div">
									<?php if($documentacion->copia_titulo == 1){ ?>
										<label class="btn btn-default active">
										<input type="checkbox" name="doc_copia_titulo" checked>
									<?php }else{ ?> 
										<label class="btn btn-default">
										<input type="checkbox" name="doc_copia_titulo">
									<?php } ?>
									<span class="glyphicon glyphicon-ok"></span>
									</label>
								</div>
				    </div>
		       
		        </div>
	</div>
  </div>
	  <div id="menu2" class="tab-pane fade">
	    	 <table class="table table-condensed table-bordered table-striped volumes">
	        <thead>
	          <tr>
	          	<th>Prefijo</th>
	            <th>Nro Actuacion</th>
	            <th>FECHA</th>
                <th>ASUNTO</th>
                <th>DIRIGIDO</th>  
                <th>REMITE</th>
                <th>RECIBIO</th>
	            <th width="10%"></th>
	          </tr>
	        </thead>
	        <tbody>

       	 @foreach ($actuaciones as $actuacion)
            <tr>
                <td> {{ $actuacion->prefijo }} </td>
                <td> {{ $actuacion->numero_actuacion  }} </td>                
                <td> {{ $actuacion->actuacion_fecha}} </td>
                <td> {{ $actuacion->asunto}} </td>
                <td> {{ $actuacion->dirigido}} </td>
                <td> {{ $actuacion->remite}} </td>
                <td> {{ $actuacion->conste}} </td>
                <!--td> {{ $actuacion->actuacion_id}} </td-->
                <td> <a href="{!! URL::action('BecaController@eliminarVinculoActuacion',$actuacion->beca_actuacion_id); !!}" onClick="return confirm('desea eliminar?')" >Eliminar</a></td>

            </tr>
            @endforeach    

	        </tbody>
	      </table>

	    	<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-10">
							<a href="{!! URL::action('BecaController@addActuacion',$beca->beca_id); !!}" class="btn btn-default">Agregar Actuaci&oacute;n</a>
						</div>
					</div>
				</div>
			</div>

	</div>

	<div id="b_paso_beca" class="tab-pane fade">
	    	 <table class="table table-condensed table-bordered table-striped volumes">
	        <thead>
	          <tr>
	            <th>Nro.</th>
	            <th>Asunto</th>
	            <th>Observaciones</th>
	            <th>Fecha</th>
                <th width="10%"></th>
                <th width="10%"></th>
	          </tr>
	        </thead>
	        <tbody>

       	 <!-- FOREACH -->
       	  @foreach ($pasos_beca as $paso_beca)
            <tr>
                <td> {{ $paso_beca->paso_beca_id }} </td>
                <td> {{ PasoBeca::getTipoPasoById($paso_beca->tipo_paso_beca_id) }} </td>                
                <td> {{ $paso_beca->observaciones }} </td>
                <td> {{ Utils::formatDate($paso_beca->timestamp) }}</td>
                <td> <a href="{!! URL::action('BecaController@editPasoBeca',$paso_beca->paso_beca_id); !!}">Ver</a></td>
                <td> <a href="{!! URL::action('BecaController@deletePasoBeca',$paso_beca->paso_beca_id); !!}" onClick="return confirm('desea eliminar?')" >Eliminar</a></td>

            </tr>
            <!-- ENDFOREACH -->
         @endforeach    

	        </tbody>
	      </table>

	    	<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-10">
							<a href="{!! URL::action('BecaController@addPasoBeca',$beca->beca_id); !!}" class="btn btn-default">Agregar Acci&oacute;n</a>
						</div>
					</div>
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
						<div class="col-md-12">
							<button type="submit" class="btn btn-default" id="b_save_beca">Guardar</button>
							<a href="{!! URL::action('BecaController@index'); !!}" class="btn btn-default">Cancelar</a>
							<button type="button" class="btn btn-default" id="b_preview_email_documentacion">Previsualizar contenido Email</button>
							<button type="button" class="btn btn-default" id="b_enviar_email_documentacion">Enviar Email Documentaci&oacute;n</button>
							<a type="button" href="{{action('BecaController@imprimirSolicitud',$beca->beca_id)}}" class="btn btn-default" target="_target" id="b_imprimir_solicitud">Imprimir Solicitud</a>

						</div>
					</div>
				</div>
			</div>

</form>
<div id="res">
</div>

</div> <!-- panel body -->
<script>



$('document').ready(function(){

	var token =  '<?php echo Session::token() ; ?>';
	
		var car_id = $('#b_car_id').val();
		var dep_id = $('#b_dep_id').val();
		var universidad_id = $('#b_universidad_id').val();
		var facultad_id = $('#b_facultad_id').val();
		var titulo_id = $('#b_titulo_id').val();
		/*
		if( car_id == '-1'){
		$('#b_cargo_otro').show();	
		}else{
		$('#b_cargo_otro').hide();	
		} 

		$('#b_car_id').change(function(){

		var car_id = $('#b_car_id').val();

		if( car_id == '-1') $('#b_cargo_otro').show();

		if( car_id != '-1') $('#b_cargo_otro').hide();

		}); */

		if( dep_id == '-1'){
		$('#b_dependencia_otro').show();	
		}else{
		$('#b_dependencia_otro').hide();	
		} 

		$('#b_dep_id').change(function(){

		var dep_id = $('#b_dep_id').val();

		if( dep_id == '-1') $('#b_dependencia_otro').show();

		if( dep_id != '-1') $('#b_dependencia_otro').hide();

		});

		if( universidad_id == '-1'){
		$('#b_universidad_otro').show();	
		}else{
		$('#b_universidad_otro').hide();	
		} 

		$('#b_universidad_id').change(function(){

		var universidad_id = $('#b_universidad_id').val();

		if( universidad_id == '-1') $('#b_universidad_otro').show();

		if( universidad_id != '-1') $('#b_universidad_otro').hide();

		});


		if( facultad_id == '-1'){
		$('#b_facultad_otro').show();	
		}else{
		$('#b_facultad_otro').hide();	
		} 

		$('#b_facultad_id').change(function(){

		var facultad_id = $('#b_facultad_id').val();

		if( facultad_id == '-1') $('#b_facultad_otro').show();

		if( facultad_id != '-1') $('#b_facultad_otro').hide();

		});

		if( titulo_id == '-1'){
		$('#b_titulo_otro').show();	
		}else{
		$('#b_titulo_otro').hide();	
		} 

		$('#b_titulo_id').change(function(){

		var titulo_id = $('#b_titulo_id').val();

		if( titulo_id == '-1') $('#b_titulo_otro').show();

		if( titulo_id != '-1') $('#b_titulo_otro').hide();

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

	$('#b_enviar_email_documentacion').click(function(){
		
		
		var beca_id = $('#b_beca_id').val();

			$.ajax({
		                url : "../enviarEmailDocumentacion"
		                ,data: {'beca_id':beca_id}
		                ,success : function(result) {
		                	$('#res').html(result);
		                	//console.debug(result);
		                }
		              });   

	});


	$('#b_preview_email_documentacion').click(function(){
		
		
		var beca_id = $('#b_beca_id').val();

			$.ajax({
		                url : "../previewEmailDocumentacion"
		                ,data: {'beca_id':beca_id}
		                ,success : function(result) {
		                	$('#res').html(result);
		                	//console.debug(result);
		                }
		              });   

	});

	//Muestro o no la superposicion horaria

	var sup_horaria = $('#b_sup_horaria').val();
	
	if(sup_horaria == 1){
		//alert('muestro')
		$('#b_autorizacion_label').show();
		$('#b_autorizacion_div').show();
	}else{
		//alert('oculto')
		$('#b_autorizacion_label').hide();
		$('#b_autorizacion_div').hide();
	}

	 $('#b_sup_horaria').on('change', function(d) {

	 		var sup_horaria = $('#b_sup_horaria').val();
	
			if(sup_horaria == 1){
				//alert('muestro')
				$('#b_autorizacion_label').show();
				$('#b_autorizacion_div').show();
			}else{
				//alert('oculto')
				$('#b_autorizacion_label').hide();
				$('#b_autorizacion_div').hide();
			}
	 });


	//Muestro o no si es renovacion

	var renovacion = $('#b_renovacion_id').val();
	
	if(renovacion == 1){
		
		$('#b_curriculum_vitae_label').show();
		$('#b_curriculum_vitae_div').show();

		$('#b_informacion_actividad_label').show();
		$('#b_informacion_actividad_div').show();
		
		$('#b_copia_titulo_label').show();
		$('#b_copia_titulo_div').show();
	}else{
		
		$('#b_curriculum_vitae_label').hide();
		$('#b_curriculum_vitae_div').hide();

		$('#b_informacion_actividad_label').hide();
		$('#b_informacion_actividad_div').hide();
		
		$('#b_copia_titulo_label').hide();
		$('#b_copia_titulo_div').hide();
	}

	 $('#b_renovacion_id').on('change', function(d) {

	 		var renovacion = $('#b_renovacion_id').val();
	
			if(renovacion == 1){
				
				$('#b_curriculum_vitae_label').show();
				$('#b_curriculum_vitae_div').show();

				$('#b_informacion_actividad_label').show();
				$('#b_informacion_actividad_div').show();
				
				$('#b_copia_titulo_label').show();
				$('#b_copia_titulo_div').show();

			}else{
				
				$('#b_curriculum_vitae_label').hide();
				$('#b_curriculum_vitae_div').hide();

				$('#b_informacion_actividad_label').hide();
				$('#b_informacion_actividad_div').hide();
				
				$('#b_copia_titulo_label').hide();
				$('#b_copia_titulo_div').hide();
			}
	 });



//$('#b_fecha_inicio').datepicker({dateFormat:"yy-mm-dd"});
//$('#b_fecha_fin').datepicker({dateFormat:"yy-mm-dd"});

$('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                  }
                );
	
});

</script>
@stop
