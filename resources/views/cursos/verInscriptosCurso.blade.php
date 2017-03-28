@extends('app')

@section('content')

 <ul class="breadcrumb">
    <li>Listado Curso</li>
    <li class="active">Ver Inscriptos Curso</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
       <!--a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('CursosController@listarCursos')}}" ></a-->
       <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{!! URL::previous(); !!}" ></a>

</div>

<div class="panel-body">

<div>
  <input type="hidden" name="" id="b_curso_id" value="{{$cur_id}}" ></input>


  <div class="table-responsive">
              <table class="table table-responsive table-bordered table-hover" id="curso">
                 <tbody>
                  <tr>
                     <th id="c_titulo" colspan="4"></th>
                  </tr>
                  <tr>
                     <th>Fecha Inicio</th>
                     <td id="c_f_inicio">01/01/2016</td>
                     <th>Fecha Fin</th>
                     <td id="c_f_fin">01/02/2016</td>
                  </tr>
                  <tr>
                     <th>Validados</th>
                     <td id="c_validados">12</td>
                     <th>Sin Validar</th>
                     <td id="c_sin_validar">18</td>
                  </tr>
                  <tr>
                     <th colspan="2">Total</th>
                     <td colspan="2" id="c_total"></td>
                  </tr>
                 </tbody>
               </table>
  </div>               
</div>

      <div id="b_res_inscriptos">    

      </div>  
</div>
<!--/div-->  

<!-- -->
</div>
<script type="text/javascript">

var cur_id = <? echo $cur_id?>;

function trae_data_curso(cur_id){

             $.ajax({
                          url:'../traeDataCurso/'+cur_id
                          //,data: {'cur_id':cur_id}
                          ,success: function(data){
                            console.debug(data);
                            $('#c_titulo').html(data.titulo);
                            $('#c_validados').html(data.validados);
                            $('#c_sin_validar').html(data.por_validar);
                            $('#c_total').html(data.total);
                            $('#c_f_inicio').html(data.cur_fechaInicio);
                            $('#c_f_fin').html(data.cur_fechaFin);
                          }
            });
}

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
trae_data_curso(cur_id);

});
</script>
@stop