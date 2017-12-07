<?php
/*---------------ethosDash@protonmail.com--------------------*/
/*----------------all IP rights reserver---------------------*/
/*************************************************************/

/*                  JSON data analysing                      */
/************************************************************/

class analyseJSON{
	
	 function sumbyAlgo($minershash){
		 $algos=array();
		 $algo_key='';
		 foreach($minershash as $key=>$value){
			 $algo_key=get_algo($key);
			 if (isset($algos[$algo_key])) $algos[$algo_key]+=$value['per_hash-rig'];
			 else {
				 $algos[$algo_key]=0;
				 $algos[$algo_key]+=$value['per_hash-rig'];
			 }
			 
		 }
		 
		 return $algos;
	 }
	
	function powerEfficiency($gpuwatts, $minerhashes, $gpus, $miner_instances){
		
		//this is for AMD cards that don't report watts/usage instead we use approximate value of 100Wt
		if($gpuwatts==0 || is_null($gpuwatts) || $gpuwatts==""){
			
			$watts = array();
			for($m=0; $m < $gpus; $m++){
				$watts[$m] = 100;
			}
			
		}else{
			
			$watts = explode(" ",$gpuwatts);	
		}
		
		// check GPU mining instances, if no GPUs are in mining mode overwrite hashrate with 0
		if($miner_instances!=""){
			$hashes = explode(" ", $minerhashes);
		}
		else{
			$hashes = array();
			for($g=0; $g < $gpus; $g++){
				$hashes[$g] = 0;
			}
		}
		
		
		$power = 0;
		
		for($i=0; $i < $gpus; $i++){
			
			$power+=$hashes[$i]/$watts[$i];
			
		}
		$power_eff = round($power/$gpus,2);
		return $power_eff;
	}
	
	function avgTemp($rigtemps){
		$temp_analyse = explode(" ",$rigtemps);
				$temp_sum=0;
				foreach($temp_analyse as $temp){
					$temp_sum+=$temp;
				}
				$temp_avg=round($temp_sum/sizeof($temp_analyse),0);
		
		return $temp_avg;
	}
	
	function rigPower($gpuwatts, $gpus){
					$total_power = 0;
		//this is for AMD cards that don't report watts/usage instead we use approximate value of 100Wt
		if($gpuwatts==0 || is_null($gpuwatts) || $gpuwatts==""){
			
			
			$total_power=(100*$gpus);
			
		}else{
			$watts = explode(" ",$gpuwatts);

			foreach($watts as $consuming){
				$total_power +=$consuming;
			}
		}
		return round($total_power,0);
	}
	
	function fanRPM($fanrpm){
				$fan_analyse = explode(" ",$fanrpm);
				$fan_sum=0;
				foreach($fan_analyse as $fan){
					$fan_sum+=$fan;
				}
				$fan_avg=round($fan_sum/sizeof($fan_analyse),0);
		
		return $fan_avg;
	}
	function getTooltip($datastring){
		$tooltip="\r\n";
		$data_array= explode(" ",$datastring);
		foreach($data_array as $key=>$value){
			$tooltip.="GPU".$key.": ".$value."\r\n";
		}
		return $tooltip;
	}
	
	function getTempArray($datastring){
		$GPU_NUM = 1;
		$tempArray = array();
		$data_array= explode(" ",$datastring);
		foreach($data_array as $key=>$value){
			
			$tempArray[]=array("letter"=>$GPU_NUM, "frequency"=>round($value,0), "class"=>"t".round($value,0));
			//$tooltip.="GPU".$key.": ".$value."\r\n";
			$GPU_NUM++;
		}
		return $tempArray;
			

	}
	
		function getFanArray($datastring){
		$GPU_NUM = 1;
		$fanArray = array();
		$data_array= explode(" ",$datastring);
		foreach($data_array as $key=>$value){
			$fanArray[]=array("id"=>$GPU_NUM, "order"=>1, "score"=>round($value,0), "weight"=> 1, "class"=>"t".round($value,0), "label"=> "GPU".$GPU_NUM);
			//$tooltip.="GPU".$key.": ".$value."\r\n";
			$GPU_NUM++;
		}
		return $fanArray;
	}
	
	function totalPower($all_rigs){
		$total_power=0;
		foreach($all_rigs as $rigdata){
			
			$total_power+=rigPower($rigdata["watts"], $rigdata["gpus"]);
		}
		return $total_power;
	}
	
}
