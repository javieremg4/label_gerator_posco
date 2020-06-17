<?php
    if(isset($_POST['n']) || isset($_POST['date'])){
        require "session_modules.php";
        session_modules();
        require "../queries/consult_labels.php";
        if(!empty($_POST['n']) && is_numeric($_POST['n'])){
            if ($_POST['n']>0){
                exit(consult_labels($_POST['n'],null));                
            }
        }else if(!empty($_POST['date'])){
            exit(consult_labels(null,$_POST['date']));
        }
    }
    header("location:../../pages/error.html");
?>
