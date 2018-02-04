<?php

class wtmCalculator{
	
	public $api_response;	
	public $coininfo;
	public $coinsorted;
	public $defaults;
	
	public function coinsByAlgo($api_response){
		$algos=array();
		foreach ($api_response["coins"] as $coin=>$coininfo){
			
			$algos[$coininfo["algorithm"]][$coin]=array("id"=>$coininfo["id"],"tag"=>$coininfo["tag"],"nethash" => $coininfo["nethash"], "difficulty" => $coininfo["difficulty"],"difficulty24" => $coininfo["difficulty24"], "last_block" => $coininfo["last_block"], "exchange_rate" => $coininfo["exchange_rate"], "exchange_rate24" => $coininfo["exchange_rate24"], "btc_revenue" => $coininfo["btc_revenue"], "btc_revenue24" => $coininfo["btc_revenue24"], "profitability" => $coininfo["profitability"], "profitability24" => $coininfo["profitability24"], "timestamp" => $coininfo["timestamp"],"estimated_rewards"=>$coininfo["estimated_rewards"],"difficulty"=>$coininfo["difficulty"], "difficulty24"=>$coininfo["difficulty24"], "nethash"=>$coininfo["nethash"],"algorithm"=>$api_response["coins"][$coin]["algorithm"]);
		}
		$this->coininfo=$algos;
	}
	
	public function coinsSorted($coinsforalgo){
		$coins=array();
		$forsort=array();
		foreach ($coinsforalgo as $coin=>$coininfo){
			
			
			$forsort[$coin] = $coininfo["btc_revenue"];
			//sort in rverse order
			arsort($forsort);
		}
		foreach($forsort as $coin=>$rev){
			$coins[$coin]=array("id"=>$coinsforalgo[$coin]["id"],"tag"=>$coinsforalgo[$coin]["tag"],"nethash" => $coinsforalgo[$coin]["nethash"], "difficulty" => $coinsforalgo[$coin]["difficulty"],"difficulty24" => $coinsforalgo[$coin]["difficulty24"], "last_block" => $coinsforalgo[$coin]["last_block"], "exchange_rate" => $coinsforalgo[$coin]["exchange_rate"], "exchange_rate24" => $coinsforalgo[$coin]["exchange_rate24"], "btc_revenue" => $coinsforalgo[$coin]["btc_revenue"], "btc_revenue24" => $coinsforalgo[$coin]["btc_revenue24"], "profitability" => $coinsforalgo[$coin]["profitability"], "profitability24" => $coinsforalgo[$coin]["profitability24"], "timestamp" => $coinsforalgo[$coin]["timestamp"],"estimated_rewards"=>$coinsforalgo[$coin]["estimated_rewards"],"difficulty"=>$coinsforalgo[$coin]["difficulty"], "difficulty24"=>$coinsforalgo[$coin]["difficulty24"], "nethash"=>$coinsforalgo[$coin]["nethash"],"algorithm"=>$coinsforalgo[$coin]["algorithm"]);
		}
		return $coins;
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
	public function get1BTCdays( $coinsbyAlgo, $hashbyAlgo, $defaults){
		$user_btc_rev=0;
		$btc_summary = array();
		foreach($hashbyAlgo as $algo=>$rate){
			$defrate = $defaults[$algo];
			$btc_rev_array = array();
			foreach($coinsbyAlgo[$algo] as $coin=>$coininfo){
				$btc_rev_array[$coin]= $coininfo["btc_revenue"];
			}
			$highest_btc = max($btc_rev_array);
			$highest_coin = array_search($highest_btc, $btc_rev_array);
			$user_btc_rev += $highest_btc*($rate/$defrate);
		}
		$days = round(1/$user_btc_rev,1);
		$btc_summary["total_rev"] = $user_btc_rev;
		$btc_summary["days"] = $days;
		return $btc_summary;
	}
	
	public function get1BTCdays2($coinsbyAlgo, $hashbyAlgo){
		$user_btc_rev=0;
		$btc_summary = array();
		foreach($hashbyAlgo as $algo=>$rate){
			$btc_rev_array = array();
			foreach($coinsbyAlgo[$algo] as $coin=>$coininfo){
				$btc_rev_array[$coin]= $coininfo["btc_revenue"];
			}
			$highest_btc = max($btc_rev_array);
			$highest_coin = array_search($highest_btc, $btc_rev_array);
			$user_btc_rev += $highest_btc;
		}
		$days = round(1/$user_btc_rev,1);
		$btc_summary["total_rev"] = $user_btc_rev;
		$btc_summary["days"] = $days;
		return $btc_summary;
	}
	
		
}


?>