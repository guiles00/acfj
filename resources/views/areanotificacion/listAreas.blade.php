@extends('app')

@section('content')
 <ul class="breadcrumb">
    <li>Administraci&oacute;n</li>
    <li class="active">Areas Notificaci&oacute;n</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">

       <a <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('AreaNotificacionController@listAreas')}}" ></a>
</div>


<div class="panel-body">

<div id="resAreaNotificacion">

    <div class="table-responsive">

        <table class="table table-responsive table-striped table-bordered table-hover" id="areas">
            <thead>
                <tr>
                   <th>Area</th>
                   <th>Responsable</th>
                   <th></th>                   
               </tr>
           </thead>
           <tbody>
            
            @foreach ($area_cfj as $area)
            
            <tr>
                <td> {{ $area->area_nombre}} </td>
                <td> {{ $area->area_responsable}} </td>
                <td> <a href="#" id="{{$area->area_cfj_id}}" class="btn btn-default verNotificacion" >Ver</a> <!--input type="button" class="verNotificacion" value="Ver"></input--></td>

            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>


  </div>
</div>
</div>
<script type="text/javascript">
    $('.verNotificacion').click(function(e){
        e.preventDefault();
        //console.debug(e.target);
        
        var id = e.target.id;
        //console.debug(id);
        
           $.ajax({
                          url:'./verAreaNotificacion'
                          ,data: {'id':id}
                          ,success: function(data){
                            $('#resAreaNotificacion').html(data);
                          }
            });


    });
</script>
@stop