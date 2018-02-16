<?php

// session_start();
// $ethos_id = $_SESSION["id"];

class RegexGlobals {

  public $minersarray;

  public $globals = array(
      "globalcore"      => array("value"  =>  1000,   "type"  =>  "range",  "visible"  =>  false),
      "globalfan"       => array("value"  =>  80,     "type"  =>  "range",  "visible"  =>  false),
      "globalmem"       => array("value"  =>  1250,   "type"  =>  "range",  "visible"  =>  false),
      "maxgputemp"      => array("value"  =>  85,     "type"  =>  "range",  "visible"  =>  false),
      "globalpowertune" => array("value"  =>  20,     "type"  =>  "range",  "visible"  =>  false),
      "stratumproxy"    => array("value"  =>  true,   "type"  =>  "bool",   "visible"  =>  false), // true = enabled | false = disabled
      "lockscreen"      => array("value"  =>  true,   "type"  =>  "bool",   "visible"  =>  false), // true = enabled | false = disabled
      "globaldesktop"   => array("value"  =>  true,   "type"  =>  "bool",   "visible"  =>  false), // true = enabled | false = disabled
      "autoreboot"      => array("value"  =>  true,   "type"  =>  "bool",   "visible"  =>  false), // true = true    | false = false
      "globalname"      => array("value"  =>  true,   "type"  =>  "bool",   "visible"  =>  false), // true = true    | false = false
      "custompanel"     => array("value"  =>  "publicsecret",         "type"=>"text", "visible"=>false),//12 chars limit
      "proxywallet"     => array("value"  =>  "0x0bdC4F12fB57d3acA9C3cF72B7AA2789A20d27f2", "type"=>"text", "visible"=>false),
      "proxypool1"      => array("value"  =>  "us1.ethermine.org:4444","type"=>"text", "visible"=>false),
      "proxypool2"      => array("value"  =>  "us2.ethermine.org:4444","type"=>"text", "visible"=>false),
      "poolpass1"       => array("value"  =>  "x","type"=>"text", "visible"=>false),
      "poolpass2"       => array("value"  =>  "x","type"=>"text", "visible"=>false),
      "poolemail"       => array("value"  =>  "name@example.com","type"=>"text", "visible"=>false),
      "globalminer"     => array("value"  =>  array(), "type" => "select", "visible" => false),
      "flags"           => array("value"  =>  array("--cl-global-work"=> "8192","--farm-recheck"=> "200"), "type"=> "flags", "visible" => false)
    );


  // public $descriptions;

  public $lines;
  public $global_matches = [];
  public $globalKey;
  public $globalFlags = [];
  public $globalMinersIndex;
  public $ethos_id;




