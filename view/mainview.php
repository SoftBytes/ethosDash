<?php
/*---------------ethosDash@protonmail.com--------------------*/
/*----------------all IP rights reserver---------------------*/
/*************************************************************/
// Process HTML for main.php page

class summaryBlock{
	
	function summaryMiner($miner, $algo, $label1){
		
		echo '
		      <div class="summary_miner">
                  <h3 class="card-title miner_summary_head_'.$miner.'">'.$miner.'</h3>
				  <h6>'.$label1.': '.$algo.' </h6>
              </div>
		';
	}
	function summaryInfo($label, $value, $sublabel=NULL, $subvalue=NULL){
		
		$renderhtml = '
			<div class="summary_info"><span>'.$label.': '.$value;
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
		</div>
		<div  class="summary_block">
		      <div class="summary_miner">            
			  <h6>'.$labels["rigs"].':</h6>
				<h3 class="hash_mining"  data-toggle="tooltip" title="'.$labels["total_alive"].'">'.$totals["alive_rigs"].'/'.$totals["total_rigs"].'</h3>
				
				<h6>'.$labels["gpus"].':</h6>
				<h3 class="hash_mining" data-toggle="tooltip" title="'.$labels["total_alive"].'">'.(is_null($totals["alive_gpus"])?"0":$totals["alive_gpus"]).'/'.$totals["total_gpus"].'</h3>
              </div>
		</div>
		';	
			//  '.($totals["alive_rigs"] < $totals["total_rigs"]?'alive_units_low':'alive_units_max').'           

	}
	
		function totalPower($totals, $labels){

		echo '
		<div  class="summary_block">
		      <div class="summary_miner">
            <h6>'.$labels["hashrate"].':</h6>  
            <h3 class="hash_mining">'.$totals["hashrate"].'</h3>
			<h6>'.$labels["capacity"].':</h6>
			<h3 class="hash_mining">'.$totals["capacity"].'%</h3>
			
              </div>
		</div>
		<div  class="summary_block">
		      <div class="summary_miner">            
			  <h6>'.$labels["rigs"].':</h6>
				<h3 class="hash_mining"  data-toggle="tooltip" title="'.$labels["total_alive"].'">'.$totals["alive_rigs"].'/'.$totals["total_rigs"].'</h3>
				
				<h6>'.$labels["gpus"].':</h6>
				<h3 class="hash_mining" data-toggle="tooltip" title="'.$labels["total_alive"].'">'.$totals["alive_gpus"].'/'.$totals["total_gpus"].'</h3>
              </div>
		</div>
		';	
			//  '.($totals["alive_rigs"] < $totals["total_rigs"]?'alive_units_low':'alive_units_max').'           

	}
	

	
}
class rigsTable{
	
	
		function rigslistHeader(){
			
			echo '<div class="riglist_row">
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
			
			
		}
	
		function rigslist($per_rig_info){
			foreach($per_rig_info as $rigname=>$rigstats){
				//condition options: mining, unreachable, rofs, no_hash, overload
				if($rigstats["condition"]!="unreachable"){
					
					$datalyser = new analyseJSON();

					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									<div class="riglist_cell table_rigloc" data-toggle="tooltip" title="'.$rigstats["condition"].'"><span>'.$rigname.'</span><br/><span>'.$rigstats["rack_loc"].'</span><br/><span  class="in_brackets">'.$rigstats["ip"].'</span></div>
									<div class="riglist_cell table_miner"><span class="miner">'.$rigstats["miner"].'</span></div>
									<div class="riglist_cell table_hash hash_mining"  data-toggle="tooltip" title="Hashrate: '.$datalyser->getTooltip($rigstats["miner_hashes"]).'"><span>'.$rigstats["hash"].'</span></div>
									<div class="riglist_cell table_power power_consumes" data-toggle="tooltip" title="Power Usage: '.$datalyser->getTooltip($rigstats["watts"]).'"><span>'.$datalyser->rigPower($rigstats["watts"],$rigstats["gpus"]).'</span></div>
									<div class="riglist_cell table_power power_eff"><span>'.$datalyser->powerEfficiency($rigstats["watts"],$rigstats["miner_hashes"],$rigstats["gpus"],$rigstats["miner_instance"]).'</span></div>
					<div class="riglist_cell gauge" id="'.$rigname.'_temp" data-toggle="tooltip" title="Temperature: '.$datalyser->getTooltip($rigstats["temp"]).'">'.$this->tempGauge($rigname,$datalyser->avgTemp($rigstats["temp"])).'</div>
									<div class="riglist_cell table_fanrpm" data-toggle="tooltip" title="Fan Speed: '.$datalyser->getTooltip($rigstats["fanrpm"]).'"><span>'.$datalyser->avgTemp($rigstats["fanrpm"]).'</span></div>
									<div class="riglist_cell table_pool"><span>'.$rigstats["pool"].'</span></div>
								</div>';
				}else{
					
					$renderhtml = '<div class="riglist_row">
									<div class="riglist_cell table_driver" data-toggle="tooltip" title="'.$rigstats["meminfo"].'"><span class="'.$rigstats["driver"].'">&nbsp;</span></div>
									<div class="riglist_cell table_rigloc" data-toggle="tooltip" title="'.$rigstats["condition"].'"><span>'.$rigname.'</span><br/><span>'.$rigstats["rack_loc"].'</span><br/><span class="in_brackets">'.$rigstats["ip"].'</span></div>
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
		}
	function tempGauge($rigname, $agvtemp){
		
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
		
	}
}
?>
