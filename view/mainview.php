<?php
/*---------------ethosDash@protonmail.com--------------------*/
/*----------------all IP rights reserver---------------------*/
/*************************************************************/
// Process HTML for main.php page

class summaryBlock{
	
	function summaryMiner($miner, $algo, $label1){
		
		/*echo '
		      <div class="summary_miner">
                  <h3 class="card-title miner_summary_head_'.$miner.'">'.$miner.'</h3>
				  <h6>'.$label1.': '.$algo.' </h6>
              </div>
		';*/
		
		echo '
		      
                  <h3 class="card-title miner_summary_head_'.$miner.'">'.$miner.'</h3>
           
		';
	}
	function summaryInfo($label, $value, $sublabel=NULL, $subvalue=NULL){
		
		$renderhtml = '
		
			<div data-toggle="tooltip" title="'.$label.'"><span>: '.$value;
		if(!is_null($subvalue)) $renderhtml.=' '.$subvalue;
		if(!is_null($sublabel)) $renderhtml.='</span> <span class="in_brackets">'.$sublabel;
		$renderhtml.='</span></div>';
		echo $renderhtml;
	}
	/*
	[total_hash] => 50381.91
    [alive_gpus] => 111
    [total_gpus] => 135
    [alive_rigs] => 11
    [total_rigs] => 13
    [current_version] => 1.2.5
    [avg_temp] => 60.506923076923
    [capacity] => 82.2
	*/
	function totalInfo($totals, $labels){

		echo '
		<div  class="summary_block">
		      <div class="summary_miner">
            <h6>'.$labels["hashrate"].':</h6>  
            <h3 class="hash_mining">'.$totals["hashrate"].'</h3>
			<h6>'.$labels["capacity"].':</h6>
			<h3 class="hash_mining">'.$totals["capacity"].'%</h3>
			
              </div>
		</div>';
		/*
		<div  class="summary_block">
		      <div class="summary_miner">            
			  <h6>'.$labels["rigs"].':</h6>
				<h3 class="hash_mining"  data-toggle="tooltip" title="'.$labels["total_alive"].'">'.$totals["alive_rigs"].'/'.$totals["total_rigs"].'</h3>
				
				<h6>'.$labels["gpus"].':</h6>
				<h3 class="hash_mining" data-toggle="tooltip" title="'.$labels["total_alive"].'">'.(is_null($totals["alive_gpus"])?"0":$totals["alive_gpus"]).'/'.$totals["total_gpus"].'</h3>
              </div>
		</div>
			
			//  '.($totals["alive_rigs"] < $totals["total_rigs"]?'alive_units_low':'alive_units_max').'     
			*/

	}
	

	
		function sumhashInfo($stats){
			
			echo '
			<div  class="summary_block">
		      <div class="summary_miner">';
			foreach($stats as $statname=>$value){
				$this->displayHashStats($statname,$value);
			}
			echo '</div></div>';
			
		}
	
		function displayHashStats($label, $value, $sublabel=NULL, $subvalue=NULL){
		$subvalue = algoUnits($label);
		$renderhtml = '
			<div><h6>'.$label.':</h6>';
		$renderhtml.='<h3 class="hash_mining">'.$value;	
		//	'.$value;
		//if(!is_null($subvalue))
			$renderhtml.=' '.$subvalue;
		if(!is_null($sublabel)) $renderhtml.=' '.$sublabel.'</h3>';
		else $renderhtml.='</h3>';
		$renderhtml.='</div>';
		echo $renderhtml;
			//<h3 class="hash_mining">'.$totals["hashrate"].'</h3>
	}
	

	
}
class rigsTable{
	