  function __construct($ethos_id) {

    $this->minersarray = array("ethminer", "sgminer-gm", "claymore", "claymore-zcash", "optiminer-zcash", "sgminer-gm-xmr", "cgminer-skein",  "ewbf-zcash",  "ccminer", "dstm-zcash");

    $this->globals['globalminer']['value'] = $this->minersarray;


   // $this->descriptions = file_get_contents('./json/global_descriptions.json');

   // function getPageContent(){

   //      $json = json_decode($this->descriptions, true); // decode the JSON into an associative array
   //      return $json["data"];

   //    }




      $this->ethos_id = trim($ethos_id);


      if (file_exists('configFiles/'. $this->ethos_id .'/config.txt')) {
        $lines = file('configFiles/'. $this->ethos_id .'/config.txt');

      foreach ($lines as $l) {

          // globals
          preg_match("/^(?<globalKey>(globalminer|maxgputemp|stratumproxy|proxywallet|proxypool1|proxypool2|poolpass1|poolpass2|flags|globalcore|globalmem|globalfan|globalpowertune|autoreboot|custompanel|lockscreen|globaldesktop|globalname|poolemail)) (?<globalValue>.*)/i", $l, $global_matches);

               if (isset($global_matches['globalKey']) && isset($global_matches['globalValue'])) {

                $globKey   = trim($global_matches['globalKey']);
                $globValue = trim($global_matches['globalValue']);

                if (!$this->globals[$globKey]['visible']) {
                  $this->globals[$globKey]['visible'] = true;
                }


                if ($globKey == "flags") {

                  preg_match("/(?<globalWorkKey>(\-\-cl-global-work)) (?<globalWorkValue>(\d)*)/i", $globValue, $globalWork_matches);

                  if (isset($globalWork_matches['globalWorkKey']) && isset($globalWork_matches['globalWorkValue'])) {

                    $globWorkKey   = $globalWork_matches['globalWorkKey'];
                    $globWorkValue = $globalWork_matches['globalWorkValue'];

                    $this->globals["$globKey"]["value"]["$globWorkKey"] = $globWorkValue;

                  }

                  preg_match("/(?<farmCheckKey>(\-\-farm-recheck)) (?<farmCheckValue>(\d)*)/i", $globValue, $farmCheck_matches);

                  if (isset($farmCheck_matches['farmCheckKey']) && isset($farmCheck_matches['farmCheckValue'])) {

                    $farmCheckKey   = $farmCheck_matches['farmCheckKey'];
                    $farmCheckValue = $farmCheck_matches['farmCheckValue'];

                    $this->globals["$globKey"]["value"]["$farmCheckKey"] = $farmCheckValue;

                  }


                } else if ($globKey == "globalminer") {

                  preg_match("/(?<minerKey>(ethminer$|sgminer\-gm$|claymore$|claymore\-zcash$|optiminer\-zcash$|sgminer\-gm\-xmr$|cgminer\-skein$|ewbf\-zcash$|ccminer$|dstm-zcash$))/i", $globValue, $miner_matches); // find keys and values for global miner array


                  if (isset($miner_matches['minerKey'])) {

                    $minerKey   = $miner_matches['minerKey'];

                    $arrayIndex = array_search("$minerKey", $this->globals["$globKey"]['value']);

                    $this->globalMinersIndex = $arrayIndex;


                  }

                  // set values in global miner array


                } else if (($globKey == "globalcore")   ||
                           ($globKey == "globalmem")    ||
                           ($globKey == "globalfan")    ||
                           ($globKey == "maxgputemp")   ||
                           ($globKey == "globalpowertune")) {

                  $this->globals["$globKey"]['value'] = $globValue;
                  settype($this->globals["$globKey"]['value'], "integer");

                } else if (($globKey == "stratumproxy")   ||
                           ($globKey == "globaldesktop")  ||
                           ($globKey == "globalname")     ||
                           ($globKey == "lockscreen"))       {
                              if ($globValue == "enabled") {
                                $this->globals["$globKey"]['value'] = true;

                              } else if ($globValue == "disabled"){
                                $this->globals["$globKey"]['value'] = false;
                              }
                              settype($this->globals["$globKey"]['value'], "bool");

                } else if ($globKey == "autoreboot") {

                  if ($globValue == 'true') {
                    $this->globals["$globKey"]['value'] = true;
                  } else if ($globValue == 'false'){
                    $this->globals["$globKey"]['value'] = false;
                  }


                  settype($this->globals["$globKey"]['value'], "bool");

                } else {
                  $this->globals["$globKey"]['value'] = $globValue;
                }

               }

      } // end for each $lines as l
    } // end if file exists

  } // end public function regex()
}


class RegexMiners {

