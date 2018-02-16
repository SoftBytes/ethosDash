<?php
  session_start();
  $ethos_id = $_SESSION["id"];



    if($ethos_id){

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://".$ethos_id.".ethosdistro.com/?json=yes",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);



    curl_close($curl);
    //ideally we need first make a call and see if ethosID is valid, and/or we're not getting errors, but for now I'll omit this part
    if ($err) {
      echo "<div class='container text-center'>
                       <p>cURL Error #:" . $err . "</p>
               </div>";
      exit();
    } else {

      //add square brackets to response so that silly PHP can expplode jason data into array
        $alldata = json_decode('['.$response.']', true);


        if (!$alldata || $err) {
          echo "
                <div class='container text-center'>
                       <p>ERROR! cannot find ethos id</p>
               </div>
          ";
          exit();
        }

    }
  }


      if ($alldata) {
        # code...
        $summary = $alldata[0]["per_info"];

        $jsonRigs = json_encode($alldata[0]['rigs']);

?>

<div class="summary_wrapper row text-center">

  <!-- start bootstrap container // insert all content within here -->
  <?php
      //summary - per_info

    if ($alldata) {
      # code...
      $summary = $alldata[0]["per_info"];

      $jsonRigs = json_encode($alldata[0]['rigs']);

      // echo "<script type='text/javascript'>console.log({$jsonRigs});</script>";



    foreach($summary as $algo_miner=>$sum_info){
  ?>
    <div class="card col m-4 bg-warning">
      <div class="card-block summary_block_<?= ($algo_miner) ?>">
            <h3 class="card-title miner_summary_head_<?= $algo_miner; ?>"><?= ($algo_miner=='claymore'||$algo_miner=='ethermine'?'Ethereum':'ZCash'); ?> </h3>
            <h5>Total Hash: <?= $sum_info["hash"]." ".($algo_miner=='claymore'?'MH/s':'Sol/s'); ?></h5>
            <h5>Total Rigs: <?= $sum_info["per_total_rigs"]; ?></h5>
            <h5>Offline: <?= $sum_info["per_total_rigs"]-$sum_info["per_alive_rigs"]; ?></h5>
            <span>Checked at: <?= date('H:i d/m', $sum_info["current_time"]); ?></span>
          </div> <!-- block summary end -->


      </div>

  <?php
    }

    }

  }


  ?>
</div> <!-- summary wrapper end -->