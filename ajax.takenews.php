<?php
require_once 'core/init.php';
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12.6.2015
 * Time: 13:20
 */
$vreme='1';
$kat='0';
if (isset($_POST["filter"]) && $_POST["filter"]!="") {
    $filter = json_decode($_POST["filter"], true);
    $vreme=$filter['vreme'];
    $kat=$filter['kategorije'];
}
if ($kat=='0') {
    $katsql="";
} else {
    $katsql="AND kategorija='$kat'";
}
$db=new DB();
$sql="SELECT id_vesti FROM vesti WHERE obrisano=0 AND datum_publikovanja IS NOT NULL AND DATE(`vreme`) >= DATE(NOW() - INTERVAL '$vreme' DAY)".$katsql;
$db->get($sql);
$data=array();
$i=0;
$rez=$db->res;
foreach ($rez as $r) {
    $vest=new Vest($r['id_vesti']);
    $data[$i]['tittle']=$vest->naslov();
    $data[$i]['link']=$vest->link();
    $data[$i]['lat']=$vest->lat();
    $data[$i]['lng']=$vest->lng();
    $data[$i]['time']=$vest->vreme();
    $i++;
}
echo json_encode($data,JSON_PRETTY_PRINT);