// JSON Document
var width = 100,
    height = 100,
    radius = Math.min(width, height) / 2,
    innerRadius = 0.3 * radius;

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.width; });

var tip = d3.tip()
  .attr("class","d3-tip")
  .offset([0, 0])
  .html(function(d) {
    return d.data.label + ": <span>" + d.data.score + "</span>";
  });

var arc = d3.svg.arc()
  .innerRadius(innerRadius)
  .outerRadius(function (d) { 
    return (radius - innerRadius) * (d.data.score / 100.0) + innerRadius; 
  });

var outlineArc = d3.svg.arc()
        .innerRadius(innerRadius)
        .outerRadius(radius);

var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

svg.call(tip);

var data= [
	{"id":"ABC", "order":1, "score":80, "weight": 1, "class":"t80", "label": "GPU1"},
	{"id":"CDE", "order":2, "score":55, "weight": 1, "class":"t55", "label": "GPU2"},
	{"id":"CDE", "order":2, "score":53, "weight": 1, "class":"t53", "label": "GPU3"},
	{"id":"CDE", "order":2, "score":57, "weight": 1, "class":"t66", "label": "GPU3"},
	{"id":"CDE", "order":2, "score":71, "weight": 1, "class":"t71", "label": "GPU4"},
	{"id":"CDE", "order":2, "score":62, "weight": 1, "class":"t62", "label": "GPU5"}
];
//console.log(temps);

//d3.selection.data(temps);
//d3.selection(temps, function(error, data) {

  data.forEach(function(d) {
    d.id     =  d.id;
    d.order  = +d.order;
    d.color  =  d.color;
    d.weight = +d.weight;
    d.score  = +d.score;
    d.width  = +d.weight;
    d.label  =  d.label;

  });
   //for (var i = 0; i < data.score; i++) { console.log(data[i].id) }
 //var rgb_color = 255 - d.score; 
 //console.log( d.score );
  
  var path = svg.selectAll(".solidArc")
      .data(pie(data))
    .enter().append("path")
     //.attr("fill", function(d) { return d.data.color; })
  //.attr("fill", d3.rgb(255, function(d) { return d.data.score; } ,0))
      .attr("class", function(d) { return d.data.class; })
      .attr("stroke", "white")
      .attr("d", arc)
      .on("mouseover", tip.show)
      .on("mouseout", tip.hide);

  var outerPath = svg.selectAll(".outlineArc")
      .data(pie(data))
    .enter().append("path")
      .attr("fill", "none")
      .attr("stroke", "white")
      .attr("class", "outlineArc")
      .attr("d", outlineArc);  


  // calculate the weighted mean score
  var score = 
    data.reduce(function(a, b) {

      return a + (b.score * b.weight); 
    }, 0) / 
    data.reduce(function(a, b) { 
      return a + b.weight; 
    }, 0);

  svg.append("svg:text")
    .attr("class", "aster-score")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle") // text-align: right
    .text(Math.round(score));

//});