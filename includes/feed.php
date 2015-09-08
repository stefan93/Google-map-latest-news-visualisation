<marquee scrollamount="5">
    <?php
    $db=new DB();
    $db->get("SELECT id_vesti FROM vesti WHERE obrisano=0 AND datum_publikovanja IS NOT NULL AND obrisano=0 AND vreme >= DATE(NOW() - INTERVAL 1 DAY) ORDER BY datum_publikovanja DESC ");
    //$db->get("SELECT id_vesti FROM vesti WHERE datum_publikovanja IS NOT NULL AND obrisano=0");
    $rez=$db->res;
    foreach ($rez as $r) {
        $id_v=$r["id_vesti"];
        $v=new Vest($id_v);
        echo '<span class="mali-logo"></span><a class="fancy" href="'.$v->link().'"><span style="color: #D54401">'.$v->kategorija().' </span> '.$v->naslov().'</a>';
    }
    ?>
</marquee>