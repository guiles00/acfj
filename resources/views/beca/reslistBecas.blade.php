  <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listado</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
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
                                <option value="0">CONFIRMAR EMAIL</option>
                                <option value="1">PENDIENTE</option>
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
        <table class="table table-responsive table-striped table-bordered table-hover" id="beca">
            <thead>
                <tr>
                   <th>fecha</th>
                   <th>beca_id</th>
                   <th>tipo_beca_id</th>
                   <th>Nombre</th>
                   <th>Monto</th>
                   <th>estado</th>
                   <th></th>
                   <th></th>
               </tr>
           </thead>
           <tbody>
            @foreach ($becas as $beca)
            <tr>
                <td> {{ $beca->timestamp}} </td>
                <td> {{ $beca->beca_id}} </td>
                <td> {{ $beca->tipo_beca_id}} </td>
                <td> {{ $beca->usi_nombre}} </td>
                <td> {{ $beca->monto}} </td>
                <td> {{ $beca->estado_beca}} </td>
                <td> <a href="{{action('BecaController@verSolicitud',$beca->beca_id)}}">Ver</a></td>
                <td> <a href="{{action('BecaController@verDocAdjunta',$beca->beca_id)}}">Doc. Adjunta</a></td>
            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>
<?php echo $becas->render(); ?>
</div>
