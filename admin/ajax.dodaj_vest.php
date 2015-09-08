<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 28.7.2015
 * Time: 19:09
 */
require("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
}
if (isset($_GET['q']) && isset($_GET['kat']) && isset($_GET['grad'])) {
    $id=sanitize($_GET['q']);
    $kat=sanitize($_GET['kat']);
    $grad=sanitize($_GET['grad']);
    $v=new Vest($id);
    $v->postavi_grad($grad);
    if ($v->topublic($kat)==1)
        echo 'Vest je dodata.';
    else
        echo 'Greska tokom dodavanja vesti.';
} else {
    echo 'Greska.';
}