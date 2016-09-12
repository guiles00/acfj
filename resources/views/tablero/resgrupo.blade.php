<!--br>
<div class="row">
  <div id="breadcrumb" class="col-xs-12">
    <ol class="breadcrumb">
      <li><a href="index.html">Panel de Control</a></li>
      <li><a href="#">Indice</a></li>
   
    </ol>
  </div>
</div-->
<script src="{!! URL::asset('js/jquery.js'); !!}"></script>
<!--script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script-->
<script src="{!! URL::asset('js/d3.js'); !!}"></script>

<div class="col-lg-12">

    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style ="color: #94b5d8">Cursos dictados en {{ $data['anio'] }}</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
   </div>

  <div class="panel-body">
   
   <div class="row">

   <div class="col-md-6">
            <div id="grupoChart"></div>
            
    </div>

 
   <div class="col-md-6">
  
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid1">
            <thead>
                <tr>
                    <th>Categor&iacute;a</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="{!! URL::action('TableroController@listadoGrupoDosCursos', array('gcu_id'=>$dat->gcu_id,'anio'=>$data['anio'])); !!}" style="cursor: pointer;" data-toggle="tooltip" title="Hooray!">
              <input type="hidden" value="{{ $dat->gcu_id}}"></input>
              <input type="hidden" value="{{ $data['anio'] }}"></input>
              <td>{{$dat->grupo}}</td>
              <td>{{$dat->cantidad}}</td>
              </tr>
            @endforeach
            <!--tr><td></td><td>
            <button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal">Ver Gr&aacute;fico</button>
            </td></tr-->
            </tbody>
            </table>
      </div>
  </div>

</div>  
<div id="res2">
</div>
<!-- 
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Este curso tiene los siguientes datos</h4>
        </div>
        <div class="modal-body">
          <div id="grupoChart"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
-->

  </div>
</div>

<script src="{!! URL::asset('/js/d3pie.js'); !!}"></script>
<script>
$('document').ready(function(){
   
   //jQuery.noConflict();         
   //$('#myModal').modal('toggle');


  $('#botoneta').click(function(){
    
   // $('#res').html('esta es para vos');

              $.ajax({
                         // url: 'http://localhost/content/cfj-cfj/admin_cfj/public/area',
                          url: './cfj-cfj/admin_cfj/public/area',
                          success: function(data){
                            $('#content').html(data);
                          }
                        });

  });

    $('.traemeladata').click(function(e){
        e.preventDefault();
        return;
        
        var gcu_id = e.target.parentNode.parentNode.childNodes[1].value;
        var anio = e.target.parentNode.parentNode.childNodes[3].value;
        //console.debug(e.target.href);
        var href = e.target.href;
        $.ajax({
                   url: href
                   // url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoGrupoDosCursos',
                   // data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      $('#res2').html(data);
                    }
                });

    });

     $(".dataGrid1 td").click(function(e) {
        
        var href = e.target.parentNode.getAttribute('href');
        
         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){

                      $('#res2').html(data);
                      $("body, html").animate({ 
                          scrollTop: $( $('#res2') ).offset().top 
                          }, 600);
                    }
                });

    });
});
</script>
<script>
$('document').ready(function(){
var datos =  '<?php echo $json_data ; ?>';
var datos_obj = JSON.parse(datos);

var obj_data = new Object();
obj_data.sortOrder = "value-desc";
obj_data.content = new Array();
//obj_data.content = datos_obj;
for (i = 0; i < datos_obj.length; i++) { 
var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
    datos_obj[i].color = hue;
    obj_data.content.push(datos_obj[i]);
}

var pie = new d3pie("grupoChart", {
  "header": {
    "title": {
      "text": "Cantidad por Programas",
      "fontSize": 24,
      "font": "open sans"
    },
    "subtitle": {
      "color": "#999999",
      "fontSize": 12,
      "font": "open sans"
    },
    "titleSubtitlePadding": 9
  },
  "footer": {
    "color": "#999999",
    "fontSize": 10,
    "font": "open sans",
    "location": "bottom-left"
  },
  "size": {
    "canvasWidth": 790,
    "pieOuterRadius": "90%"
  },
  "data": obj_data
  ,"labels": {
    "outer": {
      "pieDistance": 30
    },
    "inner": {
      "hideWhenLessThanPercentage": 3
    },
    "mainLabel": {
      "fontSize": 12
    },
    "percentage": {
      "color": "#ffffff",
      "decimalPlaces": 0
    },
    "value": {
      "color": "#adadad",
      "fontSize": 12
    },
    "lines": {
      "enabled": true
    },
    "truncation": {
      "enabled": false
    }
  },
  "effects": {
    "pullOutSegmentOnClick": {
      "effect": "linear",
      "speed": 400,
      "size": 12
    }
  },
  "misc": {
    "gradient": {
      "enabled": true,
      "percentage": 100
    }
  }
});

});
</script>