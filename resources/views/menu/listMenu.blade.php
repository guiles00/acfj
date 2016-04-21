@extends('app')

@section('content')
 <ul class="breadcrumb">
    <li>Administraci&oacute;n</li>
    <li class="active">Listar Menu</li>
</ul>
<div class="panel panel-default">
 <div class="panel-heading">
    <div class="form-group pull-left">
                <a class="btn btn-default pull-left" href="{!! URL::action('MenuController@altaMenu'); !!}" aria-label="Left Align">Agregar Men&uacute;</a><!--/button-->
      </div>
     <div class="row">
         <a href="#" class="btn glyphicon glyphicon-search pull-right" data-toggle="modal" data-target="#basicModal"></a>
         <form method="GET" action="" class="navbar-form navbar-left pull-right" role="search">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
                  <div class="form-group">
                    <input type="text" class="form-control" name="str_perfil" placeholder="" id="search_pefil">
                    <button type="submit" class="btn btn-default" id="buscar_perfil">Buscar</button>
                  </div>   
         </div>
        </form>
    </div>
</div>

<div class="panel-body">

    <div class="table-responsive">

        <table class="table table-responsive table-striped table-bordered table-hover" id="perfil">
            <thead>
                <tr>
                   <th>ID</th>
                   <th>Nombre</th>
                   <th>URL</th>
                   <th></th>                   
               </tr>
           </thead>
           <tbody>
            
            @foreach ($menues as $menu)
            
            <tr>
                <td> {{ $menu->menu_id}} </td>
                <td> {{ $menu->menu}} </td>
                <td> {{ $menu->url}} </td>
               <td> <a href="{!! URL::action('MenuController@edit',$menu->menu_id); !!}">Ver</a></td>

            </tr>
            @endforeach    
        </tbody>
    </table>
  </div>

<div id="res"></div>
</div>
</div>
<script type="text/javascript">

</script>
@stop