<?php
    if(isset($_POST['user'],$_POST['pass'],$_POST['type'])){
        require "session_modules.php";
        session_modules();
        require "../queries/insert_user.php";
        exit(insert_user(trim($_POST['user']),trim($_POST['pass']),trim($_POST['type'])));
    }
    header("location:../../pages/error.html");
?>