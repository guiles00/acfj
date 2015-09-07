window.load = function(){
var data = [{"Anio":"1998","EJF":"50726","EXP":"0","RDC":"0","Total":"50726"},{"Anio":"1999","EJF":"6403","EXP":"0","RDC":"0","Total":"6403"},{"Anio":"2000","EJF":"59211","EXP":"417","RDC":"0","Total":"59628"},{"Anio":"2001","EJF":"153053","EXP":"2801","RDC":"0","Total":"155854"},{"Anio":"2002","EJF":"68500","EXP":"2768","RDC":"0","Total":"71268"},{"Anio":"2003","EJF":"85650","EXP":"4658","RDC":"0","Total":"90308"},{"Anio":"2004","EJF":"70980","EXP":"4689","RDC":"0","Total":"75669"},{"Anio":"2005","EJF":"32670","EXP":"5889","RDC":"0","Total":"38559"},{"Anio":"2006","EJF":"78843","EXP":"5822","RDC":"0","Total":"84665"},{"Anio":"2007","EJF":"3771","EXP":"4925","RDC":"322","Total":"8696"},{"Anio":"2008","EJF":"82869","EXP":"5501","RDC":"342","Total":"88370"},{"Anio":"2009","EJF":"55795","EXP":"4148","RDC":"349","Total":"59943"},{"Anio":"2010","EJF":"54755","EXP":"4261","RDC":"341","Total":"59016"},{"Anio":"2011","EJF":"83147","EXP":"4000","RDC":"301","Total":"87147"},{"Anio":"2012","EJF":"27939","EXP":"3251","RDC":"248","Total":"31190"},{"Anio":"2013","EJF":"89643","EXP":"4385","RDC":"240","Total":"94028"},{"Anio":"2014","EJF":"53832","EXP":"3993","RDC":"688","Total":"58513"}];

var margin = {top: 20, right: 30, bottom: 30, left: 40},
    width = 860 - margin.left - margin.right,
    height = 400 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

//d3.csv("datos_anios.csv", function(error, data) {
    console.debug(JSON.stringify(data));
    //esto seria un switch ?? 
    var arr_data = [];
    //var datos = data;
    //console.debug(data);
    for (var i = 0; i < data.length; i++) {
     var o = {'name':data[i].Anio,'value':data[i].Total};  
     arr_data.push(o);
    };
//***//

var chart = d3.select(".chart")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  x.domain(arr_data.map(function(d) { return d.name; }));
  y.domain([0, d3.max(arr_data, function(d) { return d.value; })]);

console.log(chart);
  chart.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  chart.append("g")
      .attr("class", "y axis")
      .call(yAxis);

  var bar = chart.selectAll(".bar")
      .data(arr_data)
    .enter().append("g");

    bar.append("rect")
      .attr("class", "rect")
      .attr("x", function(d) { return x(d.name); })
      .attr("y", function(d) { return y(d.value); })
      .attr("height", function(d) { return height - y(d.value); })
      .attr("width", x.rangeBand())
      .attr("fill","#632423")
      .on('mouseover',function(d){
          var a = d3.select(this)
          .attr("fill","#733A39");

        var a = d3.select("#tooltip")
        .style("left","100px")
        .style("top","20px")
        .select("#value")
        .text(d.value);

      }).on('mouseout',function(d){
          var a = d3.select(this)
          .attr("fill","#632423"); //old color: #790018        
      });
      
      bar.append("text")
      .attr("class", "label")
      .text(function(d) { return d.value; })
      .attr("x", function(d) { return x(d.name)+4; })
      .attr("y", function(d) { return y(d.value)+20 ; });

function type(d) {
  d.value = +d.value; // coerce to number
  return d;
}

}();