@extends('app')

@section('content')
<!--script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script-->
<script src="{!! URL::asset('js/d3.js'); !!}"></script>
<script src="{!! URL::asset('/js/d3pie.js'); !!}"></script>

    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Catego&iacute;as</h1>
                </div>
      </div>

<div class="panel panel-default">
   <div class="panel-heading">

   </div>

  <div class="panel-body">

        <div class="row">
        <div class="col-md-4 ">
        <label>Seleccione Categor&iacute;a</label>
        <select name="curso" class="form-control select2 select-cat" id="a-categoria">
            <option value="0" selected="true"> - </option>
        
            <option value="12">Capacitación en Oficina</option>
            <option value="9">Programas Permanentes</option>
            <option value="10">Otras Actividades</option>
            <option value="7">Res. CSel. N° 175/07</option>   
            <option value="8">Res. CSel. N° 126/12 </option>
          </select>
       </div>
       <div class="col-md-4">
       <label>Seleccione A&nacute;o</label>
        <select name="curso" class="form-control select2 select-cat" id="a-anio">
            <!--option value="0" selected="true"> - </option-->
            <option value="2015">2015</option>
            <option value="2014">2014</option>
        </select>
      </div>
  </div>
</div>
</div>  
  <div id="res-grupo">

  </div>  


@stop
<script src="{!! URL::asset('js/jquery.js'); !!}"></script>

<script>
$('document').ready(function(){
  $('.select-cat').change(function(e){

     var categoria = $("#a-categoria").val();
     var anio = $("#a-anio").val();

    $.ajax({ //http://10.48.135.16/content/cfj-cfj/admin_cfj/public
                          url:'./listadoGrupoDosCursos'
                          //url: './cfj-cfj/admin_cfj/public/listadoGrupoDosCursos',
                          ,data: {'gcu_id':categoria,'anio':anio},
                          success: function(data){
                            $('#res-grupo').html(data);
                          }
            });
  });

  

              

  

});
</script>
