@inject('icurso','App\domain\Curso')
 <!--ul class="breadcrumb">
    <li>Cursos - Listado Cursos</li>
    <li class="active">Listado de Inscriptos</li>
</ul-->

<!--div class="panel panel-default">
 
  <div class="panel-heading">
    <!--div class="form-group pull-left">
                
      </div-->
  <input type="button" class="btn btn-default" name="validar_todos" id="c_validar_todos" value="Validar Todos" />
  <input type="button" class="btn btn-default" name="alta_alumno" id="c_alta_alumno" value="Alta Alumno" />
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
  <input type="hidden" name="" id="b_cur_id" value="{{$cur_id}}" ></input>
  <span id="loading"></span>
  <!--/div-->
      <!--div class="panel-body"-->
        <div class="table-responsive">
              <table class="table table-responsive table-striped table-bordered table-hover" id="curso">
                  <thead>
                      <tr>
                         <th><a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a></th>                   
                         <th>EMAIL</th>
                         <th>NOMBRE</th>
                         <th>AREA</th>
                         <th>DEPENDENCIA</th>
                         <th>CARGO</th>
                         <th>Validar</th>
                         <th>Asistio</th>
                     </tr>
                 </thead>
                 <tbody>
                 
                 @foreach ($inscriptos as $inscripto)
                 <?if( ! ($inscripto->cus_validado == 'Si')):?> 
                 <tr id="<?=$inscripto->cus_id?>" style="background-color:#ff4c4c">
                 <?else:?>
                  <tr id="<?=$inscripto->cus_id?>" >
                 <?endif;?>
                      <td></td>   
                      <td>{{$inscripto->usi_email}}</td>
                      <td>{{$inscripto->usi_nombre}}</td>
                      <td>{{$icurso::traeAreaById($inscripto->usi_fuero_id)}}</td>
                      <td>{{$icurso::traeDependenciaById($inscripto->usi_dep_id)}}</td>
                      <td>{{$icurso::traeCargoById($inscripto->usi_car_id)}}</td>
                      
                      <?if( ! ($inscripto->cus_validado == 'Si')):?> 
                      <td><a href="{!! URL::action('CursosController@validarUsuarioCurso'); !!}" onClick="return false" class="btn btn-default  ajaxCall">Validar</a></td>
                      <?else:?>
                      <td><a href="{!! URL::action('CursosController@rechazarUsuarioCurso'); !!}" onClick="return false" class="btn btn-default ajaxCall">Rechazar</a></td>
         <!--td>             <button type="button" class="btn btn-default">
  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
</button></td-->
                      <?endif;?>   
                      <td></td>
                  </tr>
                  @endforeach     

                 </tbody>
          </table>
        <!--/div-->

      <!--/div>  
</div-->

<script>

$('document').ready(function(){

/*
                  $('#loading').hide();
                    $('#loading')
                    .ajaxStart(function() {
                        $(this).show();
                    })
                    .ajaxStop(function() {
                        $(this).hide();
                    });
*/
  $('.ajaxCall').click(function(e){
    var cur_id = $('#b_cur_id').val();
    var cus_id = e.target.parentNode.parentNode.id;
    var _token = $('#csrf-token').val();
    var href = e.target.href;
    
    //Hago el ajax call
    var selector = '#td'+e.target.parentNode.parentNode.id;

        $.ajax({
                    url : href
                    //url:'../validarUsuarioCurso'
                    ,type:'POST'
                    ,data: {'cus_id':cus_id,'_token':_token}
                    ,success : function(result) {
                    
                    load_inscriptos(cur_id);
                    trae_data_curso(cur_id);
                    }
                  });  
               
    });

    $('#c_validar_todos').click(function(){
      if( ! confirm('Estas segurdo que desea Validar todos') ) return false;
      var cur_id = $('#b_cur_id').val();
      var _token = $('#csrf-token').val();

      $.ajax({
                    //url : href
                    url:'../validarTodosCurso'
                    ,type:'POST'
                    ,data: {'cus_cur_id':cur_id,'_token':_token}
                    ,success : function(result) {
                    
                    load_inscriptos(cur_id);
                    trae_data_curso(cur_id);
                    }
                  });  
            });

});
</script>
