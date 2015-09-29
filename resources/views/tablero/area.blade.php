@extends('app')

@section('content')
<div class="row">
  <div id="breadcrumb" class="col-xs-12">
    <ol class="breadcrumb">
      <li><a href="index.html">Panel de Control</a></li>
      <li><a href="#">Indice</a></li>
      <!--li><a href="#">Simple Tables</a></li-->
    </ol>
  </div>
</div>
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cursos</h1>
                </div>
                <div class="row">
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

  <div id="res">

  </div>  
</div>
<!--/div-->
@stop
<script src="{!! URL::asset('js/jquery.js'); !!}"></script>

<script>
$('document').ready(function(){
  $('.botoneta').click(function(e){

              $.ajax({
                          url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          data: {'data':e.target.value},
                          success: function(data){
                            $('#res').html(data);
                          }
                        });

  });

});
</script>
