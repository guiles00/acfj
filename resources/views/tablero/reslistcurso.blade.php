
<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">{{$data['res'][0]->gcu3_titulo}}</h3>
                </div>
                <!-- /.col-lg-12 -->
</div>
 <div class="row">
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid4" style="cursor: pointer;">
            <thead>
                <tr>
                    <!--th>Id</th-->
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="#" >
              <!--td>{{ $dat->cur_id }}</td-->
              <td href="1">{{ $dat->cur_fechaInicio }}</td>
              <td href="2">{{ $dat->gcu3_titulo }}</td>
              <td href="{!! URL::action('TableroController@fichaCurso', array('cur_id'=>$dat->cur_id) ); !!}">Ver Ficha</td>
              </tr>
            @endforeach
            </tbody>
            </table>
  </div>
</div>
<div id="res-fichacurso">
</div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Este curso tiene los siguientes datos</h4>
        </div>
        <div class="modal-body">
          <p>Fecha de inicio y fecha de finalizacion</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>







<script>
$('document').ready(function(){


     $(".dataGrid4 td").click(function(e) {
    
        //jQuery.noConflict();
        //$('#myModal').modal('toggle');  
        //var href = e.target.parentNode.getAttribute('href');
        var href = e.target.getAttribute('href');

         if(href == 2){
          return;
        }


        if(href == 1){
          jQuery.noConflict();
          
          $('#myModal').modal('toggle');
          
        }

         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){

                        $("body, html").animate({ 
                        scrollTop: $( $('#res-fichacurso') ).offset().top 
                        }, 600);  

                      $('#res-fichacurso').html(data);
                    }
                });


    });

});
</script>



  