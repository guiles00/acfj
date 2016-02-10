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
     <div class="row">      
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

<div class="panel-body">

    <div class="table-responsive">
      <?php $total = count($becas);?>
        <table class="table table-responsive table-striped table-bordered table-hover" id="beca">
            <thead>
                <tr>
                   <th></th>
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