<?php
session_start();

if (isset($_GET['id'])) {
  $ethos_id = $_GET['id'];
} else {
  exit();
}
  if($ethos_id){

      // $ethos_id = "165d38";
    //ok, so now lets make API call to fetch the data.

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

    $alldata = json_decode('['.$response.']', true);

    curl_close($curl);
    if (!$alldata || $err) {
      echo "Error";
      exit();
    } else {
      $_SESSION["id"] = $ethos_id;
    }
  }


?>