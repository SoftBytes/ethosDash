<?php
/*---------------ethosDash@protonmail.com--------------------*/
/*----------------all IP rights reserver---------------------*/
/*************************************************************/
// Process HTML for main.php page

class summaryBlock{
	
	function summaryMiner($miner, $algo, $label1){
		//echo '<h5>'.$label1.'</h5>';
		echo '<h3 class="card-title hashminer">'.$miner.'</h3>';
	}
	

	function minerPool($miner){
		foreach($miner as $minerpool=>$info){
			$pool_link=substr($minerpool, strpos($minerpool,".")+1,strlen($minerpool));
			//$hash=0;
			echo '<h5><a class="pool_link" href="http://'.$pool_link.'"  target="new">'.$minerpool.'</a></h5>';
/*				foreach($info as $rig=>$hashrate){
					echo '<span>'.$rig.': </span><span>'.$hashrate.'</span><br/>';
				}*/
		}

	}
	function totalInfo($totals, $labels){

		echo '
            <h5>'.$labels["hashrate"].':</h5>  
            <h3 class="hash_mining">'.$totals["hashrate"].'&nbsp;<span class="hash_mining hash_mining_units">xH/s</span></h3>
	';
}
	
	
		function sumhashInfo($stats){
			foreach($stats as $statname=>$value){
				$this->displayHashStats($statname,$value);
			}
		}
	
		function displayHashStats($label, $value, $sublabel=NULL, $subvalue=NULL){
		$subvalue = algoUnits($label);
		$renderhtml = '
			<h5>'.$label.':</h5>';
		$renderhtml.='<h3 class="hash_mining">'.$value;	
		//	'.$value;
		//if(!is_null($subvalue))
			$renderhtml.='&nbsp;<span class="hash_mining hash_mining_units">'.$subvalue.'</span>';
		if(!is_null($sublabel)) $renderhtml.=' '.$sublabel.'</h3>';
		else $renderhtml.='</h3>';

		echo $renderhtml;
			//<h3 class="hash_mining">'.$totals["hashrate"].'</h3>
	}
	

	
}
class rigsTable{
	
		public $data;
		public $labels;
	
		function __construct($data, $labels) {
		  	$this->data=$data;
			$this->labels=$labels;
		}
	
