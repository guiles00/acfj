@extends('app')

@section('content')

<style>
.btn span.glyphicon {         
  opacity: 0;       
}
.btn.active span.glyphicon {        
  opacity: 1;       
}
</style>
 <ul class="breadcrumb">
    <li>Pago Cheques</li>
    <li class="active">Alta Pago/Cheque (Curso)</li>
</ul>
<div class="panel panel-default">
  <div class="panel-heading">
      <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ChequesController@listPagoCheques')}}"></a>
    </div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="a_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>QUE DATOS VAN ACA</b>
    </div>

  <div class="panel-body">

  <form class="form-horizontal" role="form" method="POST" action="{{action('ChequesController@saveCursoPagoCheque')}}" id="a_form_alta">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
   

  <div class="form-group">
      <label class=" col-sm-12"></label>
      </div>
  <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Capacitador</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="docente_id" id="b_docente_id" required>
             <option value="" selected></option>
         </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Actividad</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="curso_id" id="b_curso_id" required>
             <option value="" selected></option>
         </select>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Nro Disposici&oacute;n Fija Fecha</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_otorga" value=""></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Disposici&oacute;n Certificaci&oacute;n Pago</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_aprueba" value=""></input>
      </div>
    </div>
        

     <div class="form-group">
      <label class="control-label  col-sm-2">Monto Solicitado</label>
      <div class="col-sm-6">          
        <input type="number" min="1" step="any" class="form-control" id="" name="importe" value=""></input>
      </div>
    </div>


     <div class="form-group">
      <label class="control-label col-md-2">Nro. Memo</label>
        <div class="col-md-6">
          <select class="form-control remote_select2 js-data-example-ajax" name="nro_memo_id" id="b_nro_memo_id">
              <option value="" selected></option>
            </select>
        </div>
     </div>
    <div class="form-group">
      <label class="control-label col-md-2">Disponible</label>
        <div class="col-md-6">
          <select class="form-control" name="disponible_id" id="b_disponible_id">
            <option value="0">NO</option>
            <option value="1">SI</option>
            </select>
        </div>
     </div>  
     <div class="form-group">
      <label class="control-label col-md-2">Observaciones</label>
        <div class="col-md-8">
          <textarea type="text" class="form-control" name="observaciones"></textarea>
        </div>
     </div>        

  <hr>
     <div class="form-group">
      <label class="control-label  col-sm-2">Nro Expediente (TSJ)</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="nro_expediente" value=""></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Orden de Pago (TSJ)</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="orden_pago" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Cheque</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="nro_cheque" value=""></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Importe</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="importe_cheque"></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Emisi&oacute;n</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="fecha_emision"  value="">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-2">Observaciones</label>
        <div class="col-md-8">
          <textarea type="text" class="form-control" name="observaciones_cheque"></textarea>
        </div>
     </div> 
    <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2">Nro de Recibo</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="" name="nro_recibo" value="">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Entrega</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="pc_fecha_retiro" name="fecha_retiro" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Retirado Por</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="retirado_por" value="">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">DNI Retirado Por:</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="dni_retira" value="">
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-md-2">Entregado Por</label>
        <div class="col-md-6">
          <select class="form-control select2" name="entregado_por_id">
          <option value="0" selected>-</option>
          @foreach($entregado_por as $key=>$agente) <!-- entregado_por es un listado de agentes (lo saco de la tabla agente)-->
          <option value="{{$agente->agente_id}}" >{{$agente->agente_nombre}}</option>
          @endforeach  
          </select>
        </div>
    </div> 

<hr>


    

    <div class="form-group"> 
            <div class="col-md-12 col-md-offset-2">
              <button type="submit" class="btn btn-default" id="c_alta_pago_cheque">Guardar</button>
              <a href="{{action('ChequesController@listPagoCheques')}}" class="btn btn-default">Cancelar</a>
              <a target="_target" href="#" class="btn btn-default">Imprimir Comprobante</a>
            </div>
    </div>
  </div>
</form>
</div> <!-- panel body -->

<script>

 function formatRepoActividad (repo) {
  console.debug(repo);
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
      "<div class='select2-result-repository__forks'><b>Fecha Inicio:</b> " + repo.fecha + "</div>" +
      "<div class='select2-result-repository__forks'><b>Subgrupo:</b> " + repo.subgrupo + "</div>" +
      "<div class='select2-result-repository__forks'><b>Destinatarios:</b> " + repo.destinatarios + "</div>" +
      "</div>" +
      "</div></div>";

      return markup;
    }



 function formatRepoMemo (repo) {
  console.debug(repo);
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
      "<div class='select2-result-repository__forks'><b>Fecha:</b> " + repo.fecha + "</div>" +
      "</div>" +
      "</div></div>";

      return markup;
    }

 function formatRepoDocente (repo) {
  //console.debug(repo);
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" +repo.name + "</div>";

      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
      "</div>" +
      "</div></div>";

      return markup;
    }


    function formatRepoSelection (repo) {
      return repo.name || repo.text;
    }

$(document).ready(function() {



            $('#a_form_alta').submit(function(){
              
              $('#c_alta_pago_cheque').attr('disabled',true);

            });

              $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                  }
                );

 
                 $("#b_docente_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "./traeDataDocente",
                                        dataType: 'json',
                                        delay: 250,
                                        data: function (params) {
                                          return {
                                            q: params.term, // search term
                                            page: params.page
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
                                      templateResult: formatRepoDocente, 
                                      templateSelection: formatRepoSelection
                });
                
                $("#b_nro_memo_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "./traeDataMemo",
                                        dataType: 'json',
                                        delay: 250,
                                        data: function (params) {
                                          return {
                                            q: params.term, // search term
                                            page: params.page
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
                                      minimumInputLength: 1,
                                      templateResult: formatRepoMemo,
                                      templateSelection: formatRepoSelection
                });  


                $("#b_curso_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "./traeDataCurso",
                                        dataType: 'json',
                                        delay: 250,
                                        data: function (params) {
                                          return {
                                            q: params.term, // search term
                                            page: params.page
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
                                      templateResult: formatRepoActividad,
                                      templateSelection: formatRepoSelection
                });


             
});
</script>

@stop
