@extends('app')

@section('content')
<?php 
use App\domain\Utils;
$helper = new App\Domain\Helper();
?>
  <!--div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listado</h1>
                </div>
                <!-- /.col-lg-12 -->
      <!--/div-->
<div class="panel panel-default">
 <div class="panel-heading">
 
     <div class="row panel-body">
      
        <p class="pull-left">Total Registros: {{$becas->count()}}</p>  

        <!--a href="#" class="btn glyphicon glyphicon-search pull-left" data-toggle="modal" data-target="#basicModal"> Búsqueda</a-->
         <a href="#" class="btn glyphicon glyphicon-search pull-right" data-toggle="modal" data-target="#basicModal"></a>
         <form method="GET" action="{{action('BecaController@index')}}" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
                  <div class="form-group">      
                    <div class="col-md-4">
                          <select class="form-control" name="estado_id" id="estado_id">
                                <option value="-1">-</option>
                                <!--option value="0">CONFIRMAR EMAIL</option-->
                                <option value="1">PENDIENTE</option>
                                <option value="2">INCOMPLETO</option>
                                <option value="3">COMPLETO</option>
                          </select> 
                    </div>        
                  </div> 
                  <div class="form-group">
                    <input type="text" class="form-control" name="str_beca" placeholder="" id="search_beca">
                    <button type="submit" class="btn btn-default" id="buscar_solicitud_beca">Buscar</button>
                  </div>   
         </div>
        </form>
    </div>
</div>

<!-- Modal Busqueda Avanzada-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title" id="myModalLabel">B&uacute;squeda de Actuaciones</h4>
            </div>
            <form method="GET" action="{!! URL::action('BecaController@busquedaAvanzada'); !!}" role="search">

                <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">A&ntilde;o</label>

                <div class="col-md-8">
                    <select class="form-control" name="anio">
                      <option value="">-</option>
                      <option value="2016">2016</option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                    </select>
                </div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Tipo</label>

                <div class="col-md-8">
                    <select class="form-control" name="tipo_beca_id">
                      <option value="">-</option>
                      @foreach($helpers['tipo_beca'] as $key=>$t_beca)
                      <option value="{{$t_beca->dominio_id}}">{{$t_beca->nombre}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Estado</label>
                <div class="col-md-8">
                   <select class="form-control" name="estado_id" >
                      <option value="">-</option>
                      @foreach($helpers['estado_beca'] as $key=>$t_beca)
                      <option value="{{$t_beca->dominio_id}}">{{$t_beca->nombre}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
            </div>  
            <br>
            <div class="row"> 
              <div class="form-group">
                <label class="control-label col-md-2">Renovaci&oacute;n</label>
                <div class="col-md-8">
                  <select class="form-control" name="renovacion_id" >
                      <option value="">-</option>
                      @foreach($helpers['renovacion'] as $key=>$t_beca)
                      <option value="{{$t_beca->dominio_id}}">{{$t_beca->nombre}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
            </div> 
        </div>
      </div>

                </div>
                <div class="modal-footer">
             
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" >Buscar</button>
             
            </div>
         </form>
    </div>
  </div>
</div>

<!-- -->


<div class="panel-body">

    <div class="table-responsive">
      <?php $total = count($becas);?>
        <table class="table table-responsive table-striped table-bordered table-hover" id="beca">
            <thead>
                <tr>
                   <th><a href="#" class="btn glyphicon glyphicon-search" data-toggle="modal" data-target="#basicModal"></a></th>
                   <th>Fecha</th>
                   <!--th>beca_id</th-->
                   <th>Tipo</th>
                   <th>Nombre</th>
                   <th>Costo</th>
                   <th>Solicitado</th>
                   <th>Otorgado</th>
                   <th>Renovaci&oacute;n</th>
                   <th>estado</th>
                   <th></th>
                   
               </tr>
           </thead>
           <tbody>
            
            @foreach ($becas as $beca)
            
            <tr>
                <td> {{ $total-- }} </td>
                <td> {{ Utils::formatDate($beca->timestamp) }} </td>
                <!--td> {{ $beca->beca_id}} </td-->
                <td> {{ $helper->getHelperByDominioAndId('tipo_beca',$beca->tipo_beca_id)  }} </td>
                <td> {{ $beca->usi_nombre}} </td>
                <td> {{ $beca->costo}} </td>
                <td> {{ $beca->monto}} </td>
                <td> {{ '00.00' }}</td>
                <td> {{ $helper->getHelperByDominioAndId('renovacion',$beca->renovacion_id)  }} </td>
                <td> {{ $beca->estado_beca}} </td>
                <td> <a href="{{action('BecaController@verSolicitud',$beca->beca_id)}}">Ver</a></td>
                <!--td> <a href="{{action('BecaController@verDocAdjunta',$beca->beca_id)}}">...</a></td-->
            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<div>
 <a href="{{action('BecaController@exportar')}}">Exportar a Excel</a>
</div>

<?php echo $becas->render(); ?>


<div id="res"></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {

            /*
              $('#search_beca').on('change keyup paste', function(d) {
                

                  console.log('I am pretty sure the text box changed');
                  //alert('okaaasasasa');
                  console.debug(d.target.value);
                  $.ajax({
                          url: 'http://localhost/content/cfj-cfj/admin_cfj/public/alumnos',
                          data: {'data':d.target.value},
                          success: function(data){
                           // console.debug(data);
                          //  $('#res').html(data);
                          }
                          //dataType: dataType
                        });

                });
              */
              $('#search_beca').on('change', function(d) {
                //alert('change');

                $('#buscar_solicitud_beca').click();

                });

              $('#estado_id').on('change', function(d) {
                //alert('change');
                console.debug($('#estado_id').val());
                $('#buscar_solicitud_beca').click();

                });

            });
</script>
@stop