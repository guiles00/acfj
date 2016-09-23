@extends('app')

@section('content')

 <ul class="breadcrumb">
    <li>Listado Curso</li>
    <li class="active">Ver Inscriptos Curso</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
       <a <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('CursosController@listarCursos')}}" ></a>
</div>

<div class="panel-body">
  
  <div>
  
  <input type="hidden" name="" id="b_curso_id" value="{{$cur_id}}" ></input>
  </div>

      <div id="b_res_inscriptos">    

      </div>  
</div>
<!--/div-->  

<!-- -->
</div>
<script type="text/javascript">

var cur_id = <? echo $cur_id?>;
function load_inscriptos(cur_id){

             $.ajax({
                          url:'../listarUsuariosCurso/'+cur_id
                          //,data: {'cur_id':cur_id}
                          ,success: function(data){
                            $('#b_res_inscriptos').html(data);
                          }
            });
}



$('document').ready(function(){

load_inscriptos(cur_id);

});
</script>
@stop