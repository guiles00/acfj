@extends('app')

@section('content')

<style>
.btn span.glyphicon {    			
	opacity: 0;				
}
.btn.active span.glyphicon {				
	opacity: 1;				
}
</style>
 <ul class="breadcrumb">
    <li>Cursos</li>
    <li class="active">Editar Capacitador</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<a href="{{action('DocenteController@listDocentes')}}" class="btn btn-default glyphicon glyphicon-arrow-left"></a>
	</div>


  <div class="panel-body">
	 
       <?php if(isset($edited)){?>
        <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Registro Editado!</b>
        </div>
      <?php } ?> 



 	<form class="form-horizontal" role="form" method="POST" action="{{action('DocenteController@update')}}" id="r_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$docente->doc_id}}" />
    

    <h3>Datos Personales</h3>
    <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2">Apellido</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="docente_apellido" value="{{ strtoupper($docente->doc_apellido)}}">
    </div>
    </div>            
    <div class="form-group">
      <label class="control-label  col-sm-2">Nombre</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="docente_nombre" value="{{ $docente->doc_nombre }}">
      </div>
    </div>
  
    <div class="form-group">
      <label class="control-label  col-sm-2">DNI</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="docente_dni" value="{{$docente->doc_dni}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">CUIT</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="docente_cuit" value="{{$docente->doc_cuit}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Correo Electr&oacute;nico</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="docente_email" value="{{$docente->doc_email}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">Tel&eacute;fono</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="docente_telefono" value="{{$docente->doc_telefono}}">
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Celular</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="docente_celular" value="{{$docente->doc_celular}}"></input>
      </div>
    </div>
     
    <div class="form-group">
      <label class="control-label  col-md-2">Domicilio</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="docente_domicilio" value="{{$docente->doc_domicilio}}"></input>
        </div>
    </div>    
    
    <!--div class="form-group">
      <label class="control-label  col-sm-2">CP</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="docente_cp" value="">
      </div>
    </div-->
    <? $localidades = ['1'=>'CABA','2'=>'PBA','3'=>'Otros'] ; ?>
    <div class="form-group">
      <label class="control-label  col-md-2">Localidad</label>
        <div class="col-md-4">
          <select class="form-control" name="localidad_id" id="localidad_id">
            <option value="0" selected>-</option>
            @foreach($localidades as $key=>$localidad)
            <?php if( $key == $docente->localidad_id ){?>
            <option value="{{$key}}" selected>{{$localidad}}</option>
            <?php }else{?>
            <option value="{{$key}}">{{$localidad}}</option>
            <?php }?>
            @endforeach
         </select>
        </div>
    </div>
    
    <hr>
    <h3>Datos de Facturaci&oacute;n</h3>
    <hr>

    <?
    $tipo_cuentas = ['1'=>'Cuenta Corriente','2'=>'Caja de Ahorro','3'=>'Otro'] ;
    $tipo_factura = ['1'=>'No posee','2'=>'B','3'=>'C'] ;

    
    ?>
    <div class="form-group">
      <label class="control-label  col-md-2">Factura/Recibo</label>
        <div class="col-md-4">
          <select class="form-control" name="tipo_factura_id" id="docente_tipo_factura_id">
            <option value="0" selected>-</option>
            @foreach($tipo_factura as $key=>$tipo_factura)
            <?php if( $key == $docente->tipo_factura_id ){?>
            <option value="{{$key}}" selected>{{$tipo_factura}}</option>
            <?php }else{?>
            <option value="{{$key}}">{{$tipo_factura}}</option>
            <?php }?>
            @endforeach
         </select>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">Nombre de Banco</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="nombre_banco" value="{{$docente->nombre_banco}}"></input>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">Tipo de Cuenta</label>
        <div class="col-md-4">
          <select class="form-control" name="tipo_cuenta" id="tipo_cuenta">
            <option value="0" selected>-</option>
            @foreach($tipo_cuentas as $key=>$tipo_cuenta)
            <?php if( $key == $docente->tipo_cuenta ){?>
            <option value="{{$key}}" selected>{{$tipo_cuenta}}</option>
            <?php }else{?>
            <option value="{{$key}}">{{$tipo_cuenta}}</option>
            <?php }?>
            @endforeach
         </select>
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-md-2">Nro de Cuenta</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="nro_cuenta" value="{{$docente->nro_cuenta}}"></input>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">CBU</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="cbu" value="{{$docente->cbu}}"></input>
        </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Alias</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="alias" value="{{$docente->alias}}"></input>
        </div>
    </div>
    
    <hr>
    <h3>Datos Acad&eacute;micos</h3>
    <hr>

    <div class="form-group">
      <label class="control-label  col-sm-2">TITULO</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_titulo}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">ESPECIALIDAD</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_especialidad}}">
      </div>
    </div>


    <div class="form-group">
      <label class="control-label  col-sm-2">TIPO FACTURA</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_tipo_factura}}">
      </div>
    </div>


    

    <div class="form-group">
      <label class="control-label  col-sm-2">CLAVE</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_clave}}">
      </div>
    </div>


    <div class="form-group">
      <label class="control-label  col-sm-2">CV RESUMIDO</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_cv_resumido}}">
      </div>
    </div>


    <div class="form-group">
      <label class="control-label  col-sm-2">CV</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="{{$docente->doc_cv}}">
      </div>
    </div>

    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="r_alta_docentes">Guardar</button>
							<a href="{{action('DocenteController@listDocentes')}}" class="btn btn-default">Cancelar</a>
						</div>
		</div>
	</div>


<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#cursos_docente">Cursos</a></li>
</ul>

<div class="tab-content">
  <div id="cursos_docente" class="tab-pane fade in active">

       <table class="table table-condensed table-bordered table-striped volumes">
          <thead>
            <tr>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th>Nombre</th>
              <th width="10%"></th>
            </tr>
          </thead>
          <tbody>

         <!-- FOREACH -->
          @foreach ($cursos_docente as $curso_docente)
            <tr>
                <td> {{ $curso_docente->cur_fechaInicio }} </td>                
                <td> {{ $curso_docente->cur_fechaFin }} </td>                
                <td> {{ $curso_docente->gcu3_titulo }} </td>
                <td> </td>
            </tr>
            <!-- ENDFOREACH -->
         @endforeach    

          </tbody>
        </table>

        <div class="col-sm-12">
        <div class="row">
          <div class="form-group"> 
            
          </div>
        </div>
      </div>
  </div>

  </div>
</div>


</form>
</div> <!-- panel body -->

<script>

</script>

@stop
