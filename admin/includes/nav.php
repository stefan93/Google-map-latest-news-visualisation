<?php
    $pocetna="";$nove_vesti="";$vidi_vesti="";$auto_vesti="";$korpa="";
    switch ($active) {
        case 'pocetna': $pocetna='active'; break;
        case 'nove_vesti': $nove_vesti='active'; break;
        case 'vidi_vesti': $vidi_vesti='active'; break;
        case 'auto_vesti': $auto_vesti='active'; break;
        case 'korpa': $korpa='active'; break;
    }
?>
<div class="container">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="pocetna.php">CMS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a class="<?php echo $pocetna; ?>" href="pocetna.php">Pocetna</a></li>
            <li>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle"  type="button" data-toggle="dropdown">Ucitaj nove vesti
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <?php
                        $db=new DB();
                        $db->get("SELECT id_novina FROM novine");
                        $r=$db->res;
                        foreach($r as $id) {
                            $novina=new Novina($id["id_novina"]);
                        ?>
                        <li><a href="nove_vesti.php?n=<?php echo $novina->id_novina; ?>"><?php echo $novina->naziv(); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Vidi dodate vesti
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <?php
                        $db=new DB();
                        $db->get("SELECT id_novina FROM novine");
                        $r=$db->res;
                        foreach($r as $id) {
                            $novina=new Novina($id["id_novina"]);
                            ?>
                            <li><a href="vidi_vesti.php?n=<?php echo $novina->id_novina; ?>"><?php echo $novina->naziv(); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
              <li><a class="<?php echo $auto_vesti; ?>" href="auto_vesti.php">Pregled Auto vesti</a></li>
              <li><a class="<?php echo $auto_vesti; ?>" href="auto_vesti_podesavanja.php">Podesavanja Auto vesti</a></li>
              <li><a class="<?php echo $korpa; ?>" href="korpa.php">Vidi korpu</a></li>
            <li><a target="_blank" href="<?php echo Config::get("adresa"); ?>">Poseti sajt</a></li>
            <li><a href="odjava.php">Odjavi se</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <br />
    </br>
</div>