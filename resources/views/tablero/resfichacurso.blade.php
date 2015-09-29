      <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cantidad de cargos por x Curso</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
      <div class="panel panel-default">
   <div class="panel-heading">
   Cantidad de cargos por ...
   </div>

  <div class="panel-body">
  <?php 
 // echo "<pre>";
 // print_r($input);
  ?>
  <div class="row">
   <div class="col-md-12">
              <div class="panel panel-default">
                  <!--div class="panel-heading">
                  Gr&aacute;fico
                  </div-->
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                  <div style="margin-left:240px" id="pieChart"></div>

                      <!--div class="flot-chart">
                          <div class="flot-chart-content" id="flot-pie-chart"></div>
                      </div-->
                  </div>
                  <!-- /.panel-body -->
              </div>
              <!-- /.panel -->
    </div>  
   <div class="col-lg-4">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Cargo</th>
                    <th>Cantidad</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data as $dat)
              <tr>
              <input type="hidden" value="{{$curso_id}}"></input>
              <input type="hidden" value="{{$curso_id}}"></input>
              <td><a href="{!! URL::action('TableroController@traeCargoCurso', array('curso_id'=>$curso_id,'car_id'=>$dat->car_id)); !!}">{{$dat->car_nombre}}</a></td>
              <td> {{$dat->cantidad}}</td>
              <td> {{ round($dat->cantidad/$cantidad_total,2)*100 .' %' }}</td>
              </tr>
            @endforeach
            <td>Total</td>
            <td>{{$cantidad_total}}</td>
            <td>100%</td>             
            </tbody>
            </table>
    </div></div>
    </div>        
<div> <a href="#" id="top">Arriba</a>
  </div>
<!--/div-->
<!--script src="{!! URL::asset('/js/flot-data.js'); !!}"></script-->

<script>

var datos =  '<?php echo $json_data ; ?>';
var datos_obj = JSON.parse(datos);


var obj_data = new Object();
obj_data.sortOrder = "value-desc";
obj_data.content = new Array();

for (i = 0; i < datos_obj.length; i++) { 
var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
    datos_obj[i].color = hue;
    obj_data.content.push(datos_obj[i]);
}

var d3pie_data = JSON.stringify(obj_data);

var oo = {
    "sortOrder": "value-desc",
    "content": [
      {
        "label": "JavaScript",
        "value": 264131,
        "color": "#2484c1"
      },
      {
        "label": "Ruby",
        "value": 218812,
        "color": "#0c6197"
      }
      ]
};
console.debug(oo);

var pie = new d3pie("pieChart", {
  "header": {
    "title": {
      "text": "Cargo por Curso",
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
  "data": obj_data//oo 
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
<script>
$('document').ready(function(){

  $('#top').click(function(){
    
     $("body, html").animate({ 
                            scrollTop: 0
                            }, 600);
    //window.scrollTo(0,0);
  });

});
</script>