@extends('app')

@section('content')
<?
use App\domain\Perfil;
?>
 <ul class="breadcrumb">
    <li>Administraci&oacute;n</li>
    <li class="active">Ver Perfil</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
       <a <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('PerfilController@listPerfiles')}}" ></a>
</div>

<div class="panel-body">
  
  <div>
  {{ $perfil->nombre }}
  <input type="hidden" name="" id="b_perfil_id" vallue="$perfil->perfil_id" ></input>
  </div>

      <div style=" height: 800px !important;   overflow: scroll;" id="b_res_menu_perfil">    

      </div>  
</div>
<!--/div-->  

<!-- -->
</div>
<script type="text/javascript">
var perfil_id = <? echo $perfil->perfil_id?>;
function load_perfil_menu(perfil_id){

             $.ajax({
                          url:'../loadTableMenuPerfil'
                          ,data: {'id':perfil_id}
                          ,success: function(data){
                            $('#b_res_menu_perfil').html(data);
                          }
            });
}



$('document').ready(function(){

load_perfil_menu(perfil_id);

});
</script>
@stop