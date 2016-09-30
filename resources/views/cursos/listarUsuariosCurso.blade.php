@inject('icurso','App\domain\Curso')
<!-- Modal Busqueda Avanzada-->
<div class="modal fade" id="basicModal" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close"  aria-hidden="true"></button>
            <h4 class="modal-title" id="myModalLabel">B&uacute;squeda</h4>
            </div>
           

                <div class="modal-body">
                       <div class="form-group">
                      <label class="control-label  col-sm-2" >Alumno</label>    
                      <div class="col-sm-6" >
                         <select class="form-control" name="docente_id" id="b_usuario_sitio_id" style="width: 100%;" required>
                             <option value="" selected></option>
                         </select>
                      </div>
                    </div>    


                </div>
                <div class="modal-footer">
             
                <button type="button" class="btn btn-default" data-dismiss="modal" id="b_cerrar_alumno">Cerrar</button>
                <button type="button" class="btn btn-primary" id="b_agrear_alumno">Aceptar</button>
             
            </div>

    </div>
  </div>
</div>


<!-- remote_select2 js-data-example-ajax -->

  <input type="button" class="btn btn-default" name="validar_todos" id="c_validar_todos" value="Validar Todos" />
  <!--input type="button" class="btn btn-default" name="alta_alumno" id="c_alta_alumno" value="Alta Alumno" /-->
  <a href="#" class="btn glyphicon btn-default" data-toggle="modal" data-target="#basicModal">Alta Alumno</a>
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


    /*$('#c_alta_alumno').click(function(){

        //alert('alta y luego recarga');
        //window.location.replace('../verInscriptosCurso/378');

        load_inscriptos(378);
        trae_data_curso(378);
    });*/





 function formatRepoAlumno (repo) {
      
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" +repo.name + "</div>";
          
      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
       "<div class='select2-result-repository__forks'><b>DNI:</b> " + repo.dni + "</div>" +
      "<div class='select2-result-repository__forks'><b>EMAIL:</b> " + repo.email + "</div>" +
      "</div>" +
      "</div></div>";
      

      return markup;
    }


    function formatRepoSelection (repo) {

      return repo.name || repo.text;
    }




//Autocomplete
//$("#b_alumno_id").select2();

$("#b_usuario_sitio_id").select2({
                                      ajax: {
                                        //url: "./traeDataAlumno",
                                        url: "../traeDataAltaAlumno",
                                        dataType: 'json',
                                        delay: 250,
                                        //dropdownAutoWidth: 'true',
                                        data: function (params) {
                                          return {
                                            q: params.term, // search term
                                            page: params.page,
                                            cur_id:cur_id
                                          };
                                        },
                                        processResults: function (data, params) {
                                          
                                        
                                          // parse the results into the format expected by Select2
                                          // since we are using custom formatting functions we do not need to
                                          // alter the remote JSON data, except to indicate that infinite
                                          // scrolling can be used
                                          params.page = params.page || 1;

                                          return {
                                            results: data.items,
                                            pagination: {
                                              more: (params.page * 30) < data.total_count
                                            }
                                          };
                                        },
                                        cache: true
                                      },
                                      escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                                      minimumInputLength: 3,
                                      templateResult: formatRepoAlumno, 
                                      templateSelection: formatRepoSelection
                });


    $('#b_agrear_alumno').click(function(){
        var usi_id = $('#b_usuario_sitio_id').val();
        var cur_id = $('#b_cur_id').val();
        var _token = $('#csrf-token').val();
        
        //alert('agrega este alumno'+usi_id);
       
         $.ajax({
                    //url : href
                    url:'../addAlumnoCurso'
                    ,type:'POST'
                    ,data: {'usi_id':usi_id,'cur_id':cur_id,'_token':_token}
                    ,success : function(result) {
                    
                    window.location.reload(false); 
                    
                    }
                  });        
       
    });

});
</script>
