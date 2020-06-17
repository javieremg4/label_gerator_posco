<?php
    if(isset($_POST['no-lote'])){
        require "session_modules.php";
        session_modules();
        require "../queries/consult_lot.php";
        if(!empty($_POST['no-lote'])){
            exit(consult_lot($_POST['no-lote']));
        }
    }else if(isset($_POST['no-parte'])){
        require "session_modules.php";
        session_modules();
        require "../queries/consult_part.php";
        if(!empty($_POST['no-parte'])){
            exit(consult_part($_POST['no-parte']));
        }
    }
    header("location:../../pages/error.html");
?>
