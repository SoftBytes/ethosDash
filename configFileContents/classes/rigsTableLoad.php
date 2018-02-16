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
   $totalRigs = $alldata[0];
   $allrigs = $alldata[0]["rigs"];

   $rigs = array_keys($allrigs);


   // display all rig stats in the long list
   foreach($allrigs as $rigname=>$rigstats){ ?>
   <tr>
     <td><input class="form-control font-weight-bold" id="<?= $rigname ?>_MinerID" type="text" value="<?= $rigname ?>" style="float: left; width: 60%; margin-right: 10px;" disabled><button class='minerSettings' id='<?= $rigname ?>' data-toggle="modal" data-target="#modalMiner" onclick="miners(this.id)">Settings</button></td>
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

  }
  ?>

    </tbody>
  </table>
  </div>