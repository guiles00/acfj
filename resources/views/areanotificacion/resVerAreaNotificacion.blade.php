<div>

	<div class="table-responsive">

        <table class="table table-responsive table-striped table-bordered table-hover" id="areas">
            <thead>
                <tr>
                   <th>Area</th>
                   <th>Responsable</th>
                </tr>
           </thead>
           <tbody>
            
            <tr>
                <td> {{$area_cfj->area_nombre}}</td>
                <td> {{$area_cfj->area_responsable}} </td>
            </tr>

        </tbody>
    </table>
</div>

      <div class="row">
            <div class="col-md-8">
              <a href="#" class="btn btn-default">Agregar</a>
            </div>
      </div>

  <div class="table-responsive">  
    <table class="table table-responsive table-striped table-bordered table-hover" id="emails_areas">
            <thead>
                <tr>
                   <th>Nombre</th>
                   <th>Email</th>
                   <th></th>
                </tr>
           </thead>
           <tbody>
            @foreach ($notificacion_cfj as $notificacion) 
            <tr>
                <td>{{$notificacion->agente_nombre}}</td>
                <td>{{$notificacion->agente_email}}</td>
                <td><a href="#" class="btn btn-default">Eliminar</a></td>
            </tr>
            @endforeach    
        </tbody>
    </table>

  </div>

</div>