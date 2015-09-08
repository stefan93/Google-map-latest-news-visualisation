<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 10.8.2015
 * Time: 19:59
 */
//header('Content-Type: text/plain; charset=utf-8');
$tekst="Neki tekst o Ćsada Šsdad Đsas Žsaad necemu Srbija Gašić novosadjanke Pantić Stefan pozarevljani Novosadjankama petrovčani Mlavi i Čajetina tako to na Temu na Necemu Tu";
preg_match_all("/([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,} na [A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,} [A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-Za-zčćšđž]{1,}an(i|e|ke|kama|ima))/u",$tekst,$reci);
$patern[]="/an[a-z]{1,5}/u";
foreach($reci[4] as $i=>$tekstec) {
    if ($tekstec!="") {
        $reci[4][$i]=preg_replace($patern,"",$tekstec);
        $reci[0][$i]=$reci[4][$i];

    }
}
foreach($reci[3] as $i=>$tekstec) {
    if ($tekstec!="") {
        $reci[4][$i]=preg_replace($patern,"",$tekstec);
        $reci[0][$i]=$reci[4][$i];

    }
}
$zabris=array();
foreach($reci[2] as $i => $tekstec) {
    if ($tekstec!="") {
        if(preg_match_all("/(ić$)|([a-zčćšđžA-ZČĆŠĐŽ]ić )/u",$tekstec,$tekstez)) {
            $zabris[]=$i;
        }
    }
}
foreach ($zabris as $indeks) {
    unset($reci[0][$indeks]);
}
$reci[0]=array_values($reci[0]);
var_dump($reci);