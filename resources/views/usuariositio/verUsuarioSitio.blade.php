@extends('app')

@section('content')


 <ul class="breadcrumb">
    <li>Alumnos</li>
    <li class="active">Ver Usuario Sitio</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<a href="{{action('UsuarioSitioController@listarUsuarioSitio')}}" class="btn btn-default glyphicon glyphicon-arrow-left"></a>
	</div>


  <div class="panel-body">
	 
       <?php if(isset($edited)){?>
        <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Registro Editado!</b>
        </div>
      <?php } ?> 



 	<form class="form-horizontal" role="form" method="POST" action="{{action('UsuarioSitioController@update')}}" id="r_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$usuario_sitio->usi_id}}" />
    
    <div class="form-group">
      <label class="control-label  col-sm-2">NOMBRE</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="usuario_sitio_nombre" value="{{ strtoupper($usuario_sitio->usi_nombre)}}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">DNI</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="usuario_sitio_dni" value="{{$usuario_sitio->usi_dni}}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">EMAIL</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="usuario_sitio_email" value="{{$usuario_sitio->usi_email}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">TELEFONO</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="usuario_sitio_telefono" value="{{$usuario_sitio->usi_telefono}}">
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2">CELULAR</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="usuario_sitio_celular" value="{{$usuario_sitio->usi_celular}}"></input>
      </div>
    </div>

    
    
    <div class="form-group">
      <label class="control-label col-md-2">DOMICILIO</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="usuario_sitio_domicilio" value="{{$usuario_sitio->usi_direccion}}"></input>
        </div>
    </div>    
    
    <div class="form-group">
      <label class="control-label  col-sm-2">CP</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="usuario_sitio_cp" value="{{$usuario_sitio->usi_cp}}">
      </div>
    </div>
    <div class="form-group">
          <label class="control-label col-md-2">Area</label>
          <div class="col-md-6">
            <select class="form-control" name="fuero_id">
              @foreach($helpers['fueros'] as $key=>$fuero)
              <?php if( $fuero->fuero_id == $usuario_sitio->usi_fuero_id ){?>
              <option value="{{$fuero->fuero_id}}" selected>{{$fuero->fuero_nombre}}</option>
              <?php }else{?>
              <option value="{{$fuero->fuero_id}}">{{$fuero->fuero_nombre}}</option>
              <?php }?>
              @endforeach
            </select>
          </div>
     </div>
     <div class="form-group">
          <label class="control-label col-md-2">Otro</label>
          <div class="col-md-6">
            <input class="form-control input-sm" name="area_otro" value='{{$usuario_sitio->usi_fuero_otro}}'>
          </div>
        </div>
     <div class="form-group">
      <label class="control-label col-md-2">Dependencia</label>
      <div class="col-md-6">
        <select class="form-control select2" name="dependencia_id" id="b_dep_id">
          @foreach($helpers['dependencias'] as $key=>$dependencia)
          <?php if( $dependencia->dep_id == $usuario_sitio->usi_dep_id ){?>
          <option value="{{$dependencia->dep_id}}" selected>{{$dependencia->dep_nombre}}</option>
          <?php }else{?>
          <option value="{{$dependencia->dep_id}}">{{$dependencia->dep_nombre}}</option>
          <?php }?>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
          <label class="control-label col-md-2">Otra Dependencia</label>
          <div class="col-md-6">
            <input class="form-control input-sm" name="dependencia_otro" value='{{$usuario_sitio->usi_dep_otro}}'>
          </div>
      </div>
        <div class="form-group">
          <label class="control-label col-md-2">Cargo</label>
          <div class="col-md-6">
            <select class="form-control select2" name="car_id" id="b_car_id">
              @foreach($helpers['cargos'] as $key=>$cargo)
              <?php if( $cargo->car_id == $usuario_sitio->usi_car_id ){?>
              <option value="{{$cargo->car_id}}" selected>{{$cargo->car_nombre}}</option>
              <?php }else{?>
              <option value="{{$cargo->car_id}}">{{$cargo->car_nombre}}</option>
              <?php }?>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Otro Cargo</label>
          <div class="col-md-6">
            <input class="form-control input-sm" name="cargo_otro" value='{{$usuario_sitio->usi_cargo_otro}}'>
          </div>
        </div>
    <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2">CLAVE</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="" value="">
      </div>
    </div>

    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="r_alta_usuario_sitios">Guardar</button>
							<a href="{{action('UsuarioSitioController@listarUsuarioSitio')}}" class="btn btn-default">Cancelar</a>
						</div>
		</div>
	</div>


<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#cursos_usuario_sitio">Cursos</a></li>
</ul>

<div class="tab-content">
  <div id="cursos_usuario_sitio" class="tab-pane fade in active">

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
          
            <tr>
                <td>  </td>                
                <td>  </td>                
                <td>  </td>
                <td> </td>
            </tr>
            <!-- ENDFOREACH -->
         

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
