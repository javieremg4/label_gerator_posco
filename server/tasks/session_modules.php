<?php
    function session_modules(){
        session_start();
        if(!isset($_SESSION['user_name'],$_SESSION['user_role'])){
            exit(json_encode(
                array(
                    'status' => 'ERR',
                    'location' => 'index.php'
                )
            ));
        }
    }
    function session_modules_text(){
        session_start();
        if(!isset($_SESSION['user_name'],$_SESSION['user_role'])){
            exit("back-error");
        }
    }
?>