		function statsRigsGpus($rigs_gpus){
			echo '<div class="rigs_gpu_block">';
				echo '<span class="rig_gpu_info">'.$rigs_gpus['rig_label'].': </span>';

				if($rigs_gpus['alive_rigs'] < $rigs_gpus['total_rigs']){
					echo	'<span class="hash_mining hash_mining_units alive_units_low">'.$rigs_gpus['alive_rigs'].'/'.$rigs_gpus['total_rigs'].'</span>&nbsp; ';
				}else{
					echo	'<span class="hash_mining hash_mining_units alive_units_max">'.$rigs_gpus['alive_rigs'].'/'.$rigs_gpus['total_rigs'].'</span>&nbsp;  ';
				}
				echo '<span class="rig_gpu_info">'.$rigs_gpus['gpu_label'].': </span>';

				if(($rigs_gpus['alive_gpus']==''?0:$rigs_gpus['alive_gpus'])<$rigs_gpus['total_gpus']){
					echo '<span class="hash_mining hash_mining_units alive_units_low">'.($rigs_gpus['alive_gpus']==''?0:$rigs_gpus['alive_gpus']).'/'.$rigs_gpus['total_gpus'].'</span>&nbsp; ';
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
	
		function poolLink($pool){
				$pool_link=substr($pool, strpos($pool,".")+1,strpos($pool,":")-strpos($pool,".")-1);
				return '<a class="pool_link" href="http://'.$pool_link.'"  target="new">'.$pool_link.'</a>';

		}
	
		function displayGPUinfo($gpuinfo, $gpunum){
			$gpulist=array();
			$html='';
			if(sizeof($gpuinfo)>1){
				foreach($gpuinfo as $key=>$gpuname){
					if(!isset($gpulist[$gpuname])) $gpulist[$gpuname]=1;
					else $gpulist[$gpuname]+=1;					
						//if($key<(sizeof($gpuinfo)-1)) $gpulist.=', ';
				}
				foreach($gpulist as $name=>$many)
					$html.=$many.' x '.$name.'<br/>';
			}else{
					$html.=$gpunum.' '.$gpuinfo[0];
				}
			return $html;
		}
	
		function rigslist($per_rig_info){
			$datalyser = new analyseJSON();
			$gpuinfo = $datalyser->getAllGPU($per_rig_info);
			foreach($per_rig_info as $rigname=>$rigstats){
				//condition options: mining, unreachable, rofs, no_hash, overload
				if($rigstats["condition"]!="unreachable"){
					
					//$datalyser = new analyseJSON();

					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_status '.($rigstats["condition"]=="mining"?'liverig':'slowrig').'" data-toggle="tooltip" title="'.$rigstats["condition"].'"></div>';
					if($rigstats["rack_loc"]){
						$renderhtml .=	'<div class="riglist_cell table_rigloc">
									<span class="rack_loc">'.$rigstats["rack_loc"].'</span><br/><img src="assets/images/'.($rigstats["driver"]=='nvidia'?'nvidia_geforce':'amd_radeon').'.png"></div>';
					}else{
						$renderhtml .=	'<div class="riglist_cell table_rigloc">
									<span class="rack_loc">'.$rigname.'</span><br/><img src="assets/images/'.($rigstats["driver"]=='nvidia'?'nvidia_geforce':'amd_radeon').'.png"></div>';
					}				

									/*
									<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									*/
									
					$renderhtml .='<div class="riglist_cell table_hash"  data-toggle="tooltip" title="Hashrate: '.$datalyser->getTooltip($rigstats["miner_hashes"]).'"><span class="rack_loc">'.$rigstats["miner"].'</span><br/><span class=" hash_mining">'.$rigstats["hash"].'</span> <span class="hash_mining hash_mining_units">'.algoUnits(get_algo($rigstats["miner"])).'</span><br/><span>'.$this->poolLink($rigstats["pool"]).'</span></div>';
					
					$renderhtml .=	'<div class="riglist_cell table_gpu"><span class="rack_loc">GPU INFO</span><br/><span>'.$this->displayGPUinfo($gpuinfo[$rigname],$rigstats["gpus"]).'</span></div>';
	
					$renderhtml .=	'<div class="riglist_cell table_temp"><div><span class="rack_loc">TEMP</span></div><div class="tempgraph" id="temp'.$rigname.'"></div></div>
					<div class="riglist_cell table_fanrpm"><div><span class="rack_loc">FAN</span></div><div id="fan'.$rigname.'"  class="fangraph"></div></div>
					<div class="riglist_cell table_power" data-toggle="tooltip" title="Power Usage: '.$datalyser->getTooltip($rigstats["watts"]).'"><span class="rack_loc">'.$this->labels["label17"].'</span><br/><span class="power_consumes">'.$datalyser->rigPower($rigstats["watts"],$gpuinfo[$rigname],$rigstats["gpus"]).'</span><span class="  power_consumes_units"> kWt</span></div>
								</div>';
					//<div class="riglist_cell table_power power_eff"><span>'.$datalyser->powerEfficiency($rigstats["watts"],$rigstats["miner_hashes"],$rigstats["gpus"],$rigstats["miner_instance"]).'</span></div>

					
				}else{
					
					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_status deadrig" data-toggle="tooltip" title="'.$rigstats["condition"].'"></div>';
					if($rigstats["rack_loc"]){
						$renderhtml .=	'<div class="riglist_cell table_rigloc">
									<span class="rack_loc">'.$rigstats["rack_loc"].'</span><br/><img src="assets/images/'.($rigstats["driver"]=='nvidia'?'nvidia_geforce':'amd_radeon').'.png"></div>';
					}else{
						$renderhtml .=	'<div class="riglist_cell table_rigloc">
									<span class="rack_loc">'.$rigname.'</span><br/><img src="assets/images/'.($rigstats["driver"]=='nvidia'?'nvidia_geforce':'amd_radeon').'.png"></div>';
					}				
					/*$renderhtml .=	'<div class="riglist_cell table_rigloc">
									<span class="rack_loc">'.$rigstats["rack_loc"].'</span><br/><span>'.$rigname.'</span><br/><span  class="in_brackets">'.$rigstats["ip"].'</span></div>';
					
					<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									</div>*/
									
					$renderhtml .='<div class="riglist_cell table_hash"  data-toggle="tooltip" title="Hashrate: '.$datalyser->getTooltip($rigstats["miner_hashes"]).'"><span class="rack_loc">'.$rigstats["miner"].'</span><br/><span class=" hash_mining">'.$rigstats["hash"].'</span> <span class="hash_mining hash_mining_units">'.algoUnits(get_algo($rigstats["miner"])).'</span><br/><span>'.$this->poolLink($rigstats["pool"]).'</span></div></div>';
				}
						$temp_json = json_encode($datalyser->getTempArray($rigstats["temp"]));
						$fan_json = json_encode($datalyser->getFanArray($rigstats["fanrpm"]));
						//echo $temp_json;	
									   
			$renderhtml .= '<script>
					var width = 100,
						height = 100,
						radius = Math.min(100, 100) / 2,
						innerRadius = 0.4 * radius,
						cornerRadius = 5,
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
						//d.score  = +d.score;
							  if(d.score < 5){
								  d.score = 10;
							  }else{
								  d.score  = +d.score;
							  }
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
						  .attr("fill", "#00FC00")
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
						.text("'.$this->labels["label18"].'");
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
						.attr("dy", "2.5em")
						.attr("text-anchor", "right") // text-align: right
						.text("'.$this->labels["label20"].'");
						//.text(Math.round(score));
						
						//.html(function(d) {
						//return "<strong>GPU" + d.letter +": </strong>" + d.frequency;
						//});



					</script>
				';
				
				/*
				<div class="riglist_cell table_power"><strong>Efficiency</strong></div>
				<div class="riglist_cell table_power"><span>'.$datalyser->powerEfficiency($rigstats["watts"],$rigstats["miner_hashes"],$rigstats["gpus"]).'</span></div>
				*/

			echo $renderhtml;
			//echo '<pre>' . print_r($gpuinfo[$rigname], true) . '</pre>';
				
		
				

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
