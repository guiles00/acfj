@extends('app')

@section('content')

     <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Inscriptos Curso</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<div class="panel panel-default">
   <div class="panel-heading">
   Listado de Inscriptos
   </div>

  <div class="panel-body">
  <a href="{!! URL::action('TableroController@cursoFecha', array('anio'=>$data['anio']) )!!}">Volver</a>

<!--div class="row"-->
 <div class="table-responsive">
          <table class="table table-responsive table-striped table-bordered table-hover" id="alum">
            <thead>
                <tr>
                   <th>DNI</th>
                   <th>Legajo</th>
                   <th>Email</th>
                   <th>Nombre</th>
                   <!--th class="hidden-sm">Registrado</th-->
                   <!--th class="hidden-sm">Activo</th-->  
               </tr>
           </thead>
           <tbody>
            @foreach ($data['res'] as $alumno)
            <tr>
                <td><a href="{{action('AlumnosController@show',$alumno->usi_id)}}"> {{ $alumno->usi_dni}}</a></td>
                <td><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_legajo}}</a></td>
                <td><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_email}}</a></td>
                <td><a href="{{action('AlumnosController@show',$alumno->usi_id)}}"> {{ $alumno->usi_nombre}}</a></td>
                <!--td class="hidden-sm"><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_validado}}</a></td-->
                <!--td class="hidden-sm"><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_activado}}</a></td-->
            </tr>
            @endforeach    
        </tbody>
    </table>
<a href="{!! URL::action('TableroController@cursoFecha', array('anio'=>$data['anio']) )!!}">Volver</a>
  <!--/div-->
</div>
</div>
</div>        
@stop