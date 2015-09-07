@extends('app')

@section('content')

<div class="container">
<div class="panel panel-default">
   <div class="panel-heading">
	becas of riverdanle
	</div>

 <div class="panel-body">
<svg class="chart"></svg>

</div>
</div></div>

{!! Html::script('d3.js') !!}
{!! Html::script('test.js') !!}

@stop