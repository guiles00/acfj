 <div class="col-lg-12">

      <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cursos dictados en {{ $data['anio'] }}</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
   </div>

  <div class="panel-body">
  
   <div class="col-lg-12">
   <div class="row">

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid1">
            <thead>
                <tr>
                    <th>Categor&iacute;a</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="{!! URL::action('TableroController@listadoGrupoDosCursos', array('gcu_id'=>$dat->gcu_id,'anio'=>$data['anio'])); !!}">
              <input type="hidden" value="{{ $dat->gcu_id}}"></input>
              <input type="hidden" value="{{ $data['anio'] }}"></input>
              <td>{{$dat->gcu_nombre}}</td>
              <td>{{$dat->cantidad}}</td>
              </tr>
            @endforeach
            </tbody>
            </table>
      </div>
    </div>
  </div>
  
  <div id="res2">
  </div>
  
  </div>
  </div>

<script src="{!! URL::asset('js/jquery.js'); !!}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
<script src="{!! URL::asset('/js/d3pie.js'); !!}"></script>

<script>
$('document').ready(function(){
  $('#botoneta').click(function(){
    
   // $('#res').html('esta es para vos');

              $.ajax({
                          url: 'http://localhost/content/cfj-cfj/admin_cfj/public/area',
                          //data: {'data':d.target.value},
                          success: function(data){
                           // console.debug(data);
                            $('#content').html(data);
                           // console.debug(data);
                          }
                          //dataType: dataType
                        });

  });

    $('.traemeladata').click(function(e){
        e.preventDefault();
        return;
        //console.debug(e.target.parentNode.parentNode.childNodes);
        //return;
        var gcu_id = e.target.parentNode.parentNode.childNodes[1].value;
        var anio = e.target.parentNode.parentNode.childNodes[3].value;
        console.debug(e.target.href);
        var href = e.target.href;
        $.ajax({
                   url: href
                   // url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoGrupoDosCursos',
                   // data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      $('#res2').html(data);
                    }
                });

    });

     $(".dataGrid1 td").click(function(e) {
        
        var href = e.target.parentNode.getAttribute('href');
        //console.debug(href);
         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      $('#res2').html(data);
                    }
                });

    });
});
</script>
