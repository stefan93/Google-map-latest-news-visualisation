<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 29.7.2015
 * Time: 20:03
 */
require_once "core/init.php";
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
 if ( isset($_GET["q"]) && isset($_GET["lat"]) && isset($_GET["lng"]) && isset($_GET["naziv"]) ) {
     $id = sanitize($_GET["q"]);
     $lat = sanitize($_GET["lat"]);
     $lng = sanitize($_GET["lng"]);
     $naziv = sanitize($_GET["naziv"]);
     $n = new Vest($id);
     $id_n_g=$n->dodaj_grad($lat,$lng,$naziv,0);
     if ($n->postavi_grad($id_n_g) == 1) {
         echo "Lokacija promenjena";
     } else {
         echo "Greska tokom promene lokacije";
     }
    } else {
        echo 'Doslo je do greske (GET)';
 }