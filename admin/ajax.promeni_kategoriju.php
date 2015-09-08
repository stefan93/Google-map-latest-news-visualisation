<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 31.7.2015
 * Time: 16:29
 */
require_once 'core/init.php';
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
}
if (isset($_GET['q']) && isset($_GET['kat'])) {
    $id=sanitize($_GET['q']);
    $kat=sanitize($_GET['kat']);
    $db=new DB();
    $v=new Vest($id);
    if ($v->promeni_kategoriju($kat)) {
        echo 'Kategorija je promenjena';
    } else {
        echo 'Doslo je do greske.';
    }
} else {
    echo 'Greska (GET)';
}