  public $miners = array(
        "cor"             => array("value"  =>  array(),                  "type"  =>  "range",  "visible"  =>  false),
        "fan"             => array("value"  =>  array(),                  "type"  =>  "range",  "visible"  =>  false),
        "mem"             => array("value"  =>  array(),                  "type"  =>  "range",  "visible"  =>  false),
        "vlt"             => array("value"  =>  array(),                  "type"  =>  "range",  "visible"  =>  false),
        "pwr"             => array("value"  =>  array(),                  "type"  =>  "range",  "visible"  =>  false),
        "reb"             => array("value"  =>  1,                        "type"  =>  "range",  "visible"  =>  false),
        "mxt"             => array("value"  =>  1,                        "type"  =>  "range",  "visible"  =>  false),
        "loc"             => array("value"  =>  "d3",                     "type"  =>  "text",   "visible"  =>  false),
        "sel"             => array("value"  =>  array(1,2,4),             "type"  =>  "select", "visible"  =>  false),
        "desktop"         => array("value"  =>  true,                     "type"  =>  "bool",   "visible"  =>  false),
        "name"            => array("value"  =>  true,                     "type"  =>  "bool",   "visible"  =>  false),
        "driverless"      => array("value"  =>  true,                     "type"  =>  "bool",   "visible"  =>  false),
        "off"             => array("value"  =>  false,                    "type"  =>  "bool",   "visible"  =>  false),
        "wallet"          => array("value"  =>  "xxx",                    "type"  =>  "text",   "visible"  =>  false),
        "rigpool1"        => array("value"  =>  "us1.ethermine.org:4444", "type"  =>  "text",   "visible"  =>  false),
        "rigpool2"        => array("value"  =>  "us2.ethermine.org:4444", "type"  =>  "text",   "visible"  =>  false),
        "rigpoolpass1"    => array("value"  =>  "x",                      "type"  =>  "text",   "visible"  =>  false),
        "rigpoolpass2"    => array("value"  =>  "x",                      "type"  =>  "text",   "visible"  =>  false),
        "miner"           => array("value"  =>  array("ethminer", "sgminer-gm", "claymore", "claymore-zcash", "optiminer-zcash", "sgminer-gm-xmr", "cgminer-skein",  "ewbf-zcash",  "ccminer", "dstm-zcash"), "type" => "select", "visible" => false),
        "flg"             => array("value"  =>  array("--cl-local-work" => "256", "--cl-global-work" => "8192", "--farm-recheck" => "200"), "type" => "select", "visible" => false)
  );

  public $lines;
  public $miner_matches = [];
  public $minerKey;
  public $minerFlags = [];
  public $minersMinerIndex;

  public $minerID;
  public $mineValues = [];

  public $ethos_id;


