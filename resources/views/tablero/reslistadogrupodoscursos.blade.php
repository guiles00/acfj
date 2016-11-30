<div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">{{$data['res'][0]->subgrupo}}</h2>
                </div>
                
</div>
 <div class="row">
  
  <div class="col-lg-12">

   <div class="col-md-6">
        <div id="otroChart"></div>
   </div>

 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped dataGrid">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['res'] as $dat)
              <tr href="{!! URL::action('TableroController@listadoCursos', array('gcu2_id'=>$dat->gcu2_id,'anio'=>$data['anio'])); !!}" style="cursor: pointer;">
              <td> {{ $dat->subgrupo }}</td>
              <td> {{ $dat->cantidad }} </td>
              </tr>
            @endforeach
            </tbody>
            </table>
</div>
</div>
</div>

<div id="res-cursos">
</div>

<script>
$('document').ready(function(){

    $('.traemeladata2').click(function(e){
        //e.preventDefault();
        return;
        console.debug(e.target.href);
        var href = e.target.href;
        //return;
       // var gcu_id = e.target.parentNode.parentNode.childNodes[1].value;
        //var anio = e.target.parentNode.parentNode.childNodes[3].value;

        $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                     // $('#res-cursos').html(data);
                     // $('#res-cursos').focus();
                    }
                });

    });



     $(".dataGrid td").click(function(e) {
        
        var href = e.target.parentNode.getAttribute('href');

         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      
                         $("body, html").animate({ 
                          scrollTop: $( $('#res-cursos') ).offset().top 
                          }, 600);
                      
                      $('#res-cursos').html(data);
                      
                      
                    }
                });

    });

});
</script>
<script>

var datos =  '<?php echo $json_data ; ?>';
var datos_obj = JSON.parse(datos);
//console.debug(datos_obj);
var obj_data = new Object();
obj_data.sortOrder = "value-desc";
obj_data.content = new Array();
//obj_data.content = datos_obj;
for (i = 0; i < datos_obj.length; i++) { 
var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
    datos_obj[i].color = hue;
    obj_data.content.push(datos_obj[i]);
}

var pie = new d3pie("otroChart", {
  "header": {
    "title": {
      "text": "Cargo por Programas",
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
</script>

  