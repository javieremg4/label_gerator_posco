<?php
    if(isset($_POST['user'],$_POST['pass'],$_POST['type'])){
        include "session_modules.php";
        require_once "../queries/insert_user.php";
        $result = insert_user(trim($_POST['user']),trim($_POST['pass']),trim($_POST['type']));
        echo $result;
    }
?>