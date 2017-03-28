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
    <li class="active">Editar Pago/Cheque (Beca)</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<!--a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ChequesController@listPagoBecaCheques')}}"></a-->
      <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{!! URL::previous(); !!}"></a>

		</div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="a_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>QUE DATOS VAN ACA</b>
    </div>

  <div class="panel-body">

 	<form class="form-horizontal" role="form" method="POST" action="{{action('ChequesController@updatePagoBecaCheque')}}" id="a_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$pago_cheque->pago_cheque_id}}" />


  <div class="form-group">
      <label class=" col-sm-12">DATOS REINTEGRO</label>
      </div>
  <hr>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Beneficiario</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="beca_id" id="b_beca_id">
            <option value="{{$becario->beca_id}}" selected>{{$becario->usi_nombre}}</option>  
         </select>
      </div>
    </div>

	  <div class="form-group">
      <label class="control-label col-sm-2">Nro Disposici&oacute;n Beca</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_otorga" value="{{$pago_cheque->nro_disp_otorga}}"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Disposici&oacute;n Pago</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_aprueba" value="{{$pago_cheque->nro_disp_aprueba}}"></input>
      </div>
    </div>
        <div class="form-group">
      <label class="control-label  col-sm-2">Reintegro Nro</label>
      <div class="col-sm-6">          
        <input type="number" class="form-control" id="" name="numero_reintegro" value="{{$pago_cheque->numero_reintegro}}"></input>
      </div>
    </div>

     <div class="form-group">
      <label class="control-label  col-sm-2">Monto</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="importe" value="{{$pago_cheque->importe}}"></input>
      </div>
    </div>


     <div class="form-group">
      <label class="control-label col-md-2">Nro. Memo</label>
        <div class="col-md-6">
          <? if(!empty($pago_cheque->nro_memo_id))
          $nro_memo = PagoCheque::getMemoById($pago_cheque->nro_memo_id) 
          ?>
          <select class="form-control remote_select2 js-data-example-ajax" name="nro_memo_id" id="b_nro_memo_id">
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
      <label class="control-label  col-sm-2">Fecha Emisi&oacute;n</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="fecha_emision"  value="{{$pago_cheque->fecha_emision}}">
      </div>
    </div>

    <!--div class="form-group">
      <label class=" col-sm-8 pull-left">Mas Datos ...</label>
    </div-->
    <hr>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Entrega</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="fecha_retiro" value="{{$pago_cheque->fecha_retiro}}">
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
							<a href="{{action('ChequesController@listPagoBecaCheques')}}" class="btn btn-default">Volver</a>
              <a target="_target" href="{{action('ChequesController@imprimirComprobanteBeca',$pago_cheque->pago_cheque_id)}}" class="btn btn-default">Imprimir Comprobante</a>
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
          "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

      /*if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
      }*/

      markup += "<div class='select2-result-repository__statistics'>" +
      "<div class='select2-result-repository__forks'>" + repo.fecha + "</div>" +
      "</div>" +
      "</div></div>";

      return markup;
    }

    function formatRepoSelection (repo) {
      return repo.full_name || repo.text;
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
              

                 $("#b_beca_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "../traeDataBeca",
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
                                      templateResult: formatRepo, // omitted for brevity, see the source of this page
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
                                      templateResult: formatRepo, // omitted for brevity, see the source of this page
                                      templateSelection: formatRepoSelection
                });  




          /*    $('#a_numero_actuacion').on('change', function(d) {
              
               //alert('busco');
                var numero_actuacion = $('#a_numero_actuacion').val();
               // return false;
              
               $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroActuacion',
                          data: {'numero_actuacion':numero_actuacion},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#a_alert_esta').hide();
                              $('#a_alta_actuacion').removeAttr('disabled');
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#a_alert_esta').show();
                              $('#a_alta_actuacion').attr('disabled','disabled');
                            }
                          }
                        });
                });
*/
     /*       $("#a_form_alta").submit(function(e) {
                 var self = this;
                 e.preventDefault();
                 
                 //Chequeo que el numero no este en la base

               var numero_actuacion = $('#a_numero_actuacion').val();
               
                $.ajax({
                          //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/programas',
                          url: './getNumeroActuacion',
                          data: {'numero_actuacion':numero_actuacion},
                          success: function(data){
                            //$('#res').html(data);

                            if(data == 'false'){
                              $('#a_alert_esta').hide();
                            //  $('#a_alta_actuacion').removeAttr('disabled');
                              self.submit();
                            }else{
                              //alert('El número de actuación ya existe');
                              $('#a_alert_esta').show();
                             // $('#a_alta_actuacion').attr('disabled','disabled');
                            }
                           
                          }
                        });

                 return false; //is superfluous, but I put it here as a fallback
            });
  */
            //Esta harcodeado para ver si es asi como deberia funcionar
            //Las constantes BEC,ADM,CAP y CNV las dejo
            // Traer de la base (SI ES NECESARIO) las relaciones entre codigo y area 
         /*   $("#a_codigo_actuacion").on('change', function(d) {

              var codigo_actuacion = $("#a_codigo_actuacion").val();
               
               if( codigo_actuacion == 'BEC' || codigo_actuacion == 'CNV' ){
                $("#a_area_destino_id").val(3).change();;     
               }

               if( codigo_actuacion == 'ADM' || codigo_actuacion == 'CAP' ){
                $("#a_area_destino_id").val(4).change();;     
               }

               if( codigo_actuacion == '' ){
                $("#a_area_destino_id").val(0).change();;     
               }                

            });*/

});
</script>

@stop
