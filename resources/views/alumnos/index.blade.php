@extends('app')

@section('content')
  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listado</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<div class="panel panel-default">
 <div class="panel-heading">
    <button type="button" class="btn btn-default" aria-label="Left Align">
     <a href="{{action('AlumnosController@create')}}" class="glyphicon glyphicon-plus" ></a>

 </button>
 Alumnos
 <form method="GET" action="{{action('AlumnosController@index')}}" class="navbar-form navbar-left pull-right" role="search">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <div class="form-group">
        <input type="text" class="form-control" name="str_alumno" placeholder="" id="search_alumno">
    </div>
    <button type="submit" class="btn btn-default">Buscar</button>
</form>

</div>

<div class="panel-body">

    <div class="table-responsive">
        <table class="table table-responsive table-striped table-bordered table-hover" id="alum">
            <thead>
                <tr>
                   <th>DNI</th>
                   <th>Legajo</th>
                   <th>Email</th>
                   <th>Nombre</th>
                   <th class="hidden-sm">Registrado</th>
                   <th class="hidden-sm">Activo</th>  
               </tr>
           </thead>
           <tbody>
            @foreach ($alumnos as $alumno)
            <tr>
                <td><a href="{{action('AlumnosController@show',$alumno->usi_id)}}"> {{ $alumno->usi_dni}}</a></td>
                <td><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_legajo}}</a></td>
                <td><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_email}}</a></td>
                <td><a href="{{action('AlumnosController@show',$alumno->usi_id)}}"> {{ $alumno->usi_nombre}}</a></td>
                <td class="hidden-sm"><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_validado}}</a></td>
                <td class="hidden-sm"><a href="{{action('AlumnosController@show',[$alumno->usi_id])}}"> {{ $alumno->usi_activado}}</a></td>
            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php echo $alumnos->render(); ?>

<div id="res"></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
              $('#search_alumno').on('change keyup paste', function(d) {
                

                  console.log('I am pretty sure the text box changed');
                  //alert('okaaasasasa');
                  console.debug(d.target.value);
                  $.ajax({
                          url: 'http://localhost/content/cfj-cfj/admin_cfj/public/alumnos',
                          data: {'data':d.target.value},
                          success: function(data){
                           // console.debug(data);
                          //  $('#res').html(data);
                          }
                          //dataType: dataType
                        });


                });

            });
</script>
@stop