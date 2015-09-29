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
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.4.4/d3.min.js"></script>
<script src="{!! URL::asset('/js/d3pie.js'); !!}"></script>

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
              <td>{{$dat->gcu_nombre}}</td>
              <td>{{$dat->cantidad}}</td>
              </tr>
            @endforeach
            <tr><td></td><td>
            <button type="button" class="btn btn-info btn-lg btn-xs" data-toggle="modal" data-target="#myModal">Ver Gr&aacute;fico</button>
            </td></tr>
            </tbody>
            </table>
      </div>
  </div>
    <div id="res2" class="col-md-6">
    </div>
</div>  
    <!-- Modal -->
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


  </div>
</div>


<script>
$('document').ready(function(){
   
   //jQuery.noConflict();
          
   //$('#myModal').modal('toggle');


  $('#botoneta').click(function(){
    
   // $('#res').html('esta es para vos');

              $.ajax({
                         // url: 'http://localhost/content/cfj-cfj/admin_cfj/public/area',
                          url: './cfj-cfj/admin_cfj/public/area',
                          //data: {'data':d.target.value},
                          success: function(data){
                           // console.debug(data);
                            $('#content').html(data);
                           // console.debug(data);
                          }
                          //dataType: dataType
                        });

  });

    $('.traemeladata').click(function(e){
        e.preventDefault();
        return;
        //console.debug(e.target.parentNode.parentNode.childNodes);
        //return;
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
        //console.debug(href);
         $.ajax({
                    url:href
                    //url: 'http://localhost/content/cfj-cfj/admin_cfj/public/listadoCursos',
                    //data: {'gcu_id':gcu_id,'anio':anio},
                    ,success: function(data){
                      $('#res2').html(data);
                    }
                });

    });
});
</script>
<script>
var pie = new d3pie("grupoChart", {
  "header": {
    "title": {
      "text": "Lots of Programming Languages",
      "fontSize": 24,
      "font": "open sans"
    },
    "subtitle": {
      "text": "A full pie chart to show off label collision detection and resolution.",
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
    "canvasWidth": 390,
    "pieOuterRadius": "90%"
  },
  "data": {
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
      },
      {
        "label": "Java",
        "value": 157618,
        "color": "#4daa4b"
      },
      {
        "label": "PHP",
        "value": 114384,
        "color": "#90c469"
      },
      {
        "label": "Python",
        "value": 95002,
        "color": "#daca61"
      }
    ]
  },
  "labels": {
    "outer": {
      "pieDistance": 32
    },
    "inner": {
      "hideWhenLessThanPercentage": 3
    },
    "mainLabel": {
      "fontSize": 11
    },
    "percentage": {
      "color": "#ffffff",
      "decimalPlaces": 0
    },
    "value": {
      "color": "#adadad",
      "fontSize": 11
    },
    "lines": {
      "enabled": true
    },
    "truncation": {
      "enabled": true
    }
  },
  "effects": {
    "pullOutSegmentOnClick": {
      "effect": "linear",
      "speed": 400,
      "size": 8
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