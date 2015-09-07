@extends('app')

@section('content')

<div class="container">
<div class="panel panel-default">
   <div class="panel-heading">
	becas of riverdanle
	</div>

  <div class="panel-body">
@foreach ($becas as $beca)
<div class="row">

<div class="col-md-4">	
<a href="{{action('DwarfController@show',[$beca->id])}}"> {{ $beca->alumno_id}}</a>
</div>
<div class="col-md-4">	
<a href="{{action('DwarfController@show',[$beca->id])}}"> {{ $beca->alumno_id}}</a>
</div>
<div class="col-md-2">	
<a href="{{action('DwarfController@show',[$beca->id])}}"> {{ $beca->alumno_id}}</a>
</div>
<div class="col-md-1">
</div>
<div class="col-md-1">

</div>
</div>
@endforeach
</div>
</div></div>
@stop