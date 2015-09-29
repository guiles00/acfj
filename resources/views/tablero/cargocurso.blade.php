@extends('app')

@section('content')

<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
   Tablero de Control - Centro de formaci&oacute;n Judicial
   </div>
  <div class="panel-body">
  <div class="row">
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $dat)
              <tr>
              <td> {{$dat->usi_nombre}}</td>
              <td>{{$dat->usi_email}}</td>
              </tr>
            @endforeach
            </tbody>
            </table>
<a href="{!! URL::action('TableroController@cursoCargo', array('curso_id'=>$curso_id)); !!}">Volver</a> 
  </div>
</div>
</div>
</div>
<!--/div-->
@stop

  