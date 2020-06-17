<?php
    if(isset($_POST['fecha-rollo'],$_POST['fecha-lote'],$_POST['bloque'],$_POST['hora'],$_POST['origen'])){
        require "session_modules.php";
        session_modules();
        require "../queries/insert_equal_data.php";
        exit(insert_equal_data(trim($_POST['fecha-rollo']),trim($_POST['fecha-lote']),trim($_POST['bloque']),trim($_POST['hora']),trim($_POST['origen'])));
    }
    header("location:../../pages/error.html");
?>
