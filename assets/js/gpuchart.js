// JavaScript Document
function statsChart(rigname, label, stats){
					var width = 70,
						height = 70,
						radius = Math.min(width-2, height-2) / 2,
						innerRadius = 0.45 * radius,
						cornerRadius = 0,
    					padAngle = .03;

					var pie = d3.layout.pie()
						.sort(null)
						.value(function(d) { return d.width; });

					var tip = d3.tip()
					  .attr("class","d3-tip")
					  .offset([0, 1])
					  .html(function(d) {
						return d.data.label + ": <span>" + d.data.score + "</span>";
					  });

					var arc = d3.svg.arc()
					  .innerRadius(innerRadius)
					  .cornerRadius(cornerRadius)
					  .innerRadius(innerRadius)
					  .outerRadius(function (d) { 
						return (radius - innerRadius) * (Math.max(d.data.score, 750) / 6000) + innerRadius; 
					  });
	
					var outlineArc = d3.svg.arc()
							.innerRadius(innerRadius)
							.outerRadius(radius);

					var svg = d3.select("#fan"+rigname).append("svg")
						.attr("width", width+1)
						.attr("height", height+1)
						.append("g")
						.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

					svg.call(tip);

					var data= stats;
					//console.log(data);
	
					var scale = d3.scale.linear()
					.domain([100,6000])
					.clamp(true)
					.range([255,0]);

					  data.forEach(function(d) {
						d.id     =  d.id;
						d.order  = +d.order;
						d.color  =  d.color;
						d.weight = +d.weight;
						//d.score  = +d.score;
				        d.score  = +Math.max(d.score,0);
						d.color  =  d3.rgb(0, scale(d.score),255);
						d.width  = +d.weight;
						d.label  =  d.label;

					  });

					  var path = svg.selectAll(".solidArc")
						  .data(pie(data))
						  .enter().append("path")
						 .attr("fill", "#3f3f3f")
					     //.attr("fill", d3.rgb(255, function(d) { return d.data.score; } ,0))
						  .attr("class", "bar")
						  //.attr("stroke", "#272727")
						  //.attr("fill", "#00FC00")
						  .attr("stroke-width",2)
						  .attr("d", arc)
						  .on("mouseover", tip.show)
						  .on("mouseout", tip.hide)
						  .transition()
						  .delay(function(d, i) {
							return i * 200+1000;
						  })
						  .duration(1000)
						  .attr("fill", function(d) { return d.data.color; });
						

					
					  var outerPath = svg.selectAll(".outlineArc")
						  .data(pie(data))
						  .enter().append("path")
						  .attr("fill", "none")
						  .attr("stroke", "#878787")
						  .attr("stroke-width",2)
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
						//.style("color", "white")
						.attr("dy", ".35em")
						.attr("text-anchor", "middle") // text-align: right
						.text(label);
						//.text(Math.round(score));

}

function statsChart2(rigname, label, stats){
					var width = 70,
						height = 70,
						radius = Math.min(width-2, height-2) / 2,
						innerRadius = 0.45 * radius,
						cornerRadius = 0,
    					padAngle = .03;

					var pie = d3.layout.pie()
						.sort(null)
						.value(function(d) { return d.width; });

					var tip = d3.tip()
					  .attr("class","d3-tip")
					  .offset([0, 1])
					  .html(function(d) {
						return d.data.label + ": <span>" + d.data.score + "</span>";
					  });

					var arc = d3.svg.arc()
					  .innerRadius(innerRadius)
					  .cornerRadius(cornerRadius)
					  .innerRadius(innerRadius)
					  .outerRadius(function (d) { 
						return (radius - innerRadius) * (Math.min(d.data.score, 100)/100) + innerRadius; 
					  });

					var outlineArc = d3.svg.arc()
							.innerRadius(innerRadius)
							.outerRadius(radius);

					var svg = d3.select("#temp"+rigname).append("svg")
						.attr("width", width+1)
						.attr("height", height+1)
						.append("g")
						.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

					svg.call(tip);

					var data= stats;
					//console.log(data);


	
	//var outageThresholds = [ 20, 30, 40, 60, 70, 80, 100 ];
	//var thresholdColors = ["rgb(0,255,255)","rgb(123,255,123)","rgb(216,255,35)","rgb(255,255,100)","rgb(255,255,0)","rgb(255,200,0)","rgb(255,0,0)"];
	

	
	//outColor = d3.scale.threshold()
	             //.domain(outageThresholds)
                 //.range(thresholdColors);
	
				var scale = d3.scale.linear()
				.domain([10,100])
				.clamp(true)
				.range([255,0]);
	
			data.forEach(function(d) {
						d.id     =  d.id;
						d.order  = +d.order;
						d.weight = +d.weight;
						//d.score  = +d.score
				        d.score  = +Math.max(d.score,10);
						d.color  =  d3.rgb(255, scale(d.score),0);
						d.width  = +d.weight;
						d.label  =  d.label;
				//console.log(d.color);

			});
	


					  var path = svg.selectAll(".solidArc")
						  .data(pie(data))
						.enter().append("path")
						 .attr("fill", "#3f3f3f")
					  //.attr("fill", d3.rgb(255, 255,0))
						  .attr("class", "bar")
						  //.attr("stroke", "#272727")
						  //.attr("fill", scale(function(d) { return (100- d.data.score); }))
						  .attr("stroke-width",2)
						  .attr("d", arc)
						  .on("mouseover", tip.show)
						  .on("mouseout", tip.hide)
					      .transition()
					  	  .delay(function(d, i) {
							return i * 200+1000;
						  })
						  .duration(1000)
						  .attr("fill", function(d) { return d.data.color; });

					  var outerPath = svg.selectAll(".outlineArc")
						  .data(pie(data))
						.enter().append("path")
						  .attr("fill", "none")
						  .attr("stroke", "#878787")
						  .attr("stroke-width",2)
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
						//.style("color", "white")
						.attr("dy", ".35em")
						.attr("text-anchor", "middle") // text-align: right
						.text(label);
						//.text(Math.round(score));

}

