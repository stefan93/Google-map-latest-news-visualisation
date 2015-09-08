<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 9.8.2015
 * Time: 16:07
 */
require("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
}
if (isset($_GET['q']) && isset($_GET['grad']) && isset($_GET['kat'])) {
    $id=sanitize($_GET['q']);
    $grad=sanitize($_GET['grad']);
    $kat=sanitize($_GET['kat']);
    $v=new Vest($id);
    $v->topublic($kat);
    if ($v->odobri($kat,$grad) == 1)
        echo 'Vest je odobrena.';
    else
        echo 'Greska tokom odobravanja vesti.';
} else {
    echo 'Greska u GET';
}