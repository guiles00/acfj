@extends('app')

@section('content')
 <ul class="breadcrumb">
    <li>Administraci&oacute;n</li>
    <li class="active">Ver Men&uacute;</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
         <a <a class="btn btn-default glyphicon glyphicon-arrow-left" href="{{action('MenuController@listMenu')}}" ></a>
</div>

<div class="panel-body">
    <?php if(isset($edited)){?>
        <div class="alert alert-success alert-dismissable">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <b>Menu Editado!</b>
            </div>
    <?php } ?> 

<form class="form-horizontal" role="form" method="POST" action="{{action('MenuController@add')}}" id="b_form_menu">
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

    <div class="form-group">
      <label class="control-label col-sm-2">Padre</label>
      <div class="col-sm-8">          
        <select class="form-control" name="menu_padre_id" id="m_padre_id">
          <option value="0">-</option>
          @foreach($menu_padre as $key=>$menu)
          <option value="{{$menu->menu_id}}">{{$menu->menu}}</option>
          @endforeach
          </select>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Menu</label>
      <div class="col-sm-2">          
        <input type="text" class="form-control datepicker" id="" name="menu_nombre" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">URL</label>
      <div class="col-sm-8">          
        <input type="text" class="form-control" id="" name="menu_url" value="">
      </div>
    </div>
    
    
    <div class="form-group"> 
            <div class="col-md-12 col-md-offset-2">
              <button type="submit" class="btn btn-default" id="b_save_usuario">Guardar</button>
              <a href="{{action('MenuController@listMenu')}}" class="btn btn-default">Volver</a>
            </div>
    </div>
  
</form>
<div id='b_user_result'>
</div>
</div>
</div>

<script type="text/javascript">
$('document').ready(function(){

});
</script>
@stop