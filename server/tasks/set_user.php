<?php
    if(isset($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['type'])){
        require "session_modules.php";
        session_modules();
        require "../queries/insert_user.php";
        //echo "||".$_POST['pass']."||";
        exit(insert_user(trim($_POST['user']),$_POST['pass'],trim($_POST['email']),trim($_POST['type'])));
    }
    header("location:../../pages/error.html");
?>
