@extends('app')

@section('content')

<div class="panel panel-default">
Exito!!
<a href="{!! URL::action('AlumnosController@index'); !!}">Volver</a>

</div>
@stop