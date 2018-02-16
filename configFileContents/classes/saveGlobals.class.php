<?php

session_start();
echo $ethos_id = $_SESSION["id"];






require './regex.class.php';

$saveGlobalsToFile = new RegexGlobals($ethos_id);
$jsonDecoded = json_decode($_GET['string'], true);







$globalString = '';

if (!file_exists("../configFiles/" . $ethos_id)) {
  mkdir("../configFiles/" . $ethos_id);
}

if (!file_exists("../configFiles/" . $ethos_id . "/config.txt")) {

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

foreach ($saveGlobalsToFile->globals as $key => $value) {

  if ($key == 'flags') {

    foreach ($saveGlobalsToFile->globals[$key]['value'] as $flagKey => $flagValue) {
      if ($flagKey == '--cl-global-work') {
        $saveGlobalsToFile->globals[$key]['value']['--cl-global-work'] = $jsonDecoded[$flagKey];
      } elseif ($flagKey == '--farm-recheck') {
        $saveGlobalsToFile->globals[$key]['value']['--farm-recheck'] = $jsonDecoded[$flagKey];
      }
    }

  } else {
    $saveGlobalsToFile->globals[$key]['value'] = $jsonDecoded[$key];
  }

}

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

";
foreach ($saveGlobalsToFile->globals as $key => $value) {

if ($key == 'flags') {
  $string .= $key;
    foreach ($saveGlobalsToFile->globals[$key]['value'] as $flagKey => $flagValue) {
      $string .= " " . $flagKey . " " . $flagValue;
    }
   $string .= "\r\n";
} else {
    if ($saveGlobalsToFile->globals[$key]['type'] == 'bool') {
      if ($saveGlobalsToFile->globals[$key]['value'] === true) {
        if ($key == 'autoreboot') {
          $string .= $key . " " . "true" . "\r\n";
        } else {
          $string .= $key . " " . "enabled" . "\r\n";
        }

      } else {
        if ($key == 'autoreboot') {
          $string .= $key . " " . "false" . "\r\n";
        } else {
          $string .= $key . " " . "disabled" . "\r\n";
        }
      }
    } else {
      $string .= $key . " " . $value['value'] . "\r\n";
    }
}
}
$string .= "
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

$myfile = fopen("../configFiles/" . $ethos_id . "/config.txt", "w") or die("Unable to open file. Maybe file permissions on server too strict for root directory.");
fwrite($myfile, $string);
fclose($myfile);

} else {



  foreach ($saveGlobalsToFile->globals as $key => $value) {

    if ($key == 'flags') {

      foreach ($saveGlobalsToFile->globals[$key]['value'] as $flagKey => $flagValue) {
        if ($flagKey == '--cl-global-work') {
          $saveGlobalsToFile->globals[$key]['value']['--cl-global-work'] = $jsonDecoded[$flagKey];
        } elseif ($flagKey == '--farm-recheck') {
          $saveGlobalsToFile->globals[$key]['value']['--farm-recheck'] = $jsonDecoded[$flagKey];
        }
      }

    } else {
      $saveGlobalsToFile->globals[$key]['value'] = $jsonDecoded[$key];
    }

  }


  // store as string and only save the globals
  foreach ($saveGlobalsToFile->globals as $key => $value) {

    if ($key == 'flags') {
      $globalString .= $key;
        foreach ($saveGlobalsToFile->globals[$key]['value'] as $flagKey => $flagValue) {
          $globalString .= " " . $flagKey . " " . $flagValue;
        }
       $globalString .= "\r\n";
    } else {
        if ($saveGlobalsToFile->globals[$key]['type'] == 'bool') {
          if ($saveGlobalsToFile->globals[$key]['value'] === true) {
            if ($key == 'autoreboot') {
              $globalString .= $key . " " . "true" . "\r\n";
            } else {
              $globalString .= $key . " " . "enabled" . "\r\n";
            }

          } else {
            if ($key == 'autoreboot') {
              $globalString .= $key . " " . "false" . "\r\n";
            } else {
              $globalString .= $key . " " . "disabled" . "\r\n";
            }
          }
        } else {
         $globalString .= $key . " " . $value['value'] . "\r\n";
        }
    }
  }



  $configFile = file_get_contents('../configFiles/' . $ethos_id . '/config.txt');
  $pattern = "/(.*?)(GLOBALS)(.*?#=*?#)(.*?)(#=*?#)(.*)/is";
  $replacement = "$1$2$3\r\n\r\n$globalString\r\n$5$6";
  $replacedString = preg_replace($pattern, $replacement, $configFile);

  $myfile = fopen("../configFiles/" . $ethos_id . "/config.txt", "w") or die("Unable to open file. Maybe file permissions on server too strict for root directory.");
  fwrite($myfile, $replacedString);
  fclose($myfile);


}