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
<html xmlns="http://www.w3.org/1999/html">
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
    <!-- pocetak clanak -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title" style="display:inline;">
                Podesavanja
            </h2>
        </div>
        <div class="panel-body">
            <legend> Novine:</legend>
            <div class="row">
                <div class="col-md-4">
                    <p>
                        <ol>
                        <?php
                        $rez=Aplikacija::novine();
                        foreach($rez as $r) {
                            $id=$r["id_novina"];
                            $novina=new Novina($id);
                            $linkovi=$novina->link_rss(); ?>
                            <li>
                            <?php echo $novina->naziv()."  (".$novina->link_novina().")"; ?>
                            </li>
                        <?php
                        }
                        ?>
                        </ol>
                    </p>
                </div>
                <div class="col-md-4">
                    <p>Dodaj novinu: </p>
                    <div class="row">
                        <div class="col-md-2">
                    <label for="naziv_novina">Naziv</label>
                        </div>
                        <div class="col-md-2">
                    <input id="naziv_novina" type="text" name="naziv_nove_novine"/> <br/>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-2">
                    <label for="link_novine">Link</label>
                            </div>
                        <div class="col-md-2">
                    <input id="link_novine" type="text" name="link_nove_novine"/> <br />
                            </div>
                    </div>
                    <div class="btn btn-default" triger="dodaj_novinu">
                        Dodaj novinu
                    </div>
                </div>
            </div>
            <legend>Novine za auto vesti:</legend>
            <div class="row">
                <div class="col-md-4">
                    <fieldset>
                        <?php
                        $rez=Aplikacija::novine();
                        $checked=Aplikacija::novine_za_auto();
                        foreach($rez as $r) {
                        $id=$r["id_novina"];
                        $novina=new Novina($id);
                            ?>
                            <input class="novine-za-auto" type="checkbox" value="<?php echo $novina->id_novina; ?>" <?php foreach($checked as $c) {if ($c["id_novina"]==$novina->id_novina) {echo "checked";break;} }  ?> /><?php echo $novina->naziv(); ?> <br/>
                        <?php
                        }
                        ?>
                    </fieldset>
                </div>
                <div class="btn btn-default" triger="sacuvaj_novine_za_auto">
                    Sacuvaj
                </div>
                </div>
            <legend> RSS linkovi:</legend>
                <div class="row">
                    <div class="col-md-6">
                    <fieldset>
                        <?php
                        $rez=Aplikacija::novine();
                        foreach($rez as $r) {
                            $id=intval($r["id_novina"]);
                            $novina=new Novina($id);
                            ?>
                            <label for="linkovi"><?php echo $novina->naziv(); ?></label>
                            <ol>
                            <?php
                            $linkovi=$novina->link_rss();
                                foreach($linkovi as $link) {
                                    ?>
                                    <li><?php echo $link["link_rss"]; ?>
                                    <div class="btn btn-default btn-sm" triger="izbrisi_rss_link" id="<?php echo $link["id_n_r_l"]; ?>">
                                        Izbrisi link
                                    </div>
                                    </li>
                                <?php
                                }
                            ?>
                            </ol>
                                <?php
                        }
                        ?>
                    </fieldset>
                        </div>
                    <div class="col-md-4">
                        <p>Dodaj rss link: </p>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="link_novine">RSS Link</label>
                            </div>
                            <div class="col-md-2">
                                <input id="link_novine" type="text" name="novi_rss_link"/> <br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset>
                                    <select name="novina_za_rss_link">
                                    <?php
                                    $rez=Aplikacija::novine();
                                    $checked=Aplikacija::novine_za_auto();
                                    foreach($rez as $r) {
                                        $id=$r["id_novina"];
                                        $novina=new Novina($id);
                                        ?>
                                        <option  value="<?php echo $novina->id_novina; ?>" ><?php echo $novina->naziv(); ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </fieldset><br/>
                            </div>
                        </div>
                        <div class="btn btn-default" triger="dodaj_rss_link">
                            Dodaj rss link
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- kraj clanka -->
</div>
</body>
</html>