  function __construct($minerID, $ethos_id) {

    $this->minerID = trim($minerID);
    $this->ethos_id = trim($ethos_id);


    if (file_exists('configFiles/'. $this->ethos_id .'/config.txt')) {
      $lines = file('configFiles/'. $this->ethos_id .'/config.txt');
      foreach ($lines as $l) {


          preg_match("/^(?<minerKey>(driver|cor|mem|fan|pwr|vlt|miner|flg|mxt|reb|loc|sel|off|driverless|desktop|rigpool1|rigpool2|rigpoolpass1|rigpoolpass2|name|wallet)) (?<minerID>({$this->minerID})\b) (?<minerValue>.*)/i", $l, $miner_matches);


               if (isset($miner_matches['minerKey']) && isset($miner_matches['minerValue'])) {

                $mineKey   = trim($miner_matches['minerKey']);
                $mineValue = trim($miner_matches['minerValue']);


                if (!$this->miners[$mineKey]['visible']) {
                  $this->miners[$mineKey]['visible'] = true;
                }


                if ($mineKey == "flg") {


                    // preg_match("/(?<flgKey>(\-\-cl\-local\-work|\-\-cl\-global\-work|\-\-farm\-recheck)) (?<flgValue>(\d)*)/i", $mineValue, $minerFlag_matches);

                    // if (isset($minerFlag_matches['flgKey']) && isset($minerFlag_matches['flgValue'])) {

                    //   $flgKey   = $minerFlag_matches['flgKey'];
                    //   $flgValue = $minerFlag_matches['flgValue'];

                    //     $this->miners["$mineKey"]["value"]["$flgKey"] = $flgValue;

                    // }


                    preg_match("/(?<localWorkKey>(\-\-cl\-local\-work)) (?<localWorkValue>(\d)*)/i", $mineValue, $local_matches);

                    if (isset($local_matches['localWorkKey']) && isset($local_matches['localWorkValue'])) {

                      $localWorkKey   = $local_matches['localWorkKey'];
                      $localWorkValue = $local_matches['localWorkValue'];

                      $this->miners["$mineKey"]["value"]["$localWorkKey"] = $localWorkValue;

                  }

                  preg_match("/(?<globalWorkKey>(\-\-cl\-global\-work)) (?<globalWorkValue>(\d)*)/i", $mineValue, $global_matches);

                  if (isset($global_matches['globalWorkKey']) && isset($global_matches['globalWorkValue'])) {

                    $globalWorkKey   = $global_matches['globalWorkKey'];
                    $globalWorkValue = $global_matches['globalWorkValue'];

                    $this->miners["$mineKey"]["value"]["$globalWorkKey"] = $globalWorkValue;

                  }

                  preg_match("/(?<farmCheckKey>(\-\-farm\-recheck)) (?<farmCheckValue>(\d)*)/i", $mineValue, $farmCheck_matches);

                  if (isset($farmCheck_matches['farmCheckKey']) && isset($farmCheck_matches['farmCheckValue'])) {

                    $farmCheckKey   = $farmCheck_matches['farmCheckKey'];
                    $farmCheckValue = $farmCheck_matches['farmCheckValue'];

                    $this->miners["$mineKey"]["value"]["$farmCheckKey"] = $farmCheckValue;

                  }


                } else if ($mineKey == "miner") {



                  preg_match("/(?<minerKey>(ethminer$|sgminer\-gm$|claymore$|claymore\-zcash$|optiminer\-zcash$|sgminer\-gm\-xmr$|cgminer\-skein$|ewbf\-zcash$|ccminer$|dstm\-zcash$))/i", $mineValue, $miner_matches);

                  if (isset($miner_matches['minerKey'])) {

                    $minerKey   = $miner_matches['minerKey'];

                    $arrayIndex = array_search("$minerKey", $this->miners[$mineKey]['value']);

                    $this->minersMinerIndex = $arrayIndex;


                  }

                } else if (($mineKey == "cor")    ||
                           ($mineKey == "mem")    ||
                           ($mineKey == "fan")    ||
                           ($mineKey == "pwr")    ||
                           ($mineKey == "vlt"))     {


                      $minedValues = explode(" ",$mineValue);

                      $this->miners["$mineKey"]['value'] = $minedValues;

                } else if ($mineKey == "sel")     {

                      $minedValues = explode(" ",$mineValue);

                      $this->miners["$mineKey"]['value'] = $minedValues;

                } else if (($mineKey == "driverless")       ||
                           ($mineKey == "desktop")          ||
                           ($mineKey == "name")             ||
                           ($mineKey == "lockscreen"))         {
                              if ($mineValue == "enabled")   {
                                $this->miners["$mineKey"]['value'] = true;

                              } else if ($mineValue == "disabled"){
                                $this->miners["$mineKey"]['value'] = false;
                              }
                              settype($this->miners["$mineKey"]['value'], "bool");

                } else if ($mineKey == "off") {

                  if ($mineValue == '') {
                    $this->miners["$mineKey"]['value'] = true;
                  } else if ($mineValue != ''){
                    $this->miners["$mineKey"]['value'] = false;
                  }

                  settype($this->miners["$mineKey"]['value'], "bool");

                } else {
                  $this->miners["$mineKey"]['value'] = $mineValue;
                }
              }

      } // end for each $lines as l
      // end if file exists
    // }
    }  else {
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


        $this->miners['cor']['value'] = explode(" ", $alldata[0]['rigs'][$this->minerID]['core']);
        $this->miners['fan']['value'] = explode(" ", $alldata[0]['rigs'][$this->minerID]['fanrpm']);
        $this->miners['mem']['value'] = explode(" ", $alldata[0]['rigs'][$this->minerID]['mem']);
        $this->miners['vlt']['value'] = explode(" ", $alldata[0]['rigs'][$this->minerID]['voltage']);
        $this->miners['pwr']['value'] = explode(" ", $alldata[0]['rigs'][$this->minerID]['powertune']);
        $this->miners['rigpool1']['value'] = $alldata[0]['rigs'][$this->minerID]['pool'];
        $this->miners['rigpool2']['value'] = $alldata[0]['rigs'][$this->minerID]['pool'];


        $minerKey   = $alldata[0]['rigs'][$this->minerID]['miner'];

        $arrayIndex = array_search("$minerKey", $this->miners['miner']['value']);

        $this->minersMinerIndex = $arrayIndex;

    }
  }
} // end public function regex()
}
class displayGlobals {

