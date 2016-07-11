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
    
    <div class="form-group">
      <label class="control-label  col-sm-2">APELLIDO</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="docente_apellido" value="{{$docente->doc_apellido}}">
    </div>
    </div>            
    <div class="form-group">
      <label class="control-label  col-sm-2">NOMBRE</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="docente_nombre" value="{{$docente->doc_nombre}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-md-2">TELEFONO</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="docente_telefono" value="{{$docente->doc_telefono}}">
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">CELULAR</label>
      <div class="col-sm-4">          
        <input type="text" class="form-control" id="" name="docente_celular" value="{{$docente->doc_celular}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">EMAIL</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="docente_email" value="{{$docente->doc_email}}"></input>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-md-2">DOMICILIO</label>
        <div class="col-md-4">
          <input type="text" class="form-control" id="" name="docente_domicilio" value="{{$docente->doc_domicilio}}"></input>
        </div>
    </div>    
    
    <div class="form-group">
      <label class="control-label  col-sm-2">CP</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="docente_cp" value="{{$docente->doc_cp}}">
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
