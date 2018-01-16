<?php

class wtmCalculator{
	
	public $api_response;	
	public $coininfo;
	public $defaults;
	
	public function coinsByAlgo($api_response){
		$algos=array();
		foreach ($api_response["coins"] as $coin=>$coininfo){
			
			$algos[$coininfo["algorithm"]][$coin]=array("id"=>$coininfo["id"],"tag"=>$coininfo["tag"],"nethash" => $coininfo["nethash"], "difficulty" => $coininfo["difficulty"],"difficulty24" => $coininfo["difficulty24"], "last_block" => $coininfo["last_block"], "exchange_rate" => $coininfo["exchange_rate"], "exchange_rate24" => $coininfo["exchange_rate24"], "btc_revenue" => $coininfo["btc_revenue"], "btc_revenue24" => $coininfo["btc_revenue24"], "profitability" => $coininfo["profitability"], "profitability24" => $coininfo["profitability24"], "timestamp" => $coininfo["timestamp"]);
		}
		$this->coininfo=$algos;
	}
	
	public function wtmDefaults(){
		$filecontent = file_get_contents("helpers/wtmdefaults.json");
		$json = json_decode($filecontent, true); // decode the JSON into an associative array
		$this->defaults = $json["data"];
	}
	
	public function getCoinRate($btc_revenue,$defrate,$urate){
		$rate = $btc_revenue*($urate/$defrate);
		return $rate;
	}
	
	
	
}


?>