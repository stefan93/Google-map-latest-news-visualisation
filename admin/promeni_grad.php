<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 29.7.2015
 * Time: 0:14
 */
require_once('core/init.php');
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
if (isset($_GET['q'])) {
    $id=sanitize($_GET['q']);
    $v=new Vest($id);
    $lat=$v->lat();
    $lng=$v->lng();
    $naziv=$v->grad();
} else {
    die();
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>CMS</title>
<?php require ("includes/header.php")?>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqECZ8wTuVbGEVFw1o3TlwL4qhvMwYsn0"></script>
    <script type="text/javascript" src="includes/init.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div id="map-canvas" grad="<?php echo $naziv; ?>" lat="<?php echo $lat; ?>" lng="<?php echo $lng; ?>" id_v="<?php echo $v->id_vesti; ?>"></div>
        </div>
        <div class="col-md-4">
            <input type="text" name="naziv" value="<?php echo $naziv; ?>"/>  <br/>
            <div class="btn btn-default" triger="sacuvaj_grad">Sacuvaj promene</div> <br /> <br />
            <fieldset>
                <label for="search">Trazi: </label> <input type="text" name="search-box" id="search"/>
                <div role="button" triger="potrazi-grad" class="btn btn-default">Potrazi mesto</div>
            </fieldset>
            <p id="kontrola"></p>
        </div>
    </div>
</body>
</html>