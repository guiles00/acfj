@extends('app')

@section('content')
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Estad&iacute;sticas Cursos</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
 Cantidad de cursos por Categor&iacute;a, Grupo y Subgrupo
   </div>

  <div class="panel-body">
  
  <!--form method="GET" action="{{action('TableroController@estadisticasCurso')}}" accept-charset="UTF-8"-->
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

  <input type="button" id="botoneta1" class="btn btn-default botoneta" value="2014"></input>
  <input type="button" id="botoneta2" class="btn btn-default botoneta" value="2015"></input>
  <!--input type="button" id="botoneta2" class="btn btn-default botoneta" value="2016"></input>
  <input type="button" id="botoneta2" class="btn btn-default botoneta" value="2017"></input-->

  <div id="res-grupo">

  </div>  
</div>
<!--/div-->
@stop
<script src="{!! URL::asset('js/jquery.js'); !!}"></script>

<script>
$('document').ready(function(){
  $('.botoneta').click(function(e){

              $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/grupo',
                          url: './grupo',
                          data: {'data':e.target.value},
                          success: function(data){
                            $('#res-grupo').html(data);
                            $('#res-grupo').focus();
                            $('html, body').animate({ scrollTop: 0 }, 'fast');
                          }
                        });

  });

});
</script>
