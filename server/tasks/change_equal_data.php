<?php
    if(isset($_POST['fecha-rollo'],$_POST['fecha-lote'],$_POST['bloque'],$_POST['hora'],$_POST['origen'])){
        include "session_modules.php";
        require_once "../queries/insert_equal_data.php";
        $result = insert_equal_data(trim($_POST['fecha-rollo']),trim($_POST['fecha-lote']),trim($_POST['bloque']),trim($_POST['hora']),trim($_POST['origen']));
        echo $result;
    }
?>