		function statsRigsGpus($rigs_gpus){
		echo '<div class="rigs_gpu_block">';
			echo '<span class="rig_gpu_info">'.$rigs_gpus['rig_label'].': </span>';
			
			if($rigs_gpus['alive_rigs'] < $rigs_gpus['total_rigs']){
				echo	'<span class="hash_mining hash_mining_units alive_units_low">'.$rigs_gpus['alive_rigs'].'/'.$rigs_gpus['total_rigs'].'</span>&nbsp; ';
			}else{
				echo	'<span class="hash_mining hash_mining_units alive_units_max">'.$rigs_gpus['alive_rigs'].'/'.$rigs_gpus['total_rigs'].'</span>&nbsp;  ';
			}
			echo '<span class="rig_gpu_info">'.$rigs_gpus['gpu_label'].': </span>';
			
			if($rigs_gpus['alive_gpus']<$rigs_gpus['total_gpus']){
				echo '<span class="hash_mining hash_mining_units alive_units_low">'.$rigs_gpus['alive_gpus'].'/'.$rigs_gpus['total_gpus'].'</span>&nbsp; ';
			}else{
				echo '<span class="hash_mining hash_mining_units alive_units_max">'.$rigs_gpus['alive_gpus'].'/'.$rigs_gpus['total_gpus'].'</span>&nbsp; ';
			}
			
			echo 	'<span class="rig_gpu_info">'.$rigs_gpus['capacity_label'].': </span>';
			
			if ($rigs_gpus['capacity']<100){
				echo '<span class="hash_mining hash_mining_units alive_units_low">'.$rigs_gpus['capacity'].'%</span>&nbsp; ';
			}else{
				echo '<span class="hash_mining hash_mining_units alive_units_max">'.$rigs_gpus['capacity'].'%</span>&nbsp; ';
			}
			
		echo '</div>';
		
	}
	
		function rigslistHeader(){
			/*
			echo '<div class="riglist_row">
				<div class="riglist_cell table_status"><strong>GPU#</strong></div>
				<div class="riglist_cell table_driver"><strong>GPU#</strong></div>
				<div class="riglist_cell table_rigloc"><strong>Rig-Loc-IP</strong></div>
				<div class="riglist_cell table_miner"><strong>Miner/GPUs</strong></div>
				<div class="riglist_cell table_hash"><strong>Hashrate</strong></div>
				<div class="riglist_cell table_power"><strong>Power</strong></div>
				<div class="riglist_cell table_power"><strong>Efficiency</strong></div>
				<div class="riglist_cell table_temp"><strong>Temp</strong></div>
				<div class="riglist_cell table_fanrpm"><strong>Fan (RPMx1000)</strong></div>
				<div class="riglist_cell table_pool"><strong>Pool</strong></div>
			</div>';
			
			    <div class="metal-border speedometer-half" id="example1D">
      <div class="example"></div>
      <div class="gauge-value"></div>
    </div>
			*/
			
		}
	
