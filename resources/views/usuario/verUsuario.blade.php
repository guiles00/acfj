@extends('app')

@section('content')
<?
use App\domain\Perfil;
?>
 <ul class="breadcrumb">
    <li>Administraci&oacute;n</li>
    <li class="active">Ver Usuario</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
       <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('UsuarioController@listUsuarios')}}" ></a>
</div>

<div class="panel-body">


<form class="form-horizontal" role="form" method="POST" action="" id="b_form_usuario">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$usuario->user_id}}" />


    
    <div class="form-group">
      <label class="control-label col-sm-2">Username</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="usuario_nombre" value="{{$usuario->username}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Email</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control datepicker" id="" name="usuario_email" value="{{$usuario->email}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2">Perfil de Men&uacute;</label>
      <div class="col-sm-8">          
      <select class="form-control" name="usuario_perfil_id" >
            @foreach($perfil_menu as $key=>$perfil)
            <?php if( $perfil->perfil_id == $usuario->perfil_id ){?>
            <option value="{{$perfil->perfil_id}}" selected>{{$perfil->nombre}}</option>
            <?php }else{?>
            <option value="{{$perfil->perfil_id}}">{{$perfil->nombre}}</option>
            <?php }?>
            @endforeach
            </select>
      </div>
    </div>
    <div class="form-group"> 
            <div class="col-md-12 col-md-offset-2">
              <button type="button" class="btn btn-default" id="b_save_usuario">Guardar</button>
              <a href="{{action('UsuarioController@listUsuarios')}}" class="btn btn-default">Volver</a>
            </div>
    </div>
  
</form>
<div id="b_user_result"></div>
</div>
</div>
<script type="text/javascript">
$('document').ready(function(){


  $('#b_save_usuario').click(function(e){
    
    //Hago el ajax call
    var data = $('#b_form_usuario').serializeArray();
    
        $.ajax({
                    url : '../updateUsuario'
                    ,type:'POST'
                    ,data: data
                    ,success : function(result) {
                      $('#b_user_result').html(result);
                    }
                  });  
    });

});
</script>
@stop