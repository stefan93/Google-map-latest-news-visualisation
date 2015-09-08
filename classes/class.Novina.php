<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1.8.2015
 * Time: 1:56
 */
class Novina
{
    public $id_novina;
    private $db;

    public function __construct($id)
    {
        $this->id_novina = $id;
        $db = new DB();
        $this->db = $db;
    }

    public function naziv()
    {
        $db = $this->db;
        $db->get("SELECT naziv_novina FROM novine WHERE id_novina='$this->id_novina'");
        return $db->res[0]["naziv_novina"];
    }

    public function link_novina()
    {
        $db = $this->db;
        $db->get("SELECT link_novina FROM novine WHERE id_novina='$this->id_novina'");
        return $db->res[0]["link_novina"];
    }

    public function link_rss()
    {
        $db = $this->db;
        $db->get("SELECT * FROM novine_rss_linkovi WHERE id_novina='$this->id_novina'");
        return $db->res;
    }

    public function promeni_naziv($naziv)
    {
        $db = $this->db;
        $db->get("UPDATE novine SET naziv_novina='$naziv' WHERE id_novina='$this->id_novina'");
        return $db->num;
    }

    public function promeni_link_novina($link)
    {
        $db = $this->db;
        $db->get("UPDATE novine SET link_novina='$link' WHERE id_novina='$this->id_novina'");
        return $db->num;
    }

    public function promeni_link_rss($link_rss)
    {
        $db = $this->db;
        $db->get("UPDATE novine SET link_rss='$link_rss' WHERE id_novina='$this->id_novina'");
        return $db->num;
    }

    public function ucitaj_vesti($auto=0)
    {
        $brojac=0;
        $rss_array = $this->link_rss();
        foreach ($rss_array as $rss) {
            $raw_rss = file_get_contents($rss["link_rss"]);
            $xml_rss = new SimpleXMLElement($raw_rss);
            foreach ($xml_rss->channel->item as $news) {
                $title = $news->title->__toString();
                $desc = $news->description->__toString();
                $link = $news->link->__toString();
                $vr = $news->pubDate->__toString();
                $vr = strtotime($vr);
                $vreme = date("Y-m-d H:i:s", $vr);
                if (Vest::da_li_postoji($title)) {
                    continue;
                }
                $id = Vest::ubaci_vest($title, $link, 1, $vreme, $desc, $this->id_novina, $auto);
                $brojac++;
                $vest = new Vest($id);
                $reci = $vest->get_words();
                foreach ($reci as $rec) {
                    $rez=Vest::find_city($rec);
                    if ($rez['status']=='OK') {
                        $vest->dodaj_grad($rez['lat'],$rez['lng'],$rez['naziv'],$rez['partial']);
                    } else if ($rez['status']=='ZERO_RESULTS') {
                        continue;
                    } else {
                        trigger_error($rez['status'],E_USER_ERROR);
                    }
                }
            }
        }
        return $brojac;
    }
    /*
   SECOND
  MINUTE
  HOUR
  DAY
  WEEK
  MONTH
  QUARTER
  YEAR
   */
    public function prikazi_vesti_neobjavljene($auto=NULL,$u_zadnjih_X=NULL,$vreme_ili_datum_unosa="vreme") {
        $db=$this->db;
        if ($u_zadnjih_X===NULL) {
            if ($auto === 1)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina' AND automatic=1 AND obrisano=0";
            else if ($auto === 0)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina' AND automatic=0 AND obrisano=0 ";
            else
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina' AND obrisano=0";
        } else {
            if ($auto === 1)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina' AND automatic=1
                        AND DATE(`".$vreme_ili_datum_unosa."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
            else if ($auto === 0)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina' AND automatic=0
                        AND DATE(`".$vreme_ili_datum_unosa."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
            else
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS  NULL AND id_novina='$this->id_novina'
                        AND DATE(`".$vreme_ili_datum_unosa."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
        }
        $db->get($sql);
        return $db->res;
    }

    public function prikazi_vesti_objavljene($auto=NULL,$u_zadnjih_X=NULL,$vreme_ili_datum_unosa_ili_datum_publikovanja="vreme") {
        $db=$this->db;
        if ($u_zadnjih_X===NULL) {
            if ($auto === 1)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina' AND automatic=1 AND obrisano=0";
            else if ($auto === 0)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina' AND automatic=0  AND obrisano=0";
            else
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina' AND obrisano=0";
        } else {
            if ($auto === 1)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina' AND automatic=1
                        AND DATE(`".$vreme_ili_datum_unosa_ili_datum_publikovanja."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
            else if ($auto === 0)
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina' AND automatic=0
                        AND DATE(`".$vreme_ili_datum_unosa_ili_datum_publikovanja."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
            else
                $sql = "SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND id_novina='$this->id_novina'
                        AND DATE(`".$vreme_ili_datum_unosa_ili_datum_publikovanja."`) >= DATE(NOW() - INTERVAL ".$u_zadnjih_X.") AND obrisano=0";
        }
        $db->get($sql);
        return $db->res;
    }
    public function test() {
        $suma=0;
        $rss_array = $this->link_rss();
        foreach ($rss_array as $rss) {
            $raw_rss = file_get_contents($rss["link_rss"]);
            $xml_rss = new SimpleXMLElement($raw_rss);
            foreach ($xml_rss->channel->item as $news) {
                $title = $news->title->__toString();
                $desc = $news->description->__toString();
                $link = $news->link->__toString();
                $vr = $news->pubDate->__toString();
                $vr = strtotime($vr);
                $vreme = date("Y-m-d H:i:s", $vr);
                $id = Vest::ubaci_vest($title, $link, 1, $vreme, $desc, $this->id_novina, 0);
                $vest = new Vest($id);
                $reci = $vest->get_words();
                $suma=$suma+count($reci);
            }
        }
        echo 'Broj reci = '.$suma;
    }
    public function automatic() {
        $this->ucitaj_vesti();
        $rez=$this->prikazi_vesti_neobjavljene(1);


    }
    public function dodaj_rss_link($link) {
        $db=$this->db;
        $db->set("INSERT INTO novine_rss_linkovi (id_novina, link_rss) VALUES ('$this->id_novina','$link')");
        return $db->num;
    }
    static public function izbrisi_rss_link($id) {
        $db=new DB();
        $db->set("DELETE FROM novine_rss_linkovi WHERE id_n_r_l='$id'");
        return $db->num;
    }

}