<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 28.7.2015
 * Time: 20:43
 */
require_once "core/init.php";
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
if (!isset($_GET["n"])) {
    echo "Greska (get)";
    die();
}
$id_n=sanitize($_GET["n"]);
$n=new Novina($id_n);
$n->ucitaj_vesti();
echo 'Nove vesti su ucitane.';
?>