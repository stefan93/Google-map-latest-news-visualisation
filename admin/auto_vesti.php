<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 8.8.2015
 * Time: 21:55
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
<?php
$active='auto_vesti';
require_once 'includes/nav.php';
?>
<div class="container">
    <div class="container">
        <div class="btn btn-default" triger="odobri-cekirano">
            Odobri sve cekirano
        </div>
    </div>
    <?php
        $niz_novina=Aplikacija::novine_za_auto();
        foreach($niz_novina as $nov) {
            $id_novina=$nov["id_novina"];
            $novina = new Novina($id_novina);
            $rez = $novina->prikazi_vesti_objavljene(1);
            foreach ($rez as $r) {
                $id_vesti=$r["id_vesti"];
                $v = new Vest($id_vesti);
                ?>
                <!-- pocetak clanak -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="display:inline;">
                            <a href="<?php echo $v->link(); ?>"><?php echo $v->naslov(); ?></a>
                        </h2>

                        <div class="pull-right">
                            <div class="btn-group">
                                <div class="btn btn-default" triger="odobri_vest" role="stara" id="<?php echo $v->id_vesti; ?>">
                                    Odobri vest
                                </div>
                                <div class="btn btn-default" triger="obrisi_vest" role="stara" id="<?php echo $v->id_vesti; ?>">
                                    U korpu
                                </div>
                                <div class="btn btn-default" triger="promeni_grad" role="stara" id="<?php echo $v->id_vesti; ?>">
                                    Promeni grad
                                </div>
                                <input type="checkbox" name="cb"  id="<?php echo $v->id_vesti; ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="panel-body" id="<?php echo $v->id_vesti; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo html_entity_decode($v->desc()); ?><br />
                                <p class="kontrola" id="<?php echo $v->id_vesti; ?>"></p>
                            </div>
                            <div class="col-md-3">
                                <select name="kategorija-<?php echo $v->id_vesti;?>" >
                                    <?php
                                    $db=new DB();
                                    $db->get("SELECT * FROM kategorija");
                                    $r=$db->res;
                                    foreach($r as $kat) { ?>
                                        <option value="<?php echo $kat['id_kategorije']; ?>" <?php if($v->kategorija("broj")==$kat["id_kategorije"]) echo "selected";?>><?php echo $kat['naziv']; ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="grad-<?php echo $v->id_vesti;?>">
                                    <?php
                                    $gradovi=$v->prikazi_gradove();
                                    $tr_grad=$v->grad();
                                    foreach($gradovi as $grad) { ?>
                                        <option value="<?php echo $grad['id_n_v_g']; ?>" <?php if ($tr_grad==$grad['grad']) { echo 'selected'; } ?> ><?php echo $grad['grad']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <p class="promena-kategorije" id="<?php echo $v->id_vesti; ?>"></p>
                        </div>
                        <div class="btn btn-default btn-sm">
                            <a href="vidi_reci.php?id=<?php echo $v->id_vesti; ?>" target="_blank" >Vidi reci</a>
                        </div>
                    </div>
                    <p><?php echo $v->vreme(); ?><p>
                </div>
                <!-- kraj clanka -->
            <?php
            }
        }
    ?>
        <span class="label label-success">Vesti bez pronadjenog grada</span>
    <?php
    $niz_novina=Aplikacija::novine_za_auto();
    foreach($niz_novina as $nov) {
        $id_novina=$nov["id_novina"];
        $novina = new Novina($id_novina);
        $rez = $novina->prikazi_vesti_neobjavljene(1);
        foreach ($rez as $r) {
            $id_vesti=$r["id_vesti"];
            $v = new Vest($id_vesti);
            ?>
            <!-- pocetak clanak -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title" style="display:inline;">
                        <a href="<?php echo $v->link(); ?>"><?php echo $v->naslov(); ?></a>
                    </h2>

                    <div class="pull-right">
                        <div class="btn-group">
                            <div class="btn btn-default" triger="odobri_vest" role="stara" id="<?php echo $v->id_vesti; ?>">
                                Odobri vest
                            </div>
                            <div class="btn btn-default" triger="obrisi_vest" role="stara" id="<?php echo $v->id_vesti; ?>">
                                U korpu
                            </div>
                            <div class="btn btn-default" triger="promeni_grad" role="stara" id="<?php echo $v->id_vesti; ?>">
                                Promeni grad
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-body" id="<?php echo $v->id_vesti; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo html_entity_decode($v->desc()); ?><br />
                            <p class="kontrola" id="<?php echo $v->id_vesti; ?>"></p>
                        </div>
                        <div class="col-md-3">
                            <select name="kategorija-<?php echo $v->id_vesti;?>" >
                                <?php
                                $db=new DB();
                                $db->get("SELECT * FROM kategorija");
                                $r=$db->res;
                                foreach($r as $kat) { ?>
                                    <option value="<?php echo $kat['id_kategorije']; ?>" <?php if($v->kategorija("broj")==$kat["id_kategorije"]) echo "selected";?>><?php echo $kat['naziv']; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="grad-<?php echo $v->id_vesti;?>">
                                <?php
                                $gradovi=$v->prikazi_gradove();
                                $tr_grad=$v->grad();
                                foreach($gradovi as $grad) { ?>
                                    <option value="<?php echo $grad['id_n_v_g']; ?>" <?php if ($tr_grad==$grad['grad']) { echo 'selected'; } ?> ><?php echo $grad['grad']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <p class="promena-kategorije" id="<?php echo $v->id_vesti; ?>"></p>
                    </div>
                    <div class="btn btn-default btn-sm">
                        <a href="vidi_reci.php?id=<?php echo $v->id_vesti; ?>" target="_blank" >Vidi reci</a>
                    </div>
                </div>
                <p><?php echo $v->vreme(); ?><p>
            </div>
            <!-- kraj clanka -->
        <?php
        }
    }
    ?>
</div>
</body>
</html>