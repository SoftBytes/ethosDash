<?php

session_start();
$ethos_id = $_SESSION["id"];

$globals = new RegexGlobals($ethos_id);
$globalOutputs = new displayGlobals;


$descriptions = file_get_contents('json/descriptions.json');
$desc = json_decode($descriptions, true);

// echo "<pre>";
// print_r($globals);
// echo "</pre>";
$visible = '';


foreach ($globals->globals as $globalKey => $globalValue) {

 if ($globalValue['visible'] == true) {
   $visible = 'visible';
 } else {
  $visible = 'hidden';
 }

 echo "<tr  id='{$globalKey}_global' class='global {$visible}'>
       <th> <label data-toggle='tooltip' data-placement='top' title='{$desc['global'][$globalKey]}'>{$globalKey}</label></th>

        <td>";
            if (($globalKey == "globalpowertune") ||
                ($globalKey == "maxgputemp")      ||
                ($globalKey == "globalfan")       ||
                ($globalKey == "globalcore")      ||
                ($globalKey == "globalmem"))        {

               $globalOutputs->displayRange($globalKey, $globalValue['value']);


            } else  if (($globalKey == "stratumproxy")    ||
                        ($globalKey == "lockscreen")      ||
                        ($globalKey == "globaldesktop")   ||
                        ($globalKey == "autoreboot")      ||
                        ($globalKey == "globalname"))       {


              $globalOutputs->displayBool($globalKey, $globalValue);
            }

            else if ($globalKey == "flags") {

              $globalOutputs->displayFlags($globals);


            } else if ($globalKey == "globalminer") {

              $globalOutputs->displaySelect($globals, $globalKey, $globalValue);

            } else {
              $globalOutputs->displayText($globalKey, $globalValue);
            }

   echo     "</td>

      </tr>";
}

//visiblity checkbox
// <td>
// <input type='checkbox' id='{$globalKey}' class='activeCheckbox'>
// </td>

