@extends('app')

@section('content')
<style>
#xaxis .domain {
    fill:none;
    stroke:#d3d3d3;
  }
  #xaxis text, #yaxis text {
    font-size: 12px;
  }

</style>
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cursos</h1>
                </div>
                <!-- /.col-lg-12 -->
      </div>
<!--div class="container"-->
<div class="panel panel-default">
   <div class="panel-heading">
   Tablero de Control - Centro de formaci&oacute;n Judicial
   </div>

  <div class="panel-body">
  <form method="GET" action="{{action('TableroController@cursoFecha')}}" accept-charset="UTF-8">
  <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

  <div class="form-group">
  <label>Seleccione A&ntilde;o</label>
  <select name="anio" class="form-control">
      <option value="0" selected="true"> - </option>
      <option value="2015"> 2015 </option>
      <option value="2014"> 2014 </option>
      <option value="2013"> 2013 </option>
      <option value="2012"> 2012 </option>
      <option value="2011"> 2011 </option>
      <option value="2010"> 2010 </option>
  </select>
  </div>
  <button type="submit" class="btn btn-default">Aceptar</button>
  <!--button type="submit" class="btn btn-default">2015</button>
  <button type="submit" class="btn btn-default">2014</button>
  <button type="submit" class="btn btn-default">2013</button-->
  </form>
<br>
<div>       
</div>
      
<div class="panel-body">
        <div id="chart"> 
        </div>
</div>
@if(isset($data['anio']))
<!--div class="row"-->
 <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
            <?php echo "<pre>"; $array = []; ?>
            @foreach($data['res'] as $curso)
              <tr>
              <td><a href="{!! URL::action('TableroController@cursoCargo', array('curso_id'=>$curso->cur_id,'anio'=>$data['anio'])); !!}">{{$curso->gcu3_titulo}}</a></td>
              <td> {{$curso->cantidad}}</td>
              </tr>
              <?php 
                    
                    $arr_data['categories'] = addslashes($curso->gcu3_titulo);
                    $arr_data['dollars'] = $curso->cantidad;
                    //print_r($arr_data);
                    $array[]=$arr_data;
              ?>
            @endforeach
            </tbody>
            </table>
<a href="#">Volver</a>
  <!--/div-->
