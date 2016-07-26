@extends('app')

@section('content')

<? use App\domain\Actuacion;
?>
<!--div class="container"-->
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
    <li class="active">Alta Cheque (Beca)</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ChequesController@listPagoBecaCheques')}}"></a>
		</div>

    <div class="alert alert-success alert-dismissable" style="display:none" id="a_alert_esta">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>QUE DATOS VAN ACA</b>
    </div>

  <div class="panel-body">
	 
    <!--   [curso_id] => 1
                                    [docente_id] => 1
                                    [nro_cheque] => 1
                                    [nro_expediente] => 1
                                    [orden_pago] => 1
                                    [importe] => 1000
                                    [fecha_retiro] => 2016-06-21 00:00:00
                                    [retirado_por] => pepe
                                    [entregado_por_id] => 1
                                    [nro_meno_id] => 2
                                    [aprobado_por] => resoluciÃ³n nro XXXX
                                    [timestamp] => 2016-06-21 14:22:08

Disposicion que otorga
Disposicion que aprueba
Importe / Reintegro
Nro de Memo


Nro Expediente
Nro Orden de Pago
Nro de Cheque
Fecha emision cheque

Fecha Entrega
Retirado Por
Entregado Por

-->
 	<form class="form-horizontal" role="form" method="POST" action="{{action('ChequesController@storePagoBecaCheque')}}" id="a_form_alta">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />


  <div class="form-group">
      <label class=" col-sm-12">DATOS REINTEGRO</label>
      </div>
<hr>
    <div class="form-group">
      <label class="control-label  col-sm-2" >Beneficiario</label>    
      <div class="col-sm-6">
         <select class="form-control remote_select2 js-data-example-ajax" name="beca_id" id="b_beca_id" required>
            <option value="" selected></option>
         </select>
      </div>
    </div>
  

	  <div class="form-group">
      <label class="control-label col-sm-2">Nro Disposici&oacute;n Beca</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="b_nro_disp_otorga" name="nro_disp_otorga" value=""></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Nro Disposici&oacute;n Pago</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="nro_disp_aprueba"></input>
      </div>
    </div>

     <div class="form-group">
      <label class="control-label  col-sm-2">Reintegro Nro</label>
      <div class="col-sm-6">          
        <input type="number" class="form-control" id="" name="numero_reintegro"></input>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label  col-sm-2">Monto</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="importe"></input>
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
    <!--div class="form-group">
      <label class=" col-sm-8">Mas Datos ...</label>
   </div-->
  <hr>
     <div class="form-group">
      <label class="control-label  col-sm-2">Nro Expediente (TSJ)</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="nro_expediente"></input>
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
        <input type="text" class="form-control" id="" name="nro_cheque"></input>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Emisi&oacute;n</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" placeholder="YY-mm-dd" name="fecha_emision" value="">
      </div>
    </div>

    <!--div class="form-group">
      <label class=" col-sm-8 pull-left">Mas Datos ...</label>
    </div-->
    <hr>
    
    <div class="form-group">
      <label class="control-label  col-sm-2">Fecha Entrega</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" placeholder="YY-mm-dd" name="fecha_retiro" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label  col-sm-2">Retirado Por:</label>
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
						</div>
		</div>
	</div>
</form>
</div> <!-- panel body -->

<script>

 function formatRepo (repo) {
//  console.debug(repo);



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

      //Actualizo nro de disposicion 

      $('#b_nro_disp_otorga').val(repo.nro_disposicion);

      return repo.full_name || repo.text;
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
              $('.datepicker').datepicker('setDate', new Date());
              $('.datepicker').datepicker('update');
              $('.datepicker').val('');
              

                 $("#b_beca_id").select2({
                                      ajax: {
                                      //  url: "https://api.github.com/search/repositories",
                                        url: "./traeDataBeca",
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
