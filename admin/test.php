<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 7.8.2015
 * Time: 14:22
 */
require ("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
$ass="strinče";
$ass=str_replace("č","c",$ass);
echo $ass;