</div>
@endif
</div>
</div>
<script src="./js/d3.js"></script>
<?php //echo "<pre>"; print_r($array);?>
<script>
var datos =  '<?php echo json_encode($array) ; ?>';
//console.debug(datos);
//var datos_obj = JSON.parse(datos);
</script>
<script>
/*
var categories = [];
var dollars = [];
var datos_o = JSON.parse(datos);
//console.debug(datos_o);

   for (var i = 0; i < datos_o.length; i++) {
      //if(datos_o[i].categories != "undefined")
      //console.debug(datos_o[i].categories);
      categories.push(datos_o[i].categories);
      var d = parseInt(datos_o[i].dollars);
      console.debug(typeof d);
      dollars.push(d);
    };

  //  console.debug(dollars);

    var categories = ['','Accessories', 'Audiophile', 'Camera & Photo', 'Cell Phones', 'Computers','eBook Readers','Gadgets','GPS & Navigation','Home Audio','Office Electronics','Portable Audio','Portable Video','Security & Surveillance','Service','Television & Video','Car & Vehicle'];
    var dollars = [213,209,190,179,156,209,190,179,213,209,190,179,156,209,190,190];//,209,190,179];
    /*,213,209,190,179,156,209,190,179,213,209,190,179,156,209,190,190,213,209,190,179,
    213,209,190,179,156,209,190,179,213,209,190,179,156,209,190,190,213,209,190,179
    ,213,209,190,179,156,209,190,179,213,209,190,179,156,209,190,190,213,209,190,179];
    
    //console.debug(dollars.length);
    //console.debug(categories.length);
    
  
    var colors = ['#0000b4','#0082ca','#0094ff','#0d4bcf','#0066AE','#074285','#00187B','#285964','#405F83','#416545','#4D7069','#6E9985','#7EBC89','#0283AF','#79BCBF','#99C19E'];

    var grid = d3.range(25).map(function(i){
      return {'x1':0,'y1':0,'x2':0,'y2':480};
    });

    var tickVals = grid.map(function(d,i){
      if(i>0){ return i*10; }
      else if(i===0){ return "100";}
    });

    var xscale = d3.scale.linear()
            .domain([10,250])
            .range([0,722]);

    var yscale = d3.scale.linear()
            .domain([0,categories.length])
            .range([0,480]);

    var colorScale = d3.scale.quantize()
            .domain([0,categories.length])
            .range(colors);

    var canvas = d3.select('#chart')
            .append('svg')
            .attr({'width':1800,'height':1050});

    var grids = canvas.append('g')
              .attr('id','grid')
              .attr('transform','translate(150,10)')
              .selectAll('line')
              .data(grid)
              .enter()
              .append('line')
              .attr({'x1':function(d,i){ return i*30; },
                 'y1':function(d){ return d.y1; },
                 'x2':function(d,i){ return i*30; },
                 'y2':function(d){ return d.y2; },
              })
              .style({'stroke':'#adadad','stroke-width':'1px'});

    var xAxis = d3.svg.axis();
      xAxis
        .orient('bottom')
        .scale(xscale)
        .tickValues(tickVals);

    var yAxis = d3.svg.axis();
      yAxis
        .orient('left')
        .scale(yscale)
        .tickSize(2)
        .tickFormat(function(d,i){ return categories[i]; })
        .tickValues(d3.range(80));

    var y_xis = canvas.append('g')
              .attr("transform", "translate(150,0)")
              .attr('id','yaxis')
              .call(yAxis);

    var x_xis = canvas.append('g')
              .attr("transform", "translate(150,480)")
              .attr('id','xaxis')
              .call(xAxis);

    var chart = canvas.append('g')
              .attr("transform", "translate(150,0)")
              .attr('id','bars')
              .selectAll('rect')
              .data(dollars)
              .enter()
              .append('rect')
              .attr('height',80+19)
              .attr({'x':0,'y':function(d,i){ return yscale(i)+99; }})
              .style('fill',function(d,i){ return colorScale(i); })
              .attr('width',function(d){ return 0; });


    var transit = d3.select("svg").selectAll("rect")
                .data(dollars)
                .transition()
                .duration(1000) 
                .attr("width", function(d) {return xscale(d); });

    var transitext = d3.select('#bars')
              .selectAll('text')
              .data(dollars)
              .enter()
              .append('text')
              .attr({'x':function(d) {return xscale(d); },'y':function(d,i){ return yscale(i)+35; }})
              .text(function(d){ return d+"$"; }).style({'fill':'#fff','font-size':'14px'});

*/
</script>        
<script>
    //console.debug('datos'); 
    //console.debug(datos);
    var w = 1224;
    var arr_categories = new Array();
    var arr_cantidad = new Array();

    var o_datos = JSON.parse(datos);
    for(i=0;i<16;i++){
      
      arr_categories.push(o_datos[i].categories);
      //console.debug();
      var cant = +(o_datos[i].dollars);
      //console.debug(cant);
      arr_cantidad.push(cant)
    }

    console.debug(arr_categories);
    console.debug(arr_cantidad);

   // var categories = arr_categories;
   // var dollars = arr_cantidad;
   var categories = ["VI Jornadas de Actualización del Poder Judicial de la Ciudad Autónoma de Buenos Aires  - Fuero PCyF", "VI Jornadas de Actualización del Poder Judicial de la Ciudad Autónoma de Buenos Aires  - Fuero CAyT", "PRE-CONGRESO INTERNACIONAL: Una lectura de la Conv…nfancia y la Adolescencia. Puebla, México, 2014” ", "Reforma del Código Penal", "Prostitución como tema de Política Pública", "Discapacidad: Derecho a un Trato Adecuado", "Jornada sobre Reforma y Proceso Penal", "Manipulaciones judiciales de los varones violentos…icación de sus tácticas (impedimento de contacto)", "Teorías de Género", "Taller de Trabajo para una Justicia con Perspectiva de Género  - Protocolo C", "Delitos Informáticos y evidencia digital en el proceso penal", "Curso Matrimonio Igualitario y Familias Diversas: Cambios Legislativos y Desafíos Judiciales ", "Ley de Identidad de Género: Antecedentes e Impacto en la Justicia", "Violencia Simbólica y Violencia Mediática", "Mesa Redonda: Género y Derecho", "Encuentros por los 15 años del Centro de Formación Judicial: Transferencia de competencias"];
   var dollars = [328, 325, 95, 83, 65, 56, 55, 54, 53, 41, 37, 37, 36, 35, 34, 31]

    var cantidad_cursos = arr_cantidad;

    var colors = ['#0000b4','#0082ca','#0094ff','#0d4bcf','#0066AE','#074285','#00187B','#285964','#405F83','#416545','#4D7069','#6E9985','#7EBC89','#0283AF','#79BCBF','#99C19E'];

    var grid = d3.range(25).map(function(i){
      return {'x1':0,'y1':0,'x2':0,'y2':480};
    });

    var tickVals = grid.map(function(d,i){
      if(i>0){ return i*10; }
      else if(i===0){ return "100";}
    });

   
    var xscale = d3.scale.linear()
                     .domain([0, d3.max(cantidad_cursos, function(d) {  return d; })])
                     .range([0, w]);        


    var yscale = d3.scale.linear()
            .domain([0,categories.length])
            .range([0,480]);

    var colorScale = d3.scale.quantize()
            .domain([0,categories.length])
            .range(colors);

    var canvas = d3.select('#chart')
            .append('svg')
            .attr({'width':w,'height':550});

    var grids = canvas.append('g')
              .attr('id','grid')
              .attr('transform','translate(600,10)')
              .selectAll('line')
              .data(grid)
              .enter()
              .append('line')
              .attr({'x1':function(d,i){ return i*30; },
                 'y1':function(d){ return d.y1; },
                 'x2':function(d,i){ return i*30; },
                 'y2':function(d){ return d.y2; },
              })
              .style({'stroke':'#adadad','stroke-width':'1px'});

    var xAxis = d3.svg.axis();
      xAxis
        .orient('bottom')
        .scale(xscale);
        //.ticks(5);
      //  .tickValues(tickVals);

    var yAxis = d3.svg.axis();
      yAxis
        .orient('left')
        .scale(yscale)
        .tickSize(2)
        .tickFormat(function(d,i){ return categories[i]; })
        .tickValues(d3.range(17));

    var y_xis = canvas.append('g')
              .attr("transform", "translate(600,35)")
              .attr('id','yaxis')
              .call(yAxis);

    var x_xis = canvas.append('g')
              .attr("transform", "translate(600,500)")
              .attr('id','xaxis')
              .call(xAxis);

    var chart = canvas.append('g')
              .attr("transform", "translate(600,10)")
              .attr('id','bars')
              .selectAll('rect')
              .data(dollars)
              .enter()
              .append('rect')
              .attr('height',19)
              .attr({'x':0,'y':function(d,i){ return yscale(i)+19; }})
              .style('fill',function(d,i){ return '#6AA6D6' }) //colorScale(i);
              .attr('width',function(d){ return 0; });


    var transit = d3.select("svg").selectAll("rect")
                .data(dollars)
                .transition()
                .duration(1000) 
                .attr("width", function(d) {return xscale(d); });

    var transitext = d3.select('#bars')
              .selectAll('text')
              .data(dollars)
              .enter()
              .append('text')
              .attr({'x':function(d) {return xscale(d)/2.2; },'y':function(d,i){ return yscale(i)+35; }})
              .text(function(d){ return d; }).style({'fill':'#ffff','font-size':'14px'});
</script>
@stop