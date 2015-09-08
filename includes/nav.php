<?php
    /*$pocetna="";$nove="";
    switch ($active) {
        case 'pocetna': $pocetna='active'; break;
        case 'clanci': $nove='active'; break;
    }
    */
?>
<nav class="navbar navbar-default" id="top-nav">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img alt="Brand" id="brand-image" src="images/logo.png">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <label for="vreme">Vreme: </label>
                    <select name="vreme" id="vreme" class="filter">
                        <option value="1">OD DANAS</option>
                        <option value="3">ZADNJIH 3 DANA</option>
                        <option value="5">ZADNJIH 5 DANA</option>
                        <option value="7">ZADNJIH 7 DANA</option>
                    </select>
                </li>
                <li>
                    <label for="kategorija">Kategorija: </label>
                    <select name="kategorija" id="kategorija" class="filter">
                        <option value="0">Sve kategorije</option>
                        <?php
                        $db=new DB();
                        $db->get("SELECT id_kategorije,naziv FROM kategorija");
                        $rez=$db->res;
                        foreach($rez as $r) {
                            ?>
                            <option value="<?php echo $r["id_kategorije"]; ?>"><?php echo $r["naziv"]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">
                    <div class="fb-like" data-href="http://www.mvesti.rs" data-layout="button" data-colorscheme="dark" data-action="like" data-show-faces="true" data-share="true"></div>
                    </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>