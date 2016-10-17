@extends('app')

@section('content')
@inject('utils', 'App\domain\Utils')
@inject('usuarioSitio', 'App\domain\UsuarioSitio')
 <ul class="breadcrumb">
    <li>Alumnos</li>
    <li class="active">Listado de Alumnos</li>
</ul>

<div class="panel panel-default">
 
  <div class="panel-heading">
    <div class="form-group pull-left">
                
      </div>
     <div class="row">      
        <form method="GET" action="{{action('UsuarioSitioController@listarUsuarioSitio')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_search" value="true" />
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

            <div class="row">

              <div class="form-group">
                    <input type="text" class="form-control " name="str_usuario" placeholder="" id="u_search_curso">
                        <div class="form-group">      
                          <div class="col-md-4">
                                <select class="form-control search_beca" name="estado_id" id="u_estado_id">
                                      <option value="-1">-</option>
                                      <option value="0">VALIDAR</option>
                                </select> 
                          </div>        
                        </div> 
                    <button type="submit" class="btn btn-default" id="u_buscar_curso">Buscar</button>
              </div>   
         </div>
        </form>
    </div>
  </div>
      <div class="panel-body">
        <div class="table-responsive">
              <table class="table table-responsive table-striped table-bordered table-hover" id="curso">
                  <thead>
                      <tr>
                         <th><a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a></th>                   
                         <th>DNI</th>
                         <th>LEGAJO</th>
                         <th>EMAIL</th>
                         <th>NOMBRE</th>
                         <th>AREA</th>
                         <th>DEPENDENCIA</th>
                         <th>CARGO</th>
                         <th>REGISTRADO</th>
                         <th>ACTIVO</th>
                         <th></th>
                         <th>VALIDAR</th>
                     </tr>
                 </thead>
                 <tbody>
                 
                 @foreach ($usuarios_sitio as $usuario_sitio)
                  <tr id="<?=$usuario_sitio->usi_id?>" >
                      <td></td>
                      <td>{{$usuario_sitio->usi_dni}}</td>
                      <td>{{$usuario_sitio->usi_legajo}}</td>   
                      <td>{{$usuario_sitio->usi_email}}</td>
                      <td>{{$usuario_sitio->usi_nombre}}</td>
                      <td>{{$usuarioSitio::traeAreaById($usuario_sitio->usi_fuero_id)}}</td>
                      <td>{{$usuarioSitio::traeDependenciaById($usuario_sitio->usi_dep_id) }}</td>
                      <td>{{$usuarioSitio::traeCargoById($usuario_sitio->usi_car_id)}}</td>
                      <td>{{$usuario_sitio->usi_validado}}</td>
                      <td>{{$usuario_sitio->usi_activado}}</td>
                      <td> <a href="{!! URL::action('UsuarioSitioController@verUsuarioSitio',$usuario_sitio->usi_id) !!}">Ver</a></td>
                      <?if($usuario_sitio->usi_validado == '-'):?>
                      <td><a href="#" class="btn btn-default  uajaxCall" onClick="return false" >OK</a></td>
                      <?else:?> <!-- {!! URL::action('UsuarioSitioController@validarUsuarioSitio') !!}-->
                      <td><a href="{!! URL::action('UsuarioSitioController@resetPasswordUsuarioSitio',$usuario_sitio->usi_id) !!}" class="btn btn-default gajaxCall" onClick="return false" >RESET</a></td>
                      <?endif;?>
                  </tr>
                  @endforeach     

                 </tbody>
          </table>
        </div>
      </div>  

  
<?php echo $usuarios_sitio->render(); ?>
</div>
<script>
$(document).ready(function() {
   $('#u_search_curso').on('change', function(d) {
                
                $('#u_buscar_curso').click();

                });
   $('#u_estado_id').on('change', function(d) {
                
                $('#u_buscar_curso').click();

    });


   $('.uajaxCall').click(function(e){
    //e.preventDefault();
    console.debug(e.target)
    var href = e.target.href;
    var usi_id = e.target.parentNode.parentNode.id;
    var _token = $('#csrf-token').val();
    console.debug(href);
    console.debug(usi_id);

        $.ajax({
                    url : href
                    //url:'./validarUsuarioSitio'
                    ,type:'POST'
                    ,data: {'cus_id':usi_id,'_token':_token}
                    ,success : function(result) {
                    window.location.reload(false); 
                    }
                  });  
         
    });

   $('.gajaxCall').click(function(e){
    //e.preventDefault();
    console.debug(e.target)
    var href = e.target.href;
    var usi_id = e.target.parentNode.parentNode.id;
    var _token = $('#csrf-token').val();
    console.debug(href);
    console.debug(usi_id);
    if(!confirm('Desea Blanquear la Contraseña?')) return false;
        $.ajax({
                    url : href
                    //url:'./validarUsuarioSitio'
                    ,type:'GET'
                    //,data: {'cus_id':usi_id,'_token':_token}
                    ,success : function(result) {
                    //window.location.reload(false); 
                    //alert('Contraseña Reseteada');
                    }
                  });  
         
    });



 });
</script>
@stop
