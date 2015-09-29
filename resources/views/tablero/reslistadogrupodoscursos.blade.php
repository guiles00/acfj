   <!--div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">{{$data['res'][0]->gcu_nombre}}</h2>
                </div>
                
      </div-->
<div class="col-lg-12">
 <div class="row">
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="{!! URL::action('TableroController@listadoCursos', array('gcu2_id'=>$dat->gcu2_id,'anio'=>$data['anio'])); !!}" style="cursor: pointer;">
              <td> {{ $dat->gcu2_nombre }}</td>
              <td> {{ $dat->cantidad }} </td>
              </tr>
            @endforeach
            </tbody>
            </table>
</div>
</div>
  <div id="res-cursos">
  </div>
</div>
<script>
$('document').ready(function(){

    $('.traemeladata2').click(function(e){
        //e.preventDefault();
        return;
        console.debug(e.target.href);
        var href = e.target.href;
//return;
       // var gcu_id = e.target.parentNode.parentNode.childNodes[1].value;
        //var anio = e.target.parentNode.parentNode.childNodes[3].value;

        $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                     // $('#res-cursos').html(data);
                     // $('#res-cursos').focus();
                    }
                });

    });



     $(".dataGrid td").click(function(e) {
        
        var href = e.target.parentNode.getAttribute('href');

         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      
                         $("body, html").animate({ 
                          scrollTop: $( $('#res-cursos') ).offset().top 
                          }, 600);
                      
                      $('#res-cursos').html(data);
                      
                      
                    }
                });

    });

});
</script>

  