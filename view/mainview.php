<?php
class summaryBlock{
	function summaryMiner($miner, $algo, $label1){
		
		echo '
		      <div class="summary_miner">
              <h6>'.$label1.': '.$algo.' </h6>
              <h3 class="card-title miner_summary_head_'.$miner.'">'.$miner.'</h3>            	
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
	
}
?>
