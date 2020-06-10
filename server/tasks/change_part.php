<?php
    if(isset($_POST['no-parte'],$_POST['desc'],$_POST['esp'],$_POST['kgpc'],$_POST['snppz'],$_POST['parte'])){
        require "session_modules.php";
        require_once "../queries/update_part.php";
        if (get_magic_quotes_gpc()!=1){
            $_POST['desc']=addslashes($_POST['desc']);
        }
        $_POST['desc'] = htmlentities($_POST['desc']);
        $result = update_part(trim($_POST['no-parte']),trim($_POST['desc']),trim($_POST['esp']),trim($_POST['kgpc']),trim($_POST['snppz']),trim($_POST['parte']));
        echo $result;
    }
?>
