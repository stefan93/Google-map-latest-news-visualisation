<?php
session_start();
$GLOBALS["config"]=array(
    "db" => array("type" => "mysql",
        "username" => "root",
        "host" => "localhost",
        "password" => "",
        "database" => "gapi",
    ),
    "error_report" => "DEV" ,//LIVE or DEV
    "adresa" => "http://www.mvesti.rs/"
);

spl_autoload_register(function($class){
    require "classes/class.".$class.".php";
});

require ("functions/function.sanitize.php");
require ("functions/function.my_error_handler.php");
require ("functions/function.mb_isupper.php");

?>