<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 9.8.2015
 * Time: 17:18
 */
require("core/init.php");
if (!isset($_SESSION["id_korisnika"])) {
    header("Location:index.php");
    die();
}
if (isset($_GET["tip"])) {
    $tip=sanitize($_GET["tip"]);
    switch ($tip) {
        case "dodaj_novu_novinu":
            if (isset($_GET["naziv"]) && isset($_GET["link"])) {
                $naziv=sanitize($_GET["naziv"]);
                $link=sanitize($_GET["link"]);
                if($naziv!="" && $link!="") {
                    if (Aplikacija::dodaj_novu_novinu($naziv, $link) == 1) {
                        echo "Novina je dodata";
                    } else {
                        echo "Greska u DB insert";
                    }
                } else {
                    echo "GRESKA: Naziv i link su prazni";
                }
            } else {
                echo "Greska u GET. Nema naziva i linka";
            }
            break;
        case "sacuvaj_rss_za_auto":
            if (isset($_GET["novine"])) {
                $novine=$_GET["novine"];
                $novine=json_decode($novine,true);
                foreach($novine as $novina) {
                    $id=intval(sanitize($novina["id_novina"]));
                    $set=$novina["set"];
                    Aplikacija::set_novina_za_auto($id,$set);
                }
                echo "Promene su sacuvane.";
            } else {
                echo "GRESKA: novine nisu setovane GET";
            }
            break;
        case "dodaj_rss_link":
            if (isset($_GET["novina"]) && isset($_GET["link"])) {
                $novina=sanitize($_GET["novina"]);
                $link=sanitize($_GET["link"]);
                $n=new Novina($novina);
                if ($n->dodaj_rss_link($link)==1)
                    echo "RSS link dodat.";
                else
                    echo "db->num != 1";
            } else {
                echo "GRESKA: Novina i link nisu setovani";
            }
            break;
        case "izbrisi_rss_link":
            if (isset($_GET["id"])) {
                $id=sanitize($_GET["id"]);
                if (Novina::izbrisi_rss_link($id)==1) {
                    echo "Link je izbrisan";
                } else {
                    echo "GRESKA: db->num!=1";
                }

            } else {
                echo "GRESKA: id nije setovan GET";
            }
            break;
        default:
            echo "Pogresan tip";
    }
} else {
    echo "Greska u GET";
}