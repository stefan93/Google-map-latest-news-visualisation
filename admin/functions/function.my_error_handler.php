<?php
    function my_error_handler($e_number,$e_msg,$e_file,$e_line,$e_vars) {
        $triger=false;
        if (Config::get("error_report")==="DEV") {
            $triger=true;
        };
        $msg="An error occured in script: '$e_file' on line '$e_line': '$e_msg' \n";
        $msg.=print_r($e_vars,1);
        if ($triger) {// DEV
            echo $msg;
            die();
        } else { //LIVE
            echo "
                <div class='error'>
                An error occured. We are working to fix this.
                </div>
            ";
            die();
        }
    }
    set_error_handler('my_error_handler');
?>