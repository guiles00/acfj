@extends('app')
@section('content')
<h3>Create Hobbits/Dwarfs</h3>
<form method="POST" action="{{action('DwarfController@store')}}" accept-charset="UTF-8">
<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
Nombre<input name="nombre" value=""> </input>
Apellido<input name="apellido" value=""> </input>
Comarca<select name="comarca_id"> 
<option value=1>Norte</option>
<option value=2>Sur</option>
<option value=3>Este</option>
<option value=4>Oeste</option>
</select>
<input type="submit" value="submit"></input>
</form>
@stop
