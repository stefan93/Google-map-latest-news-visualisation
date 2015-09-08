<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 13.8.2015
 * Time: 14:01
 */
require ("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>CMS</title>
    <?php require ("includes/header.php")?>
</head>
<body>
<div class="container">
<?php
if (isset($_GET["id"])) {
    $vest=new Vest(sanitize($_GET["id"]));
    $reci=$vest->get_words();
    foreach($reci as $rec) {
        echo $rec;
        echo "<br/>";
    }
} else {
    echo "Greska u GET id";
}
?>
</div>
</body>
</html>