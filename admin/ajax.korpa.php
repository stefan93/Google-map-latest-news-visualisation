<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 28.7.2015
 * Time: 20:10
 */
require("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
}
if (isset($_GET['kontrola'])) {
    $kontrola=sanitize($_GET['kontrola']);
    switch ($kontrola) {
        case "ukorpu":
            if(isset($_GET["q"])) {
                $id=sanitize($_GET["q"]);
                $vest=new Vest($id);
                if ($vest->ukorpu()==1)
                    echo "Vest je prebacena u korpu";
                else
                    echo "Greska tokom prebacivanja u korpu";
            } else {
                echo "Nema q u GET";
            }
            break;
        case "ispraznikorpu":
            $br=Aplikacija::isprazni_korpu();
            echo "Ukupno ".$br. "vesti izbrisano.";
            break;
        default:
            echo "Greska u kontroli";
    }

} else {
    echo 'Greska u GET (nema kontrole)';
}
