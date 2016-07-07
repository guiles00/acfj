@extends('app')

@section('content')

 <ul class="breadcrumb">
    <li>Cursos</li>
    <li class="active">Listado de Capacitadores</li>
</ul>

<div class="panel panel-default">
 
  <div class="panel-heading">
    <div class="form-group pull-left">
                <a class="btn btn-default pull-left" href="{!! URL::action('DocenteController@listDocentes'); !!}" aria-label="Left Align">Agregar Capacitador</a>
      </div>
     <div class="row">      
        <form method="GET" action="{{action('DocenteController@listDocentes')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
              <div class="form-group">
                    <input type="text" class="form-control " name="str_docente" placeholder="" id="search_docente">
                    <button type="submit" class="btn btn-default" id="buscar_docente">Buscar</button>
              </div>   
         </div>
        </form>
    </div>
  </div>
    
      <div class="panel-body">
        <div class="table-responsive">
              <table class="table table-responsive table-striped table-bordered table-hover" id="docente">
                  <thead>
                      <tr>                   
                         <th>ID</th>
                         <!--th>APELLIDO</th-->
                         <th>NOMBRE</th>
                         <th>TELEFONO</th>
                         <th>CELULAR</th>
                         <th>EMAIL</th>
                         <th>DOMICILIO</th>
                         <th>CP</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                 
                 @foreach ($docentes as $docente)
                  <tr>
                    <td>{{$docente->doc_id}}</td>
                    <td>{{$docente->doc_nombre}}</td>
                    <td>{{$docente->doc_telefono}}</td>
                    <td>{{$docente->doc_celular}}</td>
                    <td>{{$docente->doc_email}}</td>
                    <td>{{$docente->doc_domicilio}}</td>
                    <td>{{$docente->doc_cp}}</td>
                    <td> <a href="{!! URL::action('DocenteController@editDocente',$docente->doc_id); !!}">Ver</a></td>
                  </tr>
                  @endforeach     

                 </tbody>
          </table>
        </div>
      </div>  

  <?php echo $docentes->render(); ?>

</div>
<script>
$(document).ready(function() {
              
              $('#search_docente').on('change', function(d) {
              

                $('#buscar_docente').click();

                });

});
</script>
@stop