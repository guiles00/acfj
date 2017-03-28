@extends('app')

@section('content')
<?php
use App\domain\PagoCheque;
?>
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
    <li class="active">Editar Pago/Cheque (Curso)</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<!--a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ChequesController@listPagoCheques')}}"></a-->
      <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{!! URL::previous(); !!}"></a>
      <span style="color:red">Atenci&oacute;n, el &uacute;timo n&uacute;mero de recibo registrado en el sistema es: {{$nro_recibo}}</span>
	</div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="a_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>QUE DATOS VAN ACA</b>
    </div>

  <div class="panel-body">

 	<form class="form-horizontal" role="form" method="POST" action="{{action('ChequesController@updateCursoPagoCheque')}}" id="a_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$pago_cheque->pago_cheque_id}}" />


  <div class="form-group">
      <label class=" col-sm-12"></label>
      </div>
  <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Capacitador</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="docente_id" id="b_docente_id">
             <option value="{{$docente->doc_id}}" selected>{{$docente->doc_apellido}}  {{$docente->doc_nombre}}</option> 
         </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Actividad</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="curso_id" id="b_curso_id">
             <option value="{{$curso->cur_id}}" selected>{{$curso->gcu3_titulo}}</option>
         </select>
      </div>
    </div>


	  <div class="form-group">
      <label class="control-label col-sm-2">Nro Disposici&oacute;n Fija Fecha</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_otorga" value="{{$pago_cheque->nro_disp_otorga}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Disposici&oacute;n Certificaci&oacute;n Pago</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_aprueba" value="{{$pago_cheque->nro_disp_aprueba}}"></input>
      </div>
    </div>
        

     <div class="form-group">
      <label class="control-label  col-sm-2">Monto Solicitiado</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="importe" value="{{$pago_cheque->importe}}"></input>
      </div>
    </div>


        <div class="form-group">
      <label class="control-label col-md-2">Nro. Memo</label>
        <div class="col-md-6">
          <? if(!empty($pago_cheque->nro_memo_id))
          $nro_memo = PagoCheque::getMemoById($pago_cheque->nro_memo_id);
          ?>
          <select class="form-control " name="nro_memo_id" id="b_nro_memo_id">
            <option value="{{$pago_cheque->nro_memo_id}}" selected>{{ $nro_memo }}</option>
            </select>
        </div>
     </div>
    <div class="form-group">
      <label class="control-label col-md-2">Disponible</label>
        <div class="col-md-6">
          <select class="form-control" name="disponible_id" id="b_disponible_id">
          @foreach($disponible as $key=>$disponible_id)
          <?php if( $pago_cheque->disponible_id == $disponible_id->dominio_id ){?>
          <option value="{{$disponible_id->dominio_id}}" selected>{{$disponible_id->nombre}}</option>
          <?php }else{?>
          <option value="{{$disponible_id->dominio_id}}">{{$disponible_id->nombre}}</option>
          <?php }?>
          @endforeach  
            </select>
        </div>
     </div>  
     <div class="form-group">
      <label class="control-label col-md-2">Observaciones</label>
        <div class="col-md-8">
          <textarea type="text" class="form-control" name="observaciones">{{$pago_cheque->observaciones}}</textarea>
        </div>
     </div>        
    <!--div class="form-group">
      <label class=" col-sm-8">Mas Datos ...</label>
   </div-->
  <hr>
     <div class="form-group">
      <label class="control-label  col-sm-2">Nro Expediente (TSJ)</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="nro_expediente" value="{{$pago_cheque->nro_expediente}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Orden de Pago (TSJ)</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="orden_pago" value="{{$pago_cheque->orden_pago}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Cheque</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="nro_cheque" value="{{$pago_cheque->nro_cheque}}"></input>
      </div>
    </div>
   <div class="form-group">
      <label class="control-label  col-sm-2">Importe</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="importe_cheque" value="{{$pago_cheque->importe_cheque}}"></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Emisi&oacute;n</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="fecha_emision"  value="{{$pago_cheque->fecha_emision}}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-2">Observaciones</label>
        <div class="col-md-8">
          <textarea type="text" class="form-control" name="observaciones_cheque">{{$pago_cheque->observaciones_cheque}}</textarea>
        </div>
     </div>
    <!--div class="form-group">
      <label class=" col-sm-8 pull-left">Mas Datos ...</label>
    </div-->
    <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2">Nro de Recibo</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control" id="pc_nro_recibo" name="nro_recibo" value="{{$pago_cheque->nro_recibo}}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Entrega</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="pc_fecha_retiro" name="fecha_retiro" value="{{$pago_cheque->fecha_retiro}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Retirado Por</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="retirado_por" value="{{$pago_cheque->retirado_por}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">DNI Retirado Por:</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="dni_retira" value="{{$pago_cheque->dni_retira}}">
      </div>
    </div>

   <div class="form-group">
      <label class="control-label col-md-2">Entregado Por</label>
        <div class="col-md-6">
          <select class="form-control select2" name="entregado_por_id">
          <option value="0">-</option>
          @foreach($entregado_por as $key=>$agente) <!-- entregado_por es un listado de agentes (lo saco de la tabla agente)-->
          <?php if( $agente->agente_id == $pago_cheque->entregado_por_id ){?>
          <option value="{{$agente->agente_id}}" selected>{{$agente->agente_nombre}}</option>
          <?php }else{?>
          <option value="{{$agente->agente_id}}">{{$agente->agente_nombre}}</option>
          <?php }?>
          @endforeach  
          </select>
        </div>
    </div> 

<hr>


    

    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="c_alta_pago_cheque">Guardar</button>
							<a href="{{action('ChequesController@listPagoCheques')}}" class="btn btn-default">Volver</a>
              <a target="_target" href="{{action('ChequesController@imprimirComprobanteCurso',$pago_cheque->pago_cheque_id)}}" class="btn btn-default">Imprimir Comprobante</a>
						</div>
		</div>
	</div>
</form>
</div> <!-- panel body -->

<script>

 function formatRepo (repo) {
  console.debug(repo);
      if (repo.loading) return repo.text;

      var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.name + "</div>";

      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
      "<div class='select2-result-repository__forks'>" + repo.fecha + "</div>" +
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


    function formatRepoSelection (repo) {
      return repo.name || repo.text;
    }

$(document).ready(function() {

              $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                    ,language:'es'
                    ,autoclose: true
                  }
                );

              /*$('.datepicker').datepicker('setDate', new Date());
              $('.datepicker').datepicker('update');
              $('.datepicker').val('');*/
              

                 $("#b_docente_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "../traeDataDocente",
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
                                      templateResult: formatRepoDocente, // omitted for brevity, see the source of this page
                                      templateSelection: formatRepoSelection
                });
                
                $("#b_nro_memo_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "../traeDataMemo",
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
                                      templateResult: formatRepoMemo, // omitted for brevity, see the source of this page
                                      templateSelection: formatRepoSelection
                });  

             $("#b_curso_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "../traeDataCurso",
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
                                      templateResult: formatRepoActividad, // omitted for brevity, see the source of this page
                                      templateSelection: formatRepoSelection
                });

    
            $('#pc_fecha_retiro').change(function(){
                 

                $.ajax({
                    url : "../traeUltimoNroRecibo"
                    ,method: 'GET'
                    ,success : function(result) {
                      var nro_recibo = parseInt(result) + 1;
                      $('#pc_nro_recibo').val(nro_recibo);
                    }
                  });


                 

            });


});
</script>

@stop
