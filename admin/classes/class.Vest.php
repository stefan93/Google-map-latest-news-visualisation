<?php
class Vest{
    public $id_vesti;
    private $db;
    public function __construct($id){
        $this->id_vesti=$id;
        $db=new DB();
        $this->db=$db;
    }
    static public function da_li_postoji($naslov) {
        $db=new DB();
        $db->get("SELECT id_vesti,naslov FROM vesti WHERE naslov='$naslov'");
        $l=$db->num;
        if ($l>0)
            return true;
        else
            return false;
    }
    static public function ubaci_vest($naslov,$link,$kategorija,$vreme,$descr,$id_novina,$automatic) {
        $db=new DB();
        if (!Vest::da_li_postoji($naslov)) {
            $db->set("INSERT INTO vesti (naslov,link,kategorija,vreme,descr,id_novina,automatic,datum_unosa) VALUES ('$naslov','$link','$kategorija','$vreme',
                      '$descr', '$id_novina', '$automatic', NOW()) ");
            if ($db->num==1)
                return $db->last_id();
            else
                return 0;
        }
        return 0;
    }
    public function obrisi() {
        $db=$this->db;
        $db->set("DELETE FROM vesti WHERE id_vesti='$this->id_vesti'");
        return $db->num;
    }
    public function link() {
        $db=$this->db;
        $db->get("SELECT link FROM vesti WHERE id_vesti='$this->id_vesti'");
        $l=$db->res;
        return $l[0]['link'];
    }
    public function kategorija($tip=NULL) {
        if ($tip=="broj") {
            $db=$this->db;
            $db->get("SELECT kategorija FROM vesti WHERE id_vesti='$this->id_vesti'");
            $k=$db->res[0]["kategorija"];
            return $k;
        } else {
            $db = $this->db;
            $db->get("SELECT kategorija FROM vesti WHERE id_vesti='$this->id_vesti'");
            $k = $db->res;
            $k = $k[0]['kategorija'];
            $db->get("SELECT naziv FROM kategorija WHERE id_kategorije='$k'");
            $kat = $db->res[0]['naziv'];
            return $kat;
        }
    }
    public function naslov() {
        $db=$this->db;
        $db->get("SELECT naslov FROM vesti WHERE id_vesti='$this->id_vesti'");
        $n=$db->res;
        if ($db->num>0)
            return $n[0]['naslov'];
        else
            return 0;
    }
    public function desc() {
        $db=$this->db;
        $db->get("SELECT descr FROM vesti WHERE id_vesti='$this->id_vesti'");
        $n=$db->res;
        if ($db->num>0)
            return $n[0]['descr'];
        else
            return 0;
    }
    public function grad() {
        $db=$this->db;
        $db->get("SELECT grad FROM nove_vesti_gradovi WHERE id_vesti='$this->id_vesti' AND aktivan=1");
        if ($db->num>0)
            return $db->res[0]["grad"];
        else
            return "";
    }
    public function lat() {
        $db=$this->db;
        $db->get("SELECT lat FROM nove_vesti_gradovi WHERE id_vesti='$this->id_vesti' AND aktivan=1");
        if ($db->num>0)
            return $db->res[0]["lat"];
        else
            return 0;
    }
    public function lng() {
        $db=$this->db;
        $db->get("SELECT lng FROM nove_vesti_gradovi WHERE id_vesti='$this->id_vesti' AND aktivan=1");
        if ($db->num>0)
            return $db->res[0]["lng"];
        else
            return 0;
    }
    public function dodaj_grad($lat,$lng,$naziv,$partial) {
        $db=$this->db;
        $id=$this->id_vesti;
        $db->get("SELECT id_n_v_g FROM nove_vesti_gradovi WHERE id_vesti='$id'");
        if($db->num==0) {
            $db->set("INSERT INTO nove_vesti_gradovi (id_vesti, grad, lat, lng, aktivan, partial) VALUES ('$id','$naziv','$lat','$lng','1','$partial')");
            return $db->last_id();
        } else {
            if ($partial) {
                $db->set("INSERT INTO nove_vesti_gradovi (id_vesti, grad, lat, lng, partial) VALUES ('$id','$naziv','$lat','$lng','$partial')");
                return $db->last_id();
            } else {
                $db->get("SELECT id_n_v_g FROM nove_vesti_gradovi WHERE id_vesti='$id' AND partial=0");
                if ($db->num==0) {
                    $db->set("INSERT INTO nove_vesti_gradovi (id_vesti, grad, lat, lng, partial) VALUES ('$id','$naziv','$lat','$lng','$partial')");
                    $id_n_g=$db->last_id();
                    $this->postavi_grad($id_n_g);
                    return $id_n_g;
                } else {
                    $db->set("INSERT INTO nove_vesti_gradovi (id_vesti, grad, lat, lng, aktivan, partial) VALUES ('$id','$naziv','$lat','$lng','0','$partial')");
                    return $db->last_id();
                }
            }
        }
    }
    public function topublic($kat) {
        $db=new DB();
        $id=$this->id_vesti;
        $db->set("UPDATE vesti SET datum_publikovanja=NOW(), kategorija='$kat' WHERE id_vesti='$id'");
        return $db->num;
    }
    public function unpublic() {
        $db=new DB();
        $id=$this->id_vesti;
        $db->get("SELECT id_vesti FROM vesti WHERE id_vesti='$id' AND datum_publikovanja IS NOT NULL");
        if ($db->num==0) {
            return 0;
        }
        $db->set("UPDATE vesti SET datum_publikovanja=NULL WHERE id_vesti='$id'");
        return $db->num;
    }
    public function postavi_grad($id_n_v_g) {
        $db=$this->db;
        $id=$this->id_vesti;
        $db->set("UPDATE nove_vesti_gradovi SET aktivan=0 WHERE id_vesti='$id'");
        $db->set("UPDATE nove_vesti_gradovi SET aktivan=1 WHERE id_n_v_g='$id_n_v_g'");
        return $db->num;
    }
    public function promeni_kategoriju($kat)
    {
        $db = $this->db;
        $sql = "UPDATE vesti SET kategorija='$kat' WHERE id_vesti='$this->id_vesti'";
        $db->set($sql);
        return $db->num;
    }
    public function vreme()
    {
        $db = $this->db;
        $sql = "SELECT vreme FROM vesti WHERE id_vesti='$this->id_vesti'";
        $db->get($sql);
        return $db->res[0]["vreme"];
    }
    public function naziv_novine($tip="naziv") {
        $db=$this->db;
        $db->get("SELECT id_novina FROM vesti WHERE id_vesti='$this->id_vesti'");
        $id=$db->res[0]["id_novina"];
        if ($tip=="naziv")
            return $id;
        else if ($tip=="broj") {
            $db->get("SELECT naziv_novina FROM novine WHERE id_novina='$id'");
            return $db->res[0]["naziv_novina"];
        } else {
            return NULL;
        }
    }
    public function get_words() {
        $tekst=$this->naslov().' '.$this->desc();
        preg_match_all("/([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,} na [A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,} [A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,})|([A-Za-zčćšđž]{1,}an(i|e|ke|kama|ima))/u",$tekst,$reci);
        $patern[]="/an[a-z]{1,5}/u";
        foreach($reci[4] as $i=>$tekstec) {
            if ($tekstec!="") {
                $reci[4][$i]=preg_replace($patern,"",$tekstec);
                $reci[0][$i]=$reci[4][$i];

            }
        }
        foreach($reci[3] as $i=>$tekstec) {
            if ($tekstec!="") {
                $reci[4][$i]=preg_replace($patern,"",$tekstec);
                $reci[0][$i]=$reci[4][$i];

            }
        }
        $zabris=array();
        foreach($reci[2] as $i => $tekstec) {
            if ($tekstec!="") {
                if(preg_match_all("/(ić$)|([a-zčćšđžA-ZČĆŠĐŽ]ić )/u",$tekstec,$tekstez)) {
                    $zabris[]=$i;
                }
            }
        }
        foreach ($zabris as $indeks) {
            unset($reci[0][$indeks]);
        }
        return array_values($reci[0]);
    }
    static public function find_city($word) {
        $word=str_replace("č","c",$word);
        $address = urlencode($word);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?components=locality:locality|country:RS&language=en&bounds=42.172944,19.2537083|46.0944757,22.8964521&address=".$address."&key=AIzaSyCqECZ8wTuVbGEVFw1o3TlwL4qhvMwYsn0";
        $resp_json = file_get_contents($url);
        $resp = json_decode($resp_json, true);
        if ($resp['status'] == 'OK') {
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $naziv = $resp['results'][0]['formatted_address'];
            if ($lati && $longi) {
                if (isset($resp['results'][0]['partial_match'])) {
                    $partial=true;
                } else {
                    $partial=false;
                }
                $k=array('status'=>$resp['status'],'lat'=>$lati,'lng'=>$longi, 'naziv'=> $naziv, 'partial' => $partial);
                return $k;
            } else {
                $k=array('status'=>$resp['status']);
                return $k;
            }

        } else {
            $k=array('status'=>$resp['status']);
            return $k;
        }
    }
    public function prikazi_gradove() {
        $db=$this->db;
        $db->get("SELECT * FROM nove_vesti_gradovi WHERE id_vesti='$this->id_vesti'");
        return $db->res;
    }
    public function odobri($kat,$grad) {
        $db=$this->db;
        $db->set("UPDATE vesti SET automatic=0, kategorija='$kat' WHERE id_vesti='$this->id_vesti'");
        if ($db->num==1){
            return $this->postavi_grad($grad);
        }
        return $db->num;
    }
    public function ukorpu() {
        $db=$this->db;
        $this->unpublic();
        $db->set("UPDATE vesti SET obrisano=1 WHERE id_vesti='$this->id_vesti'");
        return $db->num;
    }
}
?>