		function rigslist($per_rig_info){
			foreach($per_rig_info as $rigname=>$rigstats){
				//condition options: mining, unreachable, rofs, no_hash, overload
				if($rigstats["condition"]!="unreachable"){
					
					$datalyser = new analyseJSON();

					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_status '.($rigstats["condition"]=="mining"?'liverig':'slowrig').'" data-toggle="tooltip" title="'.$rigstats["condition"].'"></div>
									
									<div class="riglist_cell table_rigloc"><span class="rack_loc">'.$rigstats["rack_loc"].'</span><br/><span>'.$rigname.'</span><br/><span  class="in_brackets">'.$rigstats["ip"].'</span></div>
									<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									<div class="riglist_cell table_hash"  data-toggle="tooltip" title="Hashrate: '.$datalyser->getTooltip($rigstats["miner_hashes"]).'"><span class="rack_loc">'.$rigstats["miner"].'</span><br/><span class=" hash_mining">'.$rigstats["hash"].'</span> <span class="hash_mining hash_mining_units">'.algoUnits(get_algo($rigstats["miner"])).'</span></div>
									<div class="riglist_cell table_power" data-toggle="tooltip" title="Power Usage: '.$datalyser->getTooltip($rigstats["watts"]).'"><span class="rack_loc">Power</span><br/>
									<span class="power_consumes">'.$datalyser->rigPower($rigstats["watts"],$rigstats["gpus"]).'</span><span class="  power_consumes_units"> Wts</span></div>
									<div class="riglist_cell table_temp"><div class="tempgraph" id="temp'.$rigname.'"></div></div>
									<div class="riglist_cell table_fanrpm"><div id="fan'.$rigname.'"  class="fangraph"></div></div>
									<div class="riglist_cell table_pool"><span>'.$rigstats["pool"].'</span></div>
								</div>';
					//<div class="riglist_cell table_power power_eff"><span>'.$datalyser->powerEfficiency($rigstats["watts"],$rigstats["miner_hashes"],$rigstats["gpus"],$rigstats["miner_instance"]).'</span></div>
						$temp_json = json_encode($datalyser->getTempArray($rigstats["temp"]));
						$fan_json = json_encode($datalyser->getFanArray($rigstats["fanrpm"]));
						//echo $temp_json;	
									   
			$renderhtml .= '<script>
					var width = 100,
						height = 100,
						radius = Math.min(100, 100) / 2,
						innerRadius = 0.4 * radius;

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
					  .outerRadius(function (d) { 
						return (radius - innerRadius) * (d.data.score / 4500) + innerRadius; 
					  });

					var outlineArc = d3.svg.arc()
							.innerRadius(innerRadius)
							.outerRadius(radius);

					var svg = d3.select("#fan'.$rigname.'").append("svg")
						.attr("width", width+1)
						.attr("height", height+1)
						.append("g")
						.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

					svg.call(tip);

					var data= '.$fan_json.';
					//console.log(data);

					  data.forEach(function(d) {
						d.id     =  d.id;
						d.order  = +d.order;
						d.color  =  d.color;
						d.weight = +d.weight;
						d.score  = +d.score;
						d.width  = +d.weight;
						d.label  =  d.label;

					  });

					  var path = svg.selectAll(".solidArc")
						  .data(pie(data))
						.enter().append("path")
						 //.attr("fill", function(d) { return d.data.color; })
					  //.attr("fill", d3.rgb(255, function(d) { return d.data.score; } ,0))
						  .attr("class", "bar")
						  .attr("stroke", "#272727")
						  .attr("stroke-width",2)
						  .attr("d", arc)
						  .on("mouseover", tip.show)
						  .on("mouseout", tip.hide);

					  var outerPath = svg.selectAll(".outlineArc")
						  .data(pie(data))
						.enter().append("path")
						  .attr("fill", "none")
						  .attr("stroke", "#272727")
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
						.text("RPM");
						//.text(Math.round(score));

				</script>';
				
				$renderhtml .='
				
				<script>

					var margin = {top: 1, right: 2, bottom: 1, left: 1},
						width = 100 - margin.left - margin.right,
						height = 90 - margin.top - margin.bottom;

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

					var svg = d3.select("#temp'.$rigname.'").append("svg")
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

						var data= '.$temp_json.';
						//console.log(data);

						function type(d) {
							d.frequency = +d.frequency;
							d.class =  d.class;
						  return d;
						}

						console.log(data);
						//console.log(data2);


						x.domain(data.map(function(d) { return d.letter; }));
					  //y.domain([0, d3.max(data, function(d) { return d.frequency; })]);
						y.domain([0, 130]);

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
						  .attr("class", function(d) { return d.class; })
						  .attr("x", function(d) { return x(d.letter); })
						  .attr("width", x.rangeBand())
						  .attr("y", function(d) { return y(d.frequency); })
						  .attr("height", function(d) { return height - y(d.frequency); })
						  .on("mouseover", tip.show)
						  .on("mouseout", tip.hide);
						  
						  svg.append("svg:text")
						.attr("class", "aster-score")
						.attr("dy", "2.5em")
						.attr("text-anchor", "right") // text-align: right
						.text("CELSIUS");
						//.text(Math.round(score));
						
						//.html(function(d) {
						//return "<strong>GPU" + d.letter +": </strong>" + d.frequency;
						//});



					</script>
				';
					
				}else{
					
					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_status deadrig" data-toggle="tooltip" title="'.$rigstats["condition"].'"></div>
									<div class="riglist_cell table_rigloc"><span>'.$rigname.'</span><br/><span class="rack_loc">'.$rigstats["rack_loc"].'</span><br/><span class="in_brackets">'.$rigstats["ip"].'</span></div>
									<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									<div class="riglist_cell table_miner"><span class="miner">'.$rigstats["miner"].'</span></div>
									<div class="riglist_cell table_hash"><span>n/a</span></div>
									<div class="riglist_cell table_power"><span>n/a</span></div>
									<div class="riglist_cell table_power"><span>n/a</span></div>
									<div class="riglist_cell table_temp"><span>n/a</span></div>
									<div class="riglist_cell table_fanrpm"><span>n/a</span></div>
									<div class="riglist_cell table_pool"><span>n/a</span></div>
								</div>';
				}
				
				
				/*
				<div class="riglist_cell table_power"><strong>Efficiency</strong></div>
				<div class="riglist_cell table_power"><span>'.$datalyser->powerEfficiency($rigstats["watts"],$rigstats["miner_hashes"],$rigstats["gpus"]).'</span></div>
				*/

			echo $renderhtml;
				
		
				

			}
			//echo '<pre>' . print_r($datalyser->getTempArray($rigstats["temp"], true)) . '</pre>';
			//echo $temp_json;
			
		}
	function tempGauge($rigname, $agvtemp){
		/*
		echo '
		    <script>
			document.addEventListener("DOMContentLoaded", function(event) {

			  var g1 = new JustGage({
				id: "'.$rigname.'_temp",
				value: '.$agvtemp.',
				min: 0,
				max: 100,
				label: "Avg.",
				symbol: "C",
				pointer: true,
				gaugeWidthScale: 0.6,
				customSectors: [{
				  color: "#ff0000",
				  lo: 80,
				  hi: 100
				}, {
				  color: "#ff9900",
				  lo: 60,
				  hi: 80
				},{
				  color: "#ffff00",
				  lo: 40,
				  hi: 60
				}, {
				  color: "#00ff00",
				  lo: 0,
				  hi: 40
				}],
				counter: true
			  });

			});
			</script>';
		
		*/
		echo '<script>
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

		var svg = d3.select("#chart'.$rigname.'").append("svg")
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
			.text("&deg;C");

	</script>';
		/**
		echo "
			<script>
		      google.charts.load('current', {'packages':['gauge']});
			  google.charts.setOnLoadCallback(drawChart1);

			  function drawChart1() {

				var data1 = google.visualization.arrayToDataTable([
				  ['Label', 'Value'],
				  ['Temp', ".$agvtemp."]
				]);

				var options1 = {
				  width: 100, height: 100,
				  redFrom: 75, redTo: 100,
				  yellowFrom:65, yellowTo: 75,
				  majorTicks: ['0', '65', '75', '100'],
				  minorTicks: 5
				};
				var chart1 = new google.visualization.Gauge(document.getElementById('".$rigname."_temp'));
				chart1.draw(data1, options1);
      		}
			</script>'";
		*/

	}
	
	function fanGauge($rigname, $agvfan){

		echo "
			<script>
		      google.charts.load('current', {'packages':['gauge']});
			  google.charts.setOnLoadCallback(drawChart2);

			  function drawChart2() {

				var data2 = google.visualization.arrayToDataTable([
				  ['Label', 'Value'],
				  ['Fan', ".round($agvfan/1000,2)."]
				]);

				var options2 = {
				  width: 100, height: 100,
				  greenFrom: 1, greenTo: 3,
				  redFrom: 4, redTo: 5,
				  yellowFrom:3, yellowTo: 4,
				  majorTicks: ['1', '2', '3', '4', '5'],
				  minorTicks: 1,
				  min: 0,
				  max: 5
				};
				var chart2 = new google.visualization.Gauge(document.getElementById('".$rigname."_fan'));
				chart2.draw(data2, options2);
      		}
			</script>'";
		
	}
	
}
?>
