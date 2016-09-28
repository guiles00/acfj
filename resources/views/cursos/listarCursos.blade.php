@extends('app')

@section('content')
@inject('utils', 'App\domain\Utils')
@inject('icurso', 'App\domain\Curso')
 <ul class="breadcrumb">
    <li>Cursos</li>
    <li class="active">Listado de Cursos</li>
</ul>

<div class="panel panel-default">
 
  <div class="panel-heading">
    <div class="form-group pull-left">
                
      </div>
     <div class="row">      
        <form method="GET" action="{{action('CursosController@listarCursos')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_search" value="true" />
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

            <div class="row">

              <div class="form-group">
                    <input type="text" class="form-control " name="str_curso" placeholder="" id="search_curso">
                        <div class="form-group">      
                          <div class="col-md-4">
                                <select class="form-control search_beca" name="estado_id" id="estado_id">
                                      <option value="-1">-</option>
                                      <option value="0">ACTIVO</option>
                                      <option value="1">CERRADO</option>
                                </select> 
                          </div>        
                        </div> 
                    <button type="submit" class="btn btn-default" id="buscar_curso">Buscar</button>
              </div>   
         </div>
        </form>
    </div>
  </div>
      <div class="panel-body">
        <span align="float:left" align="left"><b>Cantidad de cursos: {{$cant}}</b><span>
        <div class="table-responsive">
              <table class="table table-responsive table-striped table-bordered table-hover" id="curso">
                  <thead>
                      <tr>
                         <th><a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a></th>                   
                         <th>INICO</th>
                         <th>FIN</th>
                         <th>CATEGORIA</th>
                         <th>CURSO</th>
                         <th>ESTADO</th>
                         <th>VALIDADOS</th>
                         <th>INSCRIPTOS</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                 
                 @foreach ($cursos as $curso)
                 <?if($icurso::cantidadValidados($curso->cur_id) < $icurso::cantidadInscriptos($curso->cur_id)):?> 
                 <tr style="background-color:#ff4c4c">
                 <?else:?>
                  <tr>
                 <?endif;?>
                      <td></td>   
                      <td>{{$utils::formatDateBis($curso->cur_fechaInicio)}}</td>
                      <td>{{$utils::formatDateBis($curso->cur_fechaFin)}}</td>
                      <td>{{$curso->gcu2_nombre}}</td>
                      <td>{{$curso->gcu3_titulo}} </td>
                      <td>activo</td>
                      <td>{{$icurso::cantidadValidados($curso->cur_id)}}</td>
                      <td>{{$icurso::cantidadInscriptos($curso->cur_id)}}</td>
                      <td> <a href="{!! URL::action('CursosController@verInscriptosCurso',$curso->cur_id) !!}">Ver</a></td>

                  </tr>
                  @endforeach     

                 </tbody>
          </table>
        </div>
      </div>  

  

</div>
<script>
$(document).ready(function() {
   $('#search_curso').on('change', function(d) {
                
                $('#buscar_curso').click();

                });

 });
</script>
@stop
