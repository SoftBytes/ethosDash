<?php

session_start();
echo $ethos_id = $_SESSION["id"];

$minerID = $_GET["minerID"];
$json = json_decode($_GET["json"], true);

$minerString = "
cor " . $minerID . "";
foreach ($json["cor"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
fan " . $minerID . "";
foreach ($json["fan"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
mem " . $minerID . "";
foreach ($json["mem"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
vlt " . $minerID . "";
foreach ($json["vlt"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
pwr " . $minerID . "";
foreach ($json["pwr"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
reb "          . $minerID . " " . $json['reb'] . "
mxt "          . $minerID . " " . $json['mxt'] . "
loc "          . $minerID . " " . $json['loc'] . "
sel "          . $minerID . "";
foreach ($json["sel"] as $key => $value) {
  $minerString .= " $value";
}
$minerString .= "
desktop "      . $minerID . " ";
if ($json['desktop'] == true) {
  $minerString .= "enabled";
} else{
  $minerString .= "disabled";
}
$minerString .= "
name "         . $minerID . " ";
if ($json['name'] == true) {
  $minerString .= "enabled";
} else{
  $minerString .= "disabled";
}
$minerString .= "
driverless "   . $minerID . " ";
if ($json['driverless'] == true) {
  $minerString .= "enabled";
} else{
  $minerString .= "disabled";
}
$minerString .= "
#off "         . $minerID . "
wallet "       . $minerID . " " . $json['wallet'] . "
rigpool1 "     . $minerID . " " . $json['rigpool1'] . "
rigpool2 "     . $minerID . " " . $json['reb'] . "
rigpoolpass1 " . $minerID . " " . $json['rigpoolpass1'] . "
rigpoolpass2 " . $minerID . " " . $json['rigpoolpass2'] . "
miner "        . $minerID . " " . $json['miner'] . "
flg "          . $minerID . " --cl-local-work " . $json['--cl-local-work'] . " --cl-global-work " . $json['--cl-global-work'] . " --farm-recheck " . $json['--farm-recheck'] . "

";

if (!file_exists("../configFiles/" . $ethos_id)) {
  mkdir("../configFiles/" . $ethos_id);
}

if (!file_exists("../configFiles/" . $ethos_id . "/config.txt")) {

  require './regex.class.php';

  // $saveGlobalsToFile = new RegexGlobals($ethos_id);
  // $jsonDecoded = json_decode($_GET['string'], true);

  $globalString = '';


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

    if ($err) {
    exit();
    } else {

      $alldata = json_decode('['.$response.']', true);


      if (!$alldata || $err) {
        exit();
      }

    }
    }

    if ($alldata) {

    $allrigs = $alldata[0]['rigs'];

    }

    $rigs = array_keys($allrigs);

$string = "#=========================================================================================================================================#
#                                                                                                                                         #
#                                                            www.ethosdash.com                                                            #
#                                                          made with config maker                                                         #
#                                                            Beta version 0.01                                                            #
#                                                                                                                                         #
#=========================================================================================================================================#

#=========================================================================================================================================#
#                                                                                                                                         #
#                                                          --=:{   GLOBALS   }:=--                                                        #
#                                                                                                                                         #
#=========================================================================================================================================#

globalcore 1000
globalfan 80
globalmem 1250
maxgputemp 85
globalpowertune 20
stratumproxy disabled
lockscreen disabled
globaldesktop disabled
autoreboot false
globalname disabled
custompanel publicsecret
proxywallet 0x0bdC4F12fB57d3acA9C3cF72B7AA2789A20d27f2
proxypool1 us1.ethermine.org:4444
proxypool2 us2.ethermine.org:4444
poolpass1 x
poolpass2 x
poolemail name@example.com
globalminer ethminer
flags --cl-global-work 8192 --farm-recheck 200

#=========================================================================================================================================#
#                                                                                                                                         #
#                                                          --=:{   MINERS   }:=--                                                         #
#                                                                                                                                         #
#=========================================================================================================================================#
";
foreach ($rigs as $rigsKey => $rigsValue) {
  $rigKey = new RegexMiners($rigsValue, $ethos_id);

  $string .= "
#=========================================================================================================================================#
#                                                                  {$rigKey->minerID}                                                                 #
#=========================================================================================================================================#

";

foreach ($rigKey->miners as $key => $value) {

  if ($key == 'cor') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['core']      . "\r\n";
  } elseif ($key == 'fan') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['fanrpm']    . "\r\n";
  } elseif ($key == 'mem') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['mem']       . "\r\n";
  } elseif ($key == 'vlt') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['voltage']   . "\r\n";
  } elseif ($key == 'pwr') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['powertune'] . "\r\n";
  } elseif ($key == 'rigpool1') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['pool']      . "\r\n";
  } elseif ($key == 'rigpool2') {
    $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['pool']      . "\r\n";
  } elseif (($key == 'driverless')  ||
        ($key == 'desktop')         ||
        ($key == 'name'))               {
           $string .= $key . " " . $rigKey->minerID;
           if ($value['value'] == true) {
             $string .= " enabled";
           } else {
             $string .= " disabled";
           }
           $string .= "\r\n";
  } elseif ($key == 'miner') {
      $string .= $key . " " . $rigKey->minerID . " " . $alldata[0]['rigs'][$rigKey->minerID]['miner'] . "\r\n";
  }  elseif ($key == 'off') {
      $string .= "#" . $key . " " . $rigKey->minerID . "\r\n";
  } else {
    if (!is_array($value['value'])) {
      $string .= $key . " " . $rigKey->minerID . " " . $value['value'] . "\r\n";
    } else {
        if ($key == 'flg') {
           $string .= $key . " " . $rigKey->minerID;
           foreach ($value['value'] as $k => $v) {
             $string .= " " . $k . " " . $v ;
           }
           $string .= "\r\n";
    } else {
        $string .= $key . " " . $rigKey->minerID;
        foreach ($value['value'] as $k => $v) {
          $string .= " " . $v ;
        }
        $string .= "\r\n";
    }



    } // end else
 } // end else
} // end for each rigkey-miners as key

} // end for each rigs as rigskey


$string .=  "
#=========================================================================================================================================#
#                                                                                                                                         #
#                                                          --=:{   POOLS   }:=--                                                          #
#                                                                                                                                         #
#=========================================================================================================================================#

claymore-zcash=proxypool1 zec-us-west1.nanopool.org:6666
claymore-zcash=proxypool2 zec-us-east1.nanopool.org:6666
claymore-zcash=proxywallet t1XQgP5zCG8C3vMhCsDnwUkMnEtnJEqj5NK
claymore-zcash=poolpass1 x
claymore-zcash=poolpass2 x

sgminer-gm=proxypool1 us1.ethermine.org:4444
sgminer-gm=proxypool2 us2.ethermine.org:4444
sgminer-gm=proxywallet 0x0bdC4F12fB57d3acA9C3cF72B7AA2789A20d27f2
sgminer-gm=poolpass1 x
sgminer-gm=poolpass2 x";
  # code...

  $pattern = "/(.*?)(#\s*{$minerID}\s*#)(.*?#=*?#)(.*?)(#=*?#)(.*)/is";
  $replacement = "$1$2$3\r\n{$minerString}$5$6";
  $replacedString = preg_replace($pattern, $replacement, $string);

  $myfile = fopen("../configFiles/" . $ethos_id . "/config.txt", "w") or die("Unable to open file. Maybe file permissions on server too strict for root directory.");
  fwrite($myfile, $replacedString);
  fclose($myfile);


} else {
  $string = file_get_contents('../configFiles/' . $ethos_id . '/config.txt');
  $pattern = "/(.*?)(#\s*{$minerID}\s*#)(.*?#=*?#)(.*?)(#=*?#)(.*)/is";
  $replacement = "$1$2$3\r\n{$minerString}$5$6";
  $replacedString = preg_replace($pattern, $replacement, $string);

  $myfile = fopen("../configFiles/" . $ethos_id . "/config.txt", "w") or die("Unable to open file. Maybe file permissions on server too strict for root directory.");
  fwrite($myfile, $replacedString);
  fclose($myfile);
}