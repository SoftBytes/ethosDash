<?php

  $id1 = $_GET["id1"];
  $dr1 = $_GET["dr1"];
  $vl1 = $_GET["vl1"];
  $pw1 = $_GET["pw1"];
  $me1 = $_GET["me1"];
  $mi1 = $_GET["mi1"];
  $fl1 = $_GET["fl1"];
  $fa1 = $_GET["fa1"];

  $id2 = $_GET["id2"];
  $dr2 = $_GET["dr2"];
  $vl2 = $_GET["vl2"];
  $pw2 = $_GET["pw2"];
  $me2 = $_GET["me2"];
  $mi2 = $_GET["mi2"];
  $fl2 = $_GET["fl2"];
  $fa2 = $_GET["fa2"];

  $id3 = $_GET["id3"];
  $dr3 = $_GET["dr3"];
  $vl3 = $_GET["vl3"];
  $pw3 = $_GET["pw3"];
  $me3 = $_GET["me3"];
  $mi3 = $_GET["mi3"];
  $fl3 = $_GET["fl3"];
  $fa3 = $_GET["fa3"];

  $string =
"# -------------------------- Miner $id1 ----------------------------
driver $id1: $dr1
vlt $id1 $vl1
pwr $id1 $pw1
mem $id1 $me1
miner $id1 $mi1
flg $id1 $fl1
fan $id1 $fa1

# -------------------------- Miner $id2 ----------------------------
driver $id2 $dr2
vlt $id2 $vl2
pwr $id2 $pw2
mem $id2 $me2
miner $id2 $mi2
flg $id2 $fl2
fan $id2 $fa2

# -------------------------- Miner $id3 ----------------------------
driver $id3 $dr3
vlt $id3 $vl3
pwr $id3 $pw3
mem $id3 $me3
miner $id3 $mi3
flg $id3 $fl3
fan $id3 $fa3
";

$myfile = fopen("config/config.txt", "w") or die("Unable to open file homie. Maybe file permissions on server too strict for root directory.");
fwrite($myfile, $string);
fclose($myfile);


echo $string;
exit;
?>