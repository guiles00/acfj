
<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">{{$data['res'][0]->gcu2_nombre}}</h3>
                </div>
                <!-- /.col-lg-12 -->
</div>
 <div class="row">
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid3" style="cursor: pointer;">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="{!! URL::action('TableroController@listCursos', array('cur_gcu3_id'=>$dat->cur_gcu3_id,'anio'=>$data['anio']) ); !!}" >
              <td>{{ $dat->gcu3_titulo }}</td>
              <td>{{ $dat->cantidad }}</td>
              </tr>
            @endforeach
            </tbody>
            </table>
  </div>
</div>
<div id="res-listadocurso"> </div>
<script>
$('document').ready(function(){


     $(".dataGrid3 td").click(function(e) {
  

  //alert('Que mierda muestra?');
        var href = e.target.parentNode.getAttribute('href');

         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){

                      $("body, html").animate({ 
                        scrollTop: $( $('#res-listadocurso') ).offset().top 
                        }, 600);  

                      $('#res-listadocurso').html(data);
                    }
                });


    });

});
</script>



  