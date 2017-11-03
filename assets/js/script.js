function config() {

	var  miner1_MinerID = document.querySelector("#miner1_MinerID").value;
	var  miner1_Driver 	= document.querySelector("#miner1_Driver").value;
	var  miner1_vlt 	= document.querySelector("#miner1_vlt").value;
	var  miner1_pwr		= document.querySelector("#miner1_pwr").value;
	var  miner1_mem 	= document.querySelector("#miner1_mem").value;
	var  miner1_miner 	= document.querySelector("#miner1_miner").value;
	var  miner1_flg 	= document.querySelector("#miner1_flg").value;
	var  miner1_fan 	= document.querySelector("#miner1_fan").value;

	var  miner2_MinerID = document.querySelector("#miner2_MinerID").value;
	var  miner2_Driver 	= document.querySelector("#miner2_Driver").value;
	var  miner2_vlt 	= document.querySelector("#miner2_vlt").value;
	var  miner2_pwr 	= document.querySelector("#miner2_pwr").value;
	var  miner2_mem 	= document.querySelector("#miner2_mem").value;
	var  miner2_miner 	= document.querySelector("#miner2_miner").value;
	var  miner2_flg 	= document.querySelector("#miner2_flg").value;
	var  miner2_fan 	= document.querySelector("#miner2_fan").value;

	var  miner3_MinerID = document.querySelector("#miner3_MinerID").value;
	var  miner3_Driver 	= document.querySelector("#miner3_Driver").value;
	var  miner3_vlt 	= document.querySelector("#miner3_vlt").value;
	var  miner3_pwr 	= document.querySelector("#miner3_pwr").value;
	var  miner3_mem 	= document.querySelector("#miner3_mem").value;
	var  miner3_miner 	= document.querySelector("#miner3_miner").value;
	var  miner3_flg 	= document.querySelector("#miner3_flg").value;
	var  miner3_fan 	= document.querySelector("#miner3_fan").value;

	var  textArea 		= document.getElementById("outputText");

	function downloadURI(uri, name)
	{
	    var link = document.createElement("a");
	    link.download = name;
	    link.href = uri;
	    link.click();
	}


	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	   textArea.value = this.responseText;

	   textArea.style.height = "1px";
	   textArea.style.height = (25+textArea.scrollHeight)+"px";
	   downloadURI("config/config.txt","config.txt");

	  }
	};
	xhttp.open("GET", "process.php"
	+"?id1="+ miner1_MinerID
	+"&dr1="+ miner1_Driver
	+"&vl1="+ miner1_vlt
	+"&pw1="+ miner1_pwr
	+"&me1="+ miner1_mem
	+"&mi1="+ miner1_miner
	+"&fl1="+ miner1_flg
	+"&fa1="+ miner1_fan

	+"&id2="+ miner2_MinerID
	+"&dr2="+ miner2_Driver
	+"&vl2="+ miner2_vlt
	+"&pw2="+ miner2_pwr
	+"&me2="+ miner2_mem
	+"&mi2="+ miner2_miner
	+"&fl2="+ miner2_flg
	+"&fa2="+ miner2_fan

	+"&id3="+ miner3_MinerID
	+"&dr3="+ miner3_Driver
	+"&vl3="+ miner3_vlt
	+"&pw3="+ miner3_pwr
	+"&me3="+ miner3_mem
	+"&mi3="+ miner3_miner
	+"&fl3="+ miner3_flg
	+"&fa3="+ miner3_fan, true);
	xhttp.send();
}

