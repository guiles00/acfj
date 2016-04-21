<?
use App\domain\Perfil;
?>
      <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
      <input type="hidden" name="" id="b_table_perfil_id" value="{{$perfil_id}}" ></input>

        <table class="table table-condensed table-bordered table-striped volumes" >
          <thead>
            <tr>
              <th>Nombre</th>
              <th>ACCEDE</th>
              <th width="10%"></th>
            </tr>
          </thead>
          <tbody>

           @foreach($menu_perfil as $key=>$menu)
            <tr id="<?=$menu->menu_id?>">
                <td> {{ $menu->menu }}</td>
                
                <? if(Perfil::hasAccess($perfil_id,$menu->menu_id)){ ?>
                <td id="<?='td'.$menu->menu_id?>"> SI </td>  
                <td> <a href="{!! URL::action('PerfilController@ajaxDeleteMenu'); !!}" onClick="return false" class="btn btn-default ajaxCall">RECHAZAR</a></td>
                <?}else{?>
                <td id="<?='td'.$menu->menu_id?>"> NO </td>
                <td> <a href="{!! URL::action('PerfilController@ajaxAddMenu'); !!}" onClick="return false" class="btn btn-default ajaxCall">PERMITIR</a></td>
                <? } ?>                
            </tr>
           @endforeach
          </tbody>
        </table>

        <script>

$('document').ready(function(){

  $('.ajaxCall').click(function(e){
    
    var menu_id = e.target.parentNode.parentNode.id;
    var perfil_id = $('#b_table_perfil_id').val();
    var _token = $('#csrf-token').val();
    //Hago el ajax call
    var href = e.target.href;

    var selector = '#td'+e.target.parentNode.parentNode.id;

        $.ajax({
                    url : href
                    ,type:'POST'
                    ,data: {'menu_id':menu_id,'perfil_id':perfil_id,'_token':_token}
                    ,success : function(result) {
                    
                    load_perfil_menu(perfil_id);

                    }
                  });  
            });
});
        </script>