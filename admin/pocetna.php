
<?php
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
<?php
$active='pocetna';
require_once 'includes/nav.php';
?>
<div class="container">
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel panel-default panel-heading">
                <span class="panel-title">Auto vesti</span>
            </div>
            <div class="panel panel-default panel-body">
        <?php
        /*$novine_niz=Aplikacija::novine_za_auto();
        foreach ($novine_niz as $nov) {
            $id_n=$nov["id_novine"];
            $novina=new Novina($id_n);
            ?>
            <legend><<?php echo $novina->naziv(); ?>></legend>
            <ol>
            <?php
            $vesti_niz=$novina->prikazi_vesti_neobjavljene(1);
            $i=0;
            foreach ($vesti_niz as $v) {
                $i++;
                if ($i==6) {
                    break;
                }
                $id_vesti=$v["id_vesti"];
                $vest=new Vest($id_vesti);*/
            ?>
        </div>
    </div>
    <div class="col-md-4">

    </div>
    <div class="col-md-4">

    </div>
</div>
</div>
</body>
</html>