<?php
require ("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
} else {
    $id_korisnika=$_SESSION["id_korisnika"];
}
if (!isset($_GET["n"])) {
    echo 'Greska. (get)';
    die();
}
$n=sanitize($_GET["n"]);
$nov=new Novina($n);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>CMS</title>
<?php require ("includes/header.php")?>
</head>
<body>
<?php
$active='nove_vesti';
require_once 'includes/nav.php';
?>
<div class="container">
                <div class="btn-group">
                    <div class="btn btn-default" triger="ucitaj_nove_vesti" id="<?php echo $n; ?>">
                        Ucitaj nove vesti
                    </div>
                </div>
                <a  href="<?php echo $nov->link_novina(); ?>" target="_blank" ><span class="label label-info"><?php echo $nov->naziv(); ?></span></a>
        <p class="date" id="nove-vesti"></p>
    <?php
    $res=$nov->prikazi_vesti_neobjavljene(0);
    foreach ($res as $r) {
        $id=$r["id_vesti"];
        $n_vest=new Vest($id);
        ?>
        <!-- pocetak clanak -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title" style="display:inline;">
                   <a href="<?php echo $n_vest->link(); ?>"> <?php echo $n_vest->naslov(); ?></a>
                </h2>

                <div class="pull-right">
                    <div class="btn-group">
                        <div class="btn btn-default" triger="dodaj_vest" role="nova" id="<?php echo $n_vest->id_vesti; ?>">
                            Dodaj vest
                        </div>
                        <div class="btn btn-default" triger="obrisi_vest" role="nova" id="<?php echo $n_vest->id_vesti; ?>">
                            U korpu
                        </div>
                        <div class="btn btn-default" triger="promeni_grad" role="nova" id="<?php echo $n_vest->id_vesti; ?>">
                            Promeni grad
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-body" id="<?php echo $n_vest->id_vesti; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo html_entity_decode($n_vest->desc()); ?><br />
                        <p class="kontrola" id="<?php echo $n_vest->id_vesti; ?>"></p>
                    </div>
                    <div class="col-md-3">
                        <select name="kategorija-<?php echo $n_vest->id_vesti;?>" >
                        <?php
                        $db=new DB();
                        $db->get("SELECT * FROM kategorija");
                        $r=$db->res;
                        foreach($r as $kat) {  ?>
                            <option value="<?php echo $kat['id_kategorije']; ?>"><?php echo $kat['naziv']; ?></option>
                        <?php }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $gradovi=$n_vest->prikazi_gradove();
                        if ($gradovi!=0) {
                        ?>
                        <select name="grad-<?php echo $n_vest->id_vesti;?>">
                            <?php
                            $tr_grad = $n_vest->grad();
                            foreach ($gradovi as $grad) {
                                ?>
                                <option value="<?php echo $grad['id_n_v_g']; ?>" <?php if ($tr_grad == $grad['grad']) {
                                    echo 'selected';
                                } ?> ><?php echo $grad['grad']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="btn btn-default btn-sm">
                    <a href="vidi_reci.php?id=<?php echo $n_vest->id_vesti; ?>" target="_blank" >Vidi reci</a>
                </div>
                </div>
        <p><?php echo $n_vest->vreme(); ?></p>
        </div>
        <!-- kraj clanka -->
    <?php
    }
    ?>
</div>
</body>
</html>