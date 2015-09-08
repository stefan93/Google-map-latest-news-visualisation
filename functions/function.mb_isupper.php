<?php

function mb_isupper($str) {
$a=$str;
return mb_strtolower($str, "UTF-8") != $a;
}

?>