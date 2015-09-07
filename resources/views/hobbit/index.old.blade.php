@extends('app')

@section('content')

<div class="container">
<div class="panel panel-default">
   <div class="panel-heading">
    <button type="button" class="btn btn-default" aria-label="Left Align">
	  <a href="{{action('DwarfController@create')}}" class="glyphicon glyphicon-plus" ></a>
	 
 	 	<!--span class="glyphicon glyphicon-plus" aria-hidden="true"></span-->
	</button>
	Hobbits of riverdanle
	</div>

  <div class="panel-body">
@foreach ($hobbits as $hobbit)
<div class="row">

<div class="col-md-3">	
<a href="{{action('DwarfController@show',[$hobbit->id])}}"> {{ $hobbit->nombre}}</a>
</div>
<div class="col-md-3">	
<a href="{{action('DwarfController@show',[$hobbit->id])}}"> {{ $hobbit->nombre}}</a>
</div>
<div class="col-md-1">	
<a href="{{action('DwarfController@show',[$hobbit->id])}}"> {{ $hobbit->nombre}}</a>
</div>
<div class="col-md-1">
</div>
<div class="col-md-1">
{{ $hobbit->apellido}}
</div>
</div>
@endforeach
</div>
</div></div>
@stop
<!--{ \App\Comarca::find($hobbit->comarca_id)->comarca }-->