  public function outputGlobals($GlobalArray) {


    // switch ($GlobalArray['type']) {

    //     case $globalKey : "range";
    //       $this->displayRange($globalKey, $globalValue);
    //     break;

    //     case $globalKey : "text";
    //       $this->displayText($globalKey, $globalValue);
    //     break;

    //     case $globalKey : "bool";
    //       $this->displayBool($globalKey, $globalValue);
    //     break;

    //     case $globalKey : "select";
    //       $this->displaySelect($globalKey, $globalValue);
    //     break;

    //     case $globalKey : "flags";
    //       $this->displayflags($globalKey, $globalValue);
    //     break;

    //     }
    }




  public function displayRange($globalKey, $globalValue) {
    echo "<div><p id='{$globalKey}' style='float:left; width:10px; display: block;'>{$globalValue}</p>
    <input type='range' id='{$globalKey}' name='{$globalKey}' min='0' max='";

    if ($globalKey == 'globalpowertune') {
      echo "100";
    } elseif ($globalKey == 'globalcore') {
        echo "1000";
    } elseif ($globalKey == 'globalmem') {
        echo "10000";
    }
    else {
      echo "100";
    }

    echo "'  class='inputRange' value='{$globalValue}'></div>";

  }


  public function displayBool($globalKey, $globalValue) {
    echo "<div>
          <input type='checkbox' id='{$globalKey}' name='{$globalKey}'";
             if ($globalValue['value'] == true) {
                echo "checked";
             };
    echo ">";

  }

  public function displayText($globalKey, $globalValue) {
    echo "<div><input type='text'  id='{$globalKey}' class='{$globalKey} settingsInput globalInput form-control' value='{$globalValue['value']}'></div>";
  }

  public function displayFlags($globals) {

    foreach ($globals->globals['flags']['value'] as $flagsKey => $flagsValue) {
      echo "<div><label class='flagKey settingsInput globalInput' style='float:left; width: 50%;'>{$flagsKey}</label>

      <p id='{$flagsKey}' style='float:left; width:10px; display: block;'>{$flagsValue}</p>

      <input type='range' name='{$flagsKey}' id='{$flagsKey}' min='0' max='";

      if ($flagsKey == '--cl-global-work') {
        echo "10000";
      } elseif ($flagsKey == '--farm-recheck') {
          echo "1000";
      }

      echo "'  class='inputRange' value='{$flagsValue}'></div>";
    }

  }


  public function displaySelect($globals, $globalKey, $globalValue) {

    echo "<div><select id='{$globalKey}' class='form-control select {$globalKey}'>

            <option value='ethminer'";
             if ($globals->globalMinersIndex == 0) {
                 echo "selected";
               };
            echo  ">ethminer</option>

            <option value='sgminer-gm'";

             if ($globals->globalMinersIndex == 1) {
                 echo "selected";
               };
            echo  ">sgminer-gm</option>

            <option value='claymore'";

             if ($globals->globalMinersIndex == 2) {
                 echo "selected";
               };
            echo  ">claymore</option>

            <option value='claymore-zcash'";

             if ($globals->globalMinersIndex == 3) {
                 echo "selected";
               };
            echo  ">claymore-zcash</option>

            <option value='optiminer-zcash'";

             if ($globals->globalMinersIndex == 4) {
                 echo "selected";
               };
            echo  ">optiminer-zcash</option>

            <option value='sgminer-gm-xmr'";

             if ($globals->globalMinersIndex == 5) {
                 echo "selected";
               };
            echo  ">sgminer-gm-xmr</option>

            <option value='cgminer-skein'";

             if ($globals->globalMinersIndex == 6) {
                 echo "selected";
               };
            echo  ">cgminer-skein</option>

            <option value='ewbf-zcash'";
             if ($globals->globalMinersIndex == 7) {
                 echo "selected";
               };
            echo  ">ewbf-zcash</option>

            <option value='ccminer'";
             if ($globals->globalMinersIndex == 8) {
                 echo "selected";
               };

            echo  ">ccminer</option>

            <option value='dstm-zcash'";
             if ($globals->globalMinersIndex == 9) {
                 echo "selected";
               };

            echo  ">dstm-zcash</option>";


          echo  "</select></div>";

  }

}