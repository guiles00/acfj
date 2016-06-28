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
    <li>Becas</li>
    <li class="active">Ver Beca {{ $beca->beca_id}}</li>
</ul> 
<div class="panel panel-default">
	<div class="panel-heading">
			<a class="btn btn-default glyphicon glyphicon-arrow-left" href="{!! URL::action('BecaOtorgadaController@listadoBecas'); !!}" class="glyphicon glyphicon-arrow-left"></a>
	</div>
<?php  
use App\domain\PasoBeca;
use App\domain\Utils;

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
	
	<form method="POST" action="{{action('BecaOtorgadaController@save')}}" accept-charset="UTF-8" class="form-horizontal" role="form">
					<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
					<input type="hidden" name="_id" value="{{$beca->beca_id}}" id="b_beca_id"/>

		<div class="col-lg-6 col-md-6" style="display: none">
			
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
						<label class="control-label col-md-2">Fecha de Nacimiento</label>
						<div class="col-md-8"><input class="form-control input-sm" name="celular" value='<?=$beca->usi_fecha_nacimiento?>'></div>
					</div>
				</div>

	</div>
					
					<div class="col-lg-6 col-md-6" style="display: none">
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
						<label class="control-label col-md-2">A&ntilde;o</label>
						<div class="col-md-4"><input class="form-control input-sm" name="apynom" value='2016'></div>
					</div>
				</div>

				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Apellido y Nombre</label>
						<? $nombre_email = $beca->usi_nombre.' ( '.$beca->usi_email.' )'; ?>
						<div class="col-md-8"><input class="form-control input-sm" name="apynom" value='<?=$nombre_email?>'></div>
					</div>
				</div>
				

				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Carrera</label>
						<div class="col-md-8"><input class="form-control input-sm" name="actividad_nombre" value='<?=$beca->actividad_nombre?>'></div>
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
						<label class="control-label col-md-2">Monto Otorgado</label>
						<div class="col-md-8"><input class="form-control input-sm" name="monto_otorgado" value='<?=$beca->otorgado?>'></div>
					</div>
				</div>

				
				<div class="row">
		        	<div class="form-group">
								<label class="control-label col-md-2">Estado de la Beca</label>
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

		    <div class="form-group">
		      <label class="control-label col-sm-2">Observaciones</label>
		      <div class="col-sm-10">          
		        <textarea type="text" class="form-control" id="" name="beca_observaciones" ></textarea>
		      </div>
		    </div>

		</div>
		<div class="col-lg-6 col-md-6">
			
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Legajo BECA</label>
						<div class="col-md-8"><input class="form-control input-sm"  name='legajo_beca' value='{{$beca->legajo_beca}}'></div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Legajo Personal</label>
						<div class="col-md-8"><input class="form-control input-sm"  value='<?=$beca->usi_legajo?>' ></div>
					</div>
				</div>

				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Universidad</label>
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

				<!--div class="row">	
					<div class="form-group" style="visibility: hidden">
						<label class="control-label col-md-2">Duraci&oacute;n</label>
						<div class="col-md-8"><input class="form-control input-sm" name="duracion" value='<?=$beca->duracion?>'></div>
					</div>
				</div-->
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Certificado</label>
						<div class="col-md-8">
								<select class="form-control" name="certificado">

												@foreach($helpers['certificado'] as $key=>$certificado)
												<?php if( $certificado->dominio_id == $beca->certificado ){?>
												<option value="{{$certificado->dominio_id}}" selected>{{$certificado->nombre}}</option>
												<?php }else{?>
												<option value="{{$certificado->dominio_id}}">{{$certificado->nombre}}</option>
												<?php }?>
											@endforeach
								</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">DDJJ</label>
						<div class="col-md-8">
							<select class="form-control" name="presenta_ddjj">
											@foreach($helpers['corresponde_si_no'] as $key=>$corresponde_si_no)
												<?php if( $corresponde_si_no->dominio_id == $beca->presenta_ddjj ){?>
												<option value="{{$corresponde_si_no->dominio_id}}" selected>{{$corresponde_si_no->nombre}}</option>
												<?php }else{?>
												<option value="{{$corresponde_si_no->dominio_id}}">{{$corresponde_si_no->nombre}}</option>
												<?php }?>
											@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Informe final</label>
						<div class="col-md-8">
							<select class="form-control" name="informe_final">
											@foreach($helpers['corresponde_si_no'] as $key=>$corresponde_si_no)
												<?php if( $corresponde_si_no->dominio_id == $beca->informe_final ){?>
												<option value="{{$corresponde_si_no->dominio_id}}" selected>{{$corresponde_si_no->nombre}}</option>
												<?php }else{?>
												<option value="{{$corresponde_si_no->dominio_id}}">{{$corresponde_si_no->nombre}}</option>
												<?php }?>
											@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row">	
					<div class="form-group">
						<label class="control-label col-md-2">Copia T&iacute;tulo</label>
						<div class="col-md-8">
							<select class="form-control" name="copia_titulo">
											@foreach($helpers['corresponde_si_no'] as $key=>$corresponde_si_no)
												<?php if( $corresponde_si_no->dominio_id == $beca->copia_titulo ){?>
												<option value="{{$corresponde_si_no->dominio_id}}" selected>{{$corresponde_si_no->nombre}}</option>
												<?php }else{?>
												<option value="{{$corresponde_si_no->dominio_id}}">{{$corresponde_si_no->nombre}}</option>
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




		
	</div> <!-- row --> 

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#menu2">Actuaciones</a></li>
   <li><a data-toggle="tab" href="#b_paso_beca">Acciones</a></li>
   <li><a data-toggle="tab" href="#b_paso_vencimiento">Pr&oacute;rroga/Intimaciones</a></li>

</ul>

<div class="tab-content">
	  <div id="menu2" class="tab-pane fade active in">
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
                <td> <a href="{!! URL::action('BecaController@eliminarVinculoActuacion',$actuacion->actuacion_id); !!}" onClick="return confirm('desea eliminar?')" >Eliminar</a></td>

            </tr>
            @endforeach    

	        </tbody>
	      </table>

	    	<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-10">
							<a href="{!! URL::action('BecaOtorgadaController@addActuacion',$beca->beca_id); !!}" class="btn btn-default">Agregar Actuaci&oacute;n</a>
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
                <td> <a href="{!! URL::action('BecaOtorgadaController@editPasoBeca',$paso_beca->paso_beca_id); !!}">Ver</a></td>
                <td> <a href="{!! URL::action('BecaOtorgadaController@deletePasoBeca',$paso_beca->paso_beca_id); !!}" onClick="return confirm('desea eliminar?')" >Eliminar</a></td>

            </tr>
            <!-- ENDFOREACH -->
         @endforeach    

	        </tbody>
	      </table>

	    	<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-10">
							<a href="{!! URL::action('BecaOtorgadaController@addPasoBeca',$beca->beca_id); !!}" class="btn btn-default">Agregar Acci&oacute;n</a>
						</div>
					</div>
				</div>
			</div>

	</div>

	<div id="b_paso_vencimiento" class="tab-pane fade">
	    	 <table class="table table-condensed table-bordered table-striped volumes">
	        <thead>
	          <tr>
	            <th>Nro.</th>
	            <th>Asunto</th>
	            <th>Observaciones</th>
	            <th>Fecha Ingreso</th>
	            <th>Fecha Vencimiento</th>
                <th width="10%"></th>
                <th width="10%"></th>
	          </tr>
	        </thead>
	        <tbody>

       	 <!-- FOREACH -->
       	  @foreach ($pasos_vencimiento_beca as $paso_beca)
            <tr>
                <td> {{ $paso_beca->paso_beca_id }} </td>
                <td> {{ PasoBeca::getTipoPasoById($paso_beca->tipo_paso_beca_id) }} </td>                
                <td> {{ $paso_beca->observaciones }} </td>
                <td> {{ Utils::formatDate($paso_beca->fecha) }}</td>
                <td> {{ Utils::formatDate($paso_beca->fecha_vencimiento) }}</td>
                <td> <a href="{!! URL::action('BecaOtorgadaController@editPasoBecaVencimiento',$paso_beca->paso_beca_id); !!}">Ver</a></td>
                <td> <a href="{!! URL::action('BecaOtorgadaController@deletePasoBeca',$paso_beca->paso_beca_id); !!}" onClick="return confirm('desea eliminar?')" >Eliminar</a></td>

            </tr>
            <!-- ENDFOREACH -->
         @endforeach    

	        </tbody>
	      </table>

	    	<div class="col-sm-12">
				<div class="row">
					<div class="form-group"> 
						<div class="col-md-10">
							<a href="{!! URL::action('BecaOtorgadaController@addPasoVencimientoBeca',$beca->beca_id); !!}" class="btn btn-default">Agregar</a>
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
							<a href="{!! URL::action('BecaOtorgadaController@listadoBecas'); !!}" class="btn btn-default">Cancelar</a>
							<!--button type="button" class="btn btn-default" id="b_preview_email_documentacion">Previsualizar contenido Email</button>
							<button type="button" class="btn btn-default" id="b_enviar_email_documentacion">Enviar Email Documentaci&oacute;n</button-->
							<!--a type="button" href="{{action('BecaController@imprimirSolicitud',$beca->beca_id)}}" class="btn btn-default" target="_target" id="b_imprimir_solicitud">Imprimir Solicitud</a-->
							<a type="button" href="{{action('BecaController@verSolicitud',$beca->beca_id)}}" class="btn btn-default">Ver Datos Solicitud</a>
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
		

	$(function() { 
	    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
	    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	        // save the latest tab; use cookies if you like 'em better:
	        localStorage.setItem('lastTab', $(this).attr('href'));
	    });

	    // go to the latest tab, if it exists:
	    var lastTab = localStorage.getItem('lastTab');
	    if (lastTab) {
	        $('[href="' + lastTab + '"]').tab('show');
	    }
	});






});





</script>
@stop
