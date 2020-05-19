<?php
    session_start();
    if(!isset($_SESSION['user_name'],$_SESSION['user_role'])){
        echo "back-error";
        exit;
    }
?>
