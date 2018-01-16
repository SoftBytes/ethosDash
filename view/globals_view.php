<?php
  
class displayGlobals {
	
	public function displayList(){
			echo "
				<select class='form-control select'><option value='globalminer'>globalminer</option><option value='maxgputemp'>maxgputemp</option><option value='stratumproxy'>stratumproxy</option><option value='proxywallet'>proxywallet</option><option value='proxypool1'>proxypool1</option><option value='proxypool2'>proxypool2</option><option value='poolpass1'>poolpass1</option><option value='poolpass2'>poolpass2</option><option value='flags'>flags</option><option value='globalcore'>globalcore</option><option value='globalmem'>globalmem</option><option value='globalfan'>globalfan</option><option value='globalpowertune'>globalpowertune</option><option value='autoreboot'>autoreboot</option><option value='custompanel'>custompanel</option><option value='lockscreen'>lockscreen</option><option value='globaldesktop'>globaldesktop</option></select>
			";
		
		
	}
}
?>