function statsTemp(rigname, label, stats){
	var margin = {top: 1, right: 1, bottom: 1, left: 1},
						width = 80 - margin.left - margin.right,
						height = 70 - margin.top - margin.bottom;

					var formatPercent = d3.format("0");

					var x = d3.scale.ordinal()
						.rangeRoundBands([0, width], .1);

					var y = d3.scale.linear()
						.range([height, 0]);

					var xAxis = d3.svg.axis()
						.scale(x)
						.orient("bottom");

					var yAxis = d3.svg.axis()
						.scale(y)
						.orient("left")
						//.tickFormat(formatPercent);

					var tip = d3.tip()
					  .attr("class", "d3-tip")
					  .offset([-10, 0])
					  .html(function(d) {
						return "<strong>GPU" + d.letter +": </strong>" + d.frequency;
					  })

					var svg = d3.select("#temp"+rigname).append("svg")
						.attr("width", width + margin.left + margin.right)
						.attr("height", height + margin.top + margin.bottom)
						//.attr("stroke", "black")
						 .attr("dy", "1.85em")
					  .append("g")
						.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
						

					svg.call(tip);

						//var rectClass = "t"+d.frequency;
						//console.log(rectClass);

					//d3.tsv("data.tsv", type, function(error, data) {

						var data= stats;
						//console.log(data);

						function type(d) {
							d.frequency = +d.frequency;
							d.class =  d.class;
						  return d;
						}

						//console.log(data);
						//console.log(data2);


						x.domain(data.map(function(d) { return d.letter; }));
						//saturate values for contrast comparisment
					  //y.domain([0, 30+d3.max(data, function(d) { return d.frequency; })]);
					   
						y.domain([0, 130]);
						
							var outageThresholds = [ 20, 30, 40, 60, 70, 80, 100 ];
	var thresholdColors = ["rgb(0,255,255)","rgb(123,255,123)","rgb(216,255,35)","rgb(255,255,100)","rgb(255,255,0)","rgb(255,200,0)","rgb(255,0,0)"];
	outColor = d3.scale.threshold()
                 .domain(outageThresholds)
                 .range(thresholdColors);

					 // svg.append("g")
						// .attr("class", "x axis")
						// .attr("transform", "translate(0," + height + ")")
						 //.call(xAxis);
						

					  //svg.append("g")
						//  .attr("class", "y axis")
						//  .call(yAxis)
						//.append("text")
						 //.attr("transform", "rotate(-90)")
						  //.attr("y", 6)
						 // .attr("dy", ".71em")
						  //.style("text-anchor", "end")
						 // .text("Frequency");
						 
				
					  svg.selectAll(".bar")
						  .data(data)
						.enter().append("rect")
						  //.attr("class", "t70")
						  .attr("class", "bar")
						  .attr("fill", function(d) {
								if (d.frequency > 0) {
									return(outColor(d.frequency));
								} else {
									return("white");
								}
							} )
						  //.attr("fill", function(d) { return d3.rgb(255,0,0);})
						  .attr("x", function(d) { return x(d.letter); })
						  .attr("width", x.rangeBand())
						  .attr("y", function(d) { return y(d.frequency); })
						  .attr("height", function(d) { return height - y(d.frequency); })
						  .on("mouseover", tip.show)
						  .on("mouseout", tip.hide);
						  
						  svg.append("svg:text")
						.attr("class", "aster-score")
						.attr("dy", "1.5em")
						.attr("text-anchor", "right") // text-align: right
						.text(label);
						//.text(Math.round(score));
						
						//.html(function(d) {
						//return "<strong>GPU" + d.letter +": </strong>" + d.frequency;
						//});
	
}