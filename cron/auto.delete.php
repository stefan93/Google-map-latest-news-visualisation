<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 25.8.2015
 * Time: 21:35
 */
$GLOBALS["config"]=array(
    "db" => array("type" => "mysql",
        "username" => "root",
        "host" => "localhost",
        "password" => "",
        "database" => "gapi",
    ),
    "error_report" => "DEV" ,//LIVE or DEV
    "adresa" => "http://www.mvesti.rs"
);

spl_autoload_register(function($class){
    require "../classes/class.".$class.".php";
});

require ("../functions/function.sanitize.php");
require ("../functions/function.my_error_handler.php");
require ("../functions/function.mb_isupper.php");

$db=new DB();
$db->set("DELETE FROM vesti WHERE DATE(`vreme`) < DATE(NOW() - INTERVAL 10 DAY)");
echo 'Ukupno '.$db->num.' vesti koje su zastarele je obrisano.';
unset($db);