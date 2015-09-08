<?php
    function sanitize($input) {
        $input=trim($input);
        $input=htmlentities($input,ENT_QUOTES,'UTF-8');
        return $input;
    }
?>