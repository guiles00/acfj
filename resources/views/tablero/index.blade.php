@extends('app')

@section('content')
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cursos</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
   Tablero de Control - Centro de formaci&oacute;n Judicial
   </div>

  <div class="panel-body">
  
  <form method="GET" action="{{action('TableroController@estadisticasCurso')}}" accept-charset="UTF-8">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

  <div class="form-group">
  <!--
  <label>Grupo</label>
  	<select id="selection" name="grupo" class="form-control">
  		<option value="0" selected="true"> - </option>
  		<option value="1">Categor&iacute;a I</option>
  		<option value="2">Categor&iacute;a II</option>
  		<option value="3">Categor&iacute;a III</option>
  	</select>
  -->
  <label>Seleccione Curso</label>
  <select name="curso" class="form-control select2 ">
      <option value="0" selected="true"> - </option>
  @foreach($cursos as $curso)
  		<option value="{{$curso->cur_id}}">{{$curso->gcu3_titulo}}</option>
  @endforeach    
  	</select>
  </div>

  <button type="submit" class="btn btn-default">Aceptar</button>
  </form>
  <?php 
  //echo "<pre>";
 // print_r($cursos);?>
  	
</div>
<!--/div-->
@stop

<!--script src="{!! URL::asset('/js/jquery.js'); !!}"></script-->
<!--script src="{!! URL::asset('/js/typeahead.js'); !!}"></script-->
  