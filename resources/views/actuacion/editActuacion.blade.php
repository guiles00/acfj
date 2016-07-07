@extends('app')

@section('content')

<?php 
$codigos_actuacion = ["0"=>"","BEC"=>"BEC","CAP"=>"CAP","CNV"=>"CNV","ADM"=>"ADM"];
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
    <li>Mesa de Entrada</li>
    <li class="active">Editar Actuaci&oacute;n</li>
</ul>
<div class="panel panel-default">
	<div class="panel-heading">
			<a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('ActuacionController@listActuacion')}}" ></a>
	</div>

  <div class="panel-body">
    <?php if(isset($edited)){?>
        <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Actuaci&oacute;n Editada!</b>
            </div>
  <?php } ?>  
	  
 	<form class="form-horizontal" role="form" method="POST" action="{{action('ActuacionController@update')}}">
	  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
    <input type="hidden" name="_id" value="{{$actuacion->actuacion_id}}" />


	  <div class="form-group">
      <label class="control-label col-sm-2" >C&oacute;digo de Actuaci&oacute;n:</label>
      <div class="col-sm-2">
        
         <select class="form-control" name="codigo_actuacion">
                @foreach($codigos_actuacion as $key=>$codigo)
                      <?php if( $actuacion->prefijo == $codigo ){?>
                      <option value="{{$codigo}}" selected>{{$codigo}}</option>
                      <?php }else{?>
                      <option value="{{$codigo}}">{{$codigo}}</option>
                      <?php }?>
                      @endforeach
            </select>



      </div>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="" name="nro_actuacion" value="{{$actuacion->numero_actuacion}}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Fecha</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="actuacion_fecha" value="{{$actuacion->actuacion_fecha}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Asunto</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="actuacion_asunto">{{$actuacion->asunto}}</textarea>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2">Dirigido</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_dirigido" value="{{$actuacion->dirigido}}">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label  col-md-2">Asignaci&oacute;n Inicial</label>
        <div class="col-md-6">
          <select class="form-control select2" name="area_destino_id" id="a_area_destino_id">
          <option value="0">-</option>
          @foreach($area_cfj as $key=>$area)
            <?php if( $area->area_cfj_id == $actuacion->area_destino_id ){?>
            <option value="{{$area->area_cfj_id}}" selected>{{$area->area_nombre}} ( {{$area->area_responsable}} )</option>
            <?}else{?>
            <option value="{{$area->area_cfj_id}}">{{$area->area_nombre}} ( {{$area->area_responsable}} )</option>
            <?}?>
          @endforeach
          </select>
        </div>
    </div>  

    <div class="form-group">
      <label class="control-label col-sm-2">Causante</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_remite" value="{{$actuacion->remite}}">
      </div>
    </div>
    
    <!--div class="form-group">
      <label class="control-label col-sm-2">Recibi&oacute;</label>
      <div class="col-sm-6">          
        <input type="text" class="form-control" id="" name="actuacion_conste" value="{{$actuacion->conste}}">
      </div>
    </div-->

       <div class="form-group">
      <label class="control-label col-md-2">Recibi&oacute;</label>
        <div class="col-md-4">
          <select class="form-control select2" name="conste_agente_id">
          <option value="0">-</option>
          @foreach($conste_agente as $key=>$agente)
          <? if($actuacion->conste_agente_id == $agente->agente_id){?>
          <option value="{{$agente->agente_id}}" selected>{{$agente->agente_nombre}}</option>
          <?}else{?>
          <option value="{{$agente->agente_id}}">{{$agente->agente_nombre}}</option>
          <?}?>
          @endforeach
          </select>
        </div>
    </div>  
    
    <div class="form-group">
      <label class="control-label col-sm-2">Fojas</label>
      <div class="col-sm-2">          
        <input type="number" class="form-control" id="" name="actuacion_fojas" value="{{$actuacion->fojas}}">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Observaciones</label>
      <div class="col-sm-8">          
        <textarea type="text" class="form-control" id="" name="actuacion_observaciones">{{$actuacion->observaciones}}</textarea>
      </div>
    </div>

  <div class="form-group">
      <label class="control-label col-md-2">Archivo</label>
        <div class="col-md-4">
          <select class="form-control" name="archivo_actuacion_id">
            @foreach($archivo_actuacion as $key=>$archivo)
            <?php if( $archivo->archivo_actuacion_id == $actuacion->archivo_actuacion_id ){?>
            <option value="{{$archivo->archivo_actuacion_id}}" selected>{{$archivo->nombre_archivo}}</option>
            <?php }else{?>
            <option value="{{$archivo->archivo_actuacion_id}}">{{$archivo->nombre_archivo}}</option>
            <?php }?>
            @endforeach
          </select>
        </div>
    </div>
    
    <!--div class="form-group">
      <label class="control-label col-sm-2">Estado(Solo prueba)</label>
      <div class="col-sm-6">          
          <select class="form-control" name="estado_actuacion_id">
            <option value="1" selected>RECIBIDA</option>
            <option value="2">REMITIDA</option>
            </select>
      </div>
    </div-->
<!-- ########## TABS ########## -->
<!--
<ul class="nav nav-tabs" >
  <li class="active" ><a data-toggle="tab" href="#pases">Movimientos</a></li>
</ul>
<div class="tab-content">

<div id="pases" class="tab-pane fade active in">
         <table class="table table-condensed table-bordered table-striped volumes">
          <thead>
            <tr>
              <th>FECHA</th>
              <th>Nro Mov. /Pase</th>
                <th>ORIGEN</th>
                <th>DESTINO</th>  
                <th>RECIBIDO</th>
              <th width="10%"></th>
            </tr>
          </thead>
          <tbody>


            <tr>
                <td> 01/01/2016</td>
                <td> 10</td>
                <td> MEI-CFJ</td>
                <td> Departamento Becas</td>
                <td> SI</td>
                
                <td> 
                  <a href="" onClick="return confirm('desea ver?')" >Ver</a>
                  <a href="" onClick="return confirm('desea eliminar?')" >Eliminar</a>
                </td>

            </tr>
            <tr>
                <td> 01/01/2016</td>
                <td> 10</td>
                <td> Deptaramento Becas</td>
                <td> Karina Galrraga</td>
                <td> SI</td>
                
                <td> 
                  <a href="" onClick="return confirm('desea ver?')" >Ver</a>
                  <a href="" onClick="return confirm('desea eliminar?')" >Eliminar</a>
                </td>

            </tr>

          </tbody>
        </table>

        <div class="col-sm-12">
        <div class="row">
          <div class="form-group"> 
            <div class="col-md-10">
              <a href="" class="btn btn-default">Agregar Movimiento</a>
            </div>
          </div>
        </div>
      </div>

  </div>

-->
<!-- ########## END TABS ########## -->

    <div class="form-group"> 
						<div class="col-md-12 col-md-offset-2">
							<button type="submit" class="btn btn-default" id="">Guardar</button>
							<a href="{{action('ActuacionController@listActuacion')}}" class="btn btn-default">Volver</a>
						</div>
		</div>
	</div>
</form>

</div> <!-- panel body -->
<script>



$('document').ready(function(){
	 
    $('.datepicker').datepicker({
              format: 'yyyy-mm-dd'
              ,language:'es'
              ,autoclose: true}
    );
});

</script>
@stop
