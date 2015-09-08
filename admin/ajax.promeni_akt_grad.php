<?php
require("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
header("Location:index.php");
die();
}
if (isset($_GET["id_grada"]) && $_GET["id_vesti"]) {
    $id_grada=sanitize($_GET["id_grada"]);
    $id_vesti=sanitize($_GET["id_vesti"]);
    $vest=new Vest($id_vesti);
    if ($vest->postavi_grad($id_grada)) {
        echo "Grad je promenjen.";
    } else {
        echo "GRESKA: db->num != 1";
    }
} else {
    echo "GRESKA: nisu lepo setovane GET var";
}



?>