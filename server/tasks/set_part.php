<?php
    if(isset($_POST['no-parte'],$_POST['desc'],$_POST['esp'],$_POST['kgpc'],$_POST['snppz'])){
        require "session_modules.php";
        session_modules();
        require "../queries/insert_part.php";
        if (get_magic_quotes_gpc()!=1){
            $_POST['desc']=addslashes($_POST['desc']);
        }
        $_POST['desc'] = htmlentities($_POST['desc']);
        exit(insert_part(trim($_POST['no-parte']),trim($_POST['desc']),trim($_POST['esp']),trim($_POST['kgpc']),trim($_POST['snppz'])));
    }
    header("location:../../pages/error.html");
?>
