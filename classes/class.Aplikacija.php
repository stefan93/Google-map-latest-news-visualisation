<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 9.8.2015
 * Time: 15:03
 */
class Aplikacija {
    public static function novine_za_auto() {
        $db=new DB();
        $db->get("SELECT id_novina FROM novine WHERE auto=1 ");
        return $db->res;
    }
    public static function novine() {
        $db=new DB();
        $db->get("SELECT id_novina FROM novine ");
        return $db->res;
    }
    public static function auto_vesti() {
        $brojac=0;
        $novine=Aplikacija::novine_za_auto();
        echo "Izvestaj za auto dodavanje vesti.\r\n";
        echo "Vreme: ".date("G:i   d(D). m. Y.");
        foreach($novine as $nov) {
            $id=$nov["id_novina"];
            $n=new Novina($id);
            echo "\r\nNovine: ".$n->naziv()."\r\n";
            $brojac=$brojac+$n->ucitaj_vesti(1);
            $rez=$n->prikazi_vesti_neobjavljene(1,"10 MINUTE","datum_unosa");
            $bool=false;
            foreach($rez as $r) {
                $vest=new Vest($r["id_vesti"]);
                if ($vest->grad()!="") {
                    $bool=true;
                    $vest->topublic(1);
                    echo "Grad: " . $vest->grad() . ".  Naslov: " . $vest->naslov() . "\r\n";
                }
            }
            if (!$bool)
                echo "\r\nNema dodatih vesti vesti";
        }
        echo "\r\nUkupno ".$brojac." vesti ucitanih";

    }
    public static function dodaj_novu_novinu($naziv,$link) {
        $db=new DB();
        $db->set("INSERT INTO novine (naziv_novina, link_novina) VALUES ('$naziv','$link')");
        return $db->num;
    }
    public static function set_novina_za_auto($id_novina,$nula_ili_jedan) {
        $db=new DB();
        $db->set("UPDATE novine SET auto='$nula_ili_jedan' WHERE id_novina='$id_novina'");
        return $db->num;
    }
    static public function prikazi_korpu() {
        $db=new DB();
        $db->get("SELECT id_vesti FROM vesti WHERE obrisano=1");
        if ($db->num>0)
            return $db->res;
        else
            return $db->num;
    }
    static public function isprazni_korpu() {
        $db=new DB();
        $db->set("DELETE FROM vesti WHERE obrisano=1");
        return $db->num;
    }
}