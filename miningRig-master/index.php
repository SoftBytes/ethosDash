<?php
  session_start();
  $ethos_id = $_SESSION["id"];

  if (!isset($_SESSION["id"])) {
    header("location:./login.php");
    exit();
  }
?>

<?php require './inc/header.php'; ?>

<?php require './inc/jumbotron.php'; ?>

<div class="container-fluid">

    <!-- Modified by Alex to add dynimac data from CURL-->

    <?php

    // first fetch main miner address from GET parameter if present in URL and show config table with the rest of the page
    // otherwise - display message Cannot find specified ETHOS ID

    // $ethos_id = isset($_GET['id']) ? $_GET['id'] : '165d38';

    if($ethos_id){

    // $ethos_id = "165d38";
    // ok, so now lets make API call to fetch the data.

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

      //   jason data translates into following data/arrays
      //   alldata[0] - array containg entire response
      //   alldata[0][rigs] - 2 dimensional array [rig name][rig statistics]
      //   alldata[0][total_hash] - value
      //   alldata[0][alive_gpus]  - value
      //   alldata[0][total_gpus] - value
      //   alldata[0][alive_rigs] - value
      //   alldata[0][total_rigs] - value
      //   alldata[0][current_version] - value
      //   alldata[0][avg_temp] - value
      //   alldata[0][capacity] - value
      //   alldata[0][per_info] - 2 dimensional array [miner name][miner statistics]

      // echo raw jason
      // echo $response;
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
  //for now I'm just spitting raw HTML inside php, but we should rather have proper HTML wraping
  else{
    echo "Cannot find your ethOS ID! Please make sure you have added it to URL.";
  }
  ?>
  <div class="summary_wrapper row text-center">

    <!-- start bootstrap container // insert all content within here -->
    <?php
        //summary - per_info

      if ($alldata) {
        # code...
        $summary = $alldata[0]["per_info"];

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
    ?>
  </div> <!-- summary wrapper end -->

 <div class="table-responsive">
   <table class="table table-striped">
     <thead>
       <tr>
         <th>Miner ID</th>
         <th>Driver</th>
         <th>Voltage</th>
         <th>Power</th>
         <th>Memory</th>
         <th>Miner</th>
         <th>Flag</th>
         <th>Fan</th>
       </tr>
     </thead>
     <tbody>
               <!-- Display Rigs Info insid e table -->
        <?php
        if ($alldata) {
  $allrigs = $alldata[0]["rigs"];
  // display all rig stats in the long list
  foreach($allrigs as $rigname=>$rigstats){ ?>
    <tr>
      <td><input class="form-control font-weight-bold" id="<?= $rigname ?>_MinerID" type="text" value="<?= $rigname ?>" disabled></td>
      <td><input class="form-control" id="<?= $rigname ?>_driver" type="text" value="<?= $rigstats["driver"] ?>"> </td>
      <td><input class="form-control" id="<?= $rigname ?>_vlt" type="text" value="<?= $rigstats["voltage"] ?>"></td>
      <td><input class="form-control" id="<?= $rigname ?>_pwr" type="text" value="<?= $rigstats["powertune"] ?>">
      <td><input class="form-control" id="<?= $rigname ?>_mem" type="text" value="<?= $rigstats["mem"] ?>"></td>
      <td><input class="form-control" id="<?= $rigname ?>_miner" type="text" value="<?= $rigstats["miner"] ?>"></td>
      <td><input class="form-control" id="<?= $rigname ?>_flg" type="text" value="<?= $rigstats["core"] ?>"></td>
      <td><input class="form-control" id="<?= $rigname ?>_fan" type="text" value="<?= $rigstats["fanrpm"] ?>"></td>
    </tr>

  <?php }
    }
   ?>

     </tbody>
   </table>
   </div>
</div>
   <div class="container text-center mt-4">
    <button class="btn btn-primary" onclick="config()">Download Config File</button>
     <div class="form-group mt-4">
         <label for="exampleTextarea">Text output</label>
         <textarea class="form-control" id="outputText" rows="3"></textarea>
     </div>
    </div>
<?php require './inc/footer.php'; ?>