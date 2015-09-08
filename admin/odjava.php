<?php
require ("core/init.php");
unset($GLOBALS);
session_destroy();
unset($_SESSION);
header("Location:index.php");
?>