<?php

	class viewIntro{
		
		function renderIntro($welcome, $intro, $ethos, $step1, $step2, $step3){
			
			echo ('<div id="intro" class="jumbotron jumbotron-fluid text-center bg-success text-white">
				  <h1>'.$welcome.'</h1>
				  <h5>'.$intro.' <strong>'.$ethOS.'</strong></h5>
					<div class="easy_steps">	  
						  <ol style="text-align: left;">
							  <li>'.$step1.'</li>
							  <li>'.$step2.'</li>
							  <li>'.$step3.'</li>
						  </ol>
					</div>
				</div>');
		}
		
	}

?>