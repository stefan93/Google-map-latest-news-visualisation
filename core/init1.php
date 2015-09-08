<?php
    session_start();
    $GLOBALS["config"]=array(
        "db" => array("type" => "mysql",
                    "username" => "mvestirs_admin",
                    "host" => "localhost",
                    "password" => "stEfAnpAntIc1993",
                    "database" => "mvestirs_m",
            ),
        "error_report" => "LIVE" ,//LIVE or DEV
        "adresa" => "http://www.mvesti.rs"
    );
    
    spl_autoload_register(function($class){
        require "classes/class.".$class.".php";
    });
    
    require ("functions/function.sanitize.php");
    require ("functions/function.my_error_handler.php");
    require ("functions/function.mb_isupper.php");

?>