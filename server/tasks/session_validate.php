<?php
    session_start();
    if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
        echo $_SESSION['user_role'];
        exit;
    }
    echo "false";
?>
