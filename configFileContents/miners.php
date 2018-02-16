<?php

session_start();
$ethos_id = $_SESSION["id"];

require "./classes/regex.class.php";

$minerID = $_GET["minerID"];
// $json = $_GET["json"];
$miners = new RegexMiners($minerID, $ethos_id);


$descriptions = file_get_contents('json/descriptions.json');
$desc = json_decode($descriptions, true);

$visible = '';


?>

<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLongTitle"><?= $minerID ?> Settings</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body" id="miner-modal-body">
  <table class="table table-striped" style='100%'>
   <colgroup>
     <col width="10%">
     <col width="90%">
   </colgroup>

    <tbody>

     <?php

     foreach ($miners->miners as $minerKey => $minerValue) {


      if ($minerValue['visible'] == true) {
        $visible = 'visible';
      } else {
       $visible = 'hidden';
      }

           echo "<tr id='{$minerKey}_{$minerKey}' class='worker {$minerKey} {$visible} '>
                  <th style='display:block;'> <label data-toggle='tooltip' data-placement='top' title='{$desc['miner'][$minerKey]}'>". $minerKey ."</label></th>
                  <td><div style='visibility:visible;'>";

                          if (($minerKey == "pwr") || ($minerKey == "fan") || ($minerKey == "vlt") || ($minerKey == "cor") || ($minerKey == "mem")) {
                           foreach ($minerValue['value'] as $key => $value) {

                              echo "<input type='number' min='0' max='100' id='". $minerKey ."' class='settingsInput minersRange ". $value ." form-control' value='". $value ."' >";

                          }

                         }

                          else if ($minerKey == "sel") {
                           foreach ($minerValue['value'] as $key => $value) {
                            echo "<input type='number' min='0' max='100' id='". $minerKey ."' class='settingsInput minersRange ". $value ." form-control' value='". $value ."' >";
                          }

                         } else  if (($minerKey == "off")          ||
                                     ($minerKey == "desktop")      ||
                                     ($minerKey == "name")         ||
                                     ($minerKey == "driverless"))      {

                                       echo "<input type='checkbox' id='{$minerKey}' name='{$minerKey}'";
                                                if ($minerValue['value'] == true) {
                                                   echo "checked";
                                                };
                                       echo ">";
                           } else if ($minerKey == "miner") {

                             echo "<select id='{$minerKey}' class='form-control select {$minerKey}'>

                                     <option value='ethminer'";


                                      if ($miners->minersMinerIndex == 0) {
                                          echo "selected";
                                        };
                                     echo  ">ethminer</option>

                                     <option value='sgminer-gm'";

                                      if ($miners->minersMinerIndex == 1) {
                                          echo "selected";
                                        };
                                     echo  ">sgminer-gm</option>

                                     <option value='claymore'";

                                      if ($miners->minersMinerIndex == 2) {
                                          echo "selected";
                                        };
                                     echo  ">claymore</option>

                                     <option value='claymore-zcash'";

                                      if ($miners->minersMinerIndex == 3) {
                                          echo "selected";
                                        };
                                     echo  ">claymore-zcash</option>

                                     <option value='optiminer-zcash'";

                                      if ($miners->minersMinerIndex == 4) {
                                          echo "selected";
                                        };
                                     echo  ">optiminer-zcash</option>

                                     <option value='sgminer-gm-xmr'";

                                      if ($miners->minersMinerIndex == 5) {
                                          echo "selected";
                                        };
                                     echo  ">sgminer-gm-xmr</option>

                                     <option value='cgminer-skein'";

                                      if ($miners->minersMinerIndex == 6) {
                                          echo "selected";
                                        };
                                     echo  ">cgminer-skein</option>

                                     <option value='ewbf-zcash'";
                                      if ($miners->minersMinerIndex == 7) {
                                          echo "selected";
                                        };
                                     echo  ">ewbf-zcash</option>

                                     <option value='ccminer'";
                                      if ($miners->minersMinerIndex == 8) {
                                          echo "selected";
                                        };

                                     echo  ">ccminer</option>

                                     <option value='dstm-zcash'";
                                      if ($miners->minersMinerIndex == 9) {
                                          echo "selected";
                                        };

                                     echo  ">dstm-zcash</option>";

                                     echo  "</select>";
                         }


                          else if ($minerKey == "flg") {
                           foreach ($minerValue['value'] as $key => $value) {

                            echo "<label class='flagKey settingsInput globalInput' style='float:left; width: 50%;'>{$key}</label>

                            <p id='{$key}' style='float:left; width:10px; display: block;'>{$value}</p>

                            <input type='range' name='{$key}' id='{$key}' min='0' max='";

                            if ($key == '--cl-global-work') {
                              echo "10000";
                            } elseif ($key == '--cl-local-work') {
                              echo "10000";
                            } elseif ($key == '--farm-recheck') {
                                echo "1000";
                            }


                            echo "'  class='inputRange flgKey flgRange' value='{$value}'>";
                          }

                         }
                       else {
                        echo "<input type='text' id='". $minerKey ."' class='settingsInput form-control ". $minerKey ."' value='" . $minerValue['value'] ."'>";
                      }


                 echo "</div></td>
                </tr>";
     }

     ?>

    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary" id="saveMiners" name="<?= $minerID ?>">Save changes</button>
</div>
<?php include './inc/footer.php'; ?>

