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
			 if (isset($algos[$algo_key])) $algos[$algo_key]+=$value['hash'];
			 else {
				 $algos[$algo_key]=0;
				 $algos[$algo_key]+=$value['hash'];
			 }
			 
		 }
		 
		 return $algos;
	 }
	
	function powerbyAlgo($rigs){
		$algos=array();
		$algo_key='';
		$gpuinfo = $this->getAllGPU($rigs);
		
		foreach($rigs as $rig=>$rigsdata){
			$algo_key=get_algo($rigsdata["miner"]);
			
			$rigpower= $this->rigPower($rigsdata["watts"], $gpuinfo[$rig],$rigsdata["gpus"]);
			
			if(isset($algos[$algo_key])) $algos[$algo_key]+=round($rigpower*1000,1);
			else {
				$algos[$algo_key]=0;
				$algos[$algo_key]+=round($rigpower*1000,1);
			}
		}
		return $algos;
	}
	
	function minerPools($rigs){
		
		$miners=array();
		
		foreach($rigs as $rig=>$data){
			
			$pool=substr($data['pool'], 0 ,strpos($data['pool'],':'));
			$miners[$data['miner']][$pool][$rig]=$data['hash'];						
		}
		
		return $miners;
	}
	
	function powerEfficiency($gpuwatts, $minerhashes){
		
		$power_eff = round($minerhashes/($gpuwatts*1000),2);
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
	
	function rigPower($gpuwatts, $gpus, $gpunum){
		//aproxpower of motherboard an			
		$total_power = 100;
		//this is for AMD cards that don't report watts/usage instead we use approximate value of 100Wt
		if($gpuwatts==0 || is_null($gpuwatts) || $gpuwatts==""){
			
			$gpu_json = file_get_contents("model/gpu-info.json");
			$gpu_info = json_decode($gpu_json, true);
			if(sizeof($gpus)>1){
				foreach($gpus as $gpuname){
					$total_power+=$gpu_info["gpu"][$gpuname]["TDP"];
				}
			}else{
				for($i=0;$i<$gpunum;$i++){
					$total_power+=100;
				}
			}
			//$this->pageTitle  = self::getPageTitle();
			
		}else{
			$watts = explode(" ",$gpuwatts);

			foreach($watts as $consuming){
				$total_power +=$consuming;
			}
		}
		return round($total_power/1000,1);
	}
	
	function totalPower($allrigs){
		$gpuinfo = $this->getAllGPU($allrigs);
		$sum_power=0;
		foreach ($allrigs as $rigname=>$rigstats){
			$sum_power+=$this->rigPower($rigstats["watts"],$gpuinfo[$rigname],$rigstats["gpus"]);
		}
		return $sum_power;
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
	
	
	function getAllGPU($rigs){
		$gpus = array();
		foreach($rigs as $rig=>$rigsdata){
			//array with all data,but need only value starting from index 2 and then vevery fifth index after
			if($rigsdata["meminfo"]){
				$rawinfo=explode("\n",$rigsdata["meminfo"]);

				foreach($rawinfo as $i=>$gpuinfo){
					if(strpos($rawinfo[$i],"GeForce")>0){
	$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"GTX"),strpos($rawinfo[$i],":",strpos($rawinfo[$i],"GTX"))-(strpos($rawinfo[$i],"GTX")));
					}elseif(strpos($rawinfo[$i],"P10")>0){
	$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"P10"),strpos($rawinfo[$i],":",strpos($rawinfo[$i],"P10"))-(strpos($rawinfo[$i],"P10")));					
					}elseif(strpos($rawinfo[$i],"R7")>0){
	$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"R7"),strpos($rawinfo[$i],":",strpos($rawinfo[$i],"R7"))-(strpos($rawinfo[$i],"HD")));
					}elseif(strpos($rawinfo[$i],"R9")>0){
	$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"R9"),strpos($rawinfo[$i],":",strpos($rawinfo[$i],"R9"))-(strpos($rawinfo[$i],"R9")));
					}
					elseif(strpos($rawinfo[$i],"RX")>0){
	$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"RX"),strpos($rawinfo[$i],":",strpos($rawinfo[$i],"RX"))-(strpos($rawinfo[$i],"RX")));
					}
				}
			}else{
				$gpus[$rig][0]="Unknown GPUs";
			}
			//$gpunumber=1;
			//$searchindex = 2;
			//for($i=0; $i < sizeof($rawinfo); $i++){
				
				//$gpus[$rig][$i]="Detected";
				//if(strpos($rawinfo[$i],"GeForce")>0){
					//$gpus[$rig][$i]="NVidia";
//$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"GeForce")+7,strpos($rawinfo[$i],":",strpos($rawinfo[$i],"GeForce")));
				//}else{
//$gpus[$rig][$i]=substr($rawinfo[$i],strpos($rawinfo[$i],"Radeon")+7,strpos($rawinfo[$i],":",strpos($rawinfo[$i],"Radeon")));						
				//	$gpus[$rig][$i]="Radeon";
				//}
				//extract gpu nameby index number
				//if($i == $searchindex){
					//$gpus[$rig][$gpunumber] = $rawinfo[$i];
					//$searchindex+=6;
					//$gpunumber++;
				//}
			//}
			//$gpus[$rig] = $rawinfo;
			
		}
		return $gpus;
	//}
	}
	
}
