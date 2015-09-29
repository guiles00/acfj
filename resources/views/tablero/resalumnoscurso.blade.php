
<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"></h3>
                </div>
                <!-- /.col-lg-12 -->
</div>
 <div class="row">
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid5" style="cursor: pointer;">
            <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr>
              <td>{{ $dat->usi_nombre }}</td>
              <td>{{ $dat->usi_email }}</td>
              </tr>
            @endforeach
            </tbody>
            </table>
  </div>
</div>
<div> <a href="#" id="top">Arriba</a>
  </div>
<script>
$('document').ready(function(){

$('#top').click(function(){
  
   $("body, html").animate({ 
                          scrollTop: 0
                          }, 600);
  //window.scrollTo(0,0);
});

     $(".dataGrid5 td").click(function(e) {
  
       
 // alert('Que puedo mostrar?');
/*        var href = e.target.parentNode.getAttribute('href');

         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      $('#res-cursos').html(data);
                    }
                });

*/
    });

});
</script>



  