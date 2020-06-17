<?php
    if(isset($_POST['no-lote'])){
        require "session_modules.php";
        session_modules();
        require "../queries/delete_lot.php";
        exit(delete_lot($_POST['no-lote']));
    }
    header("location:../../pages/error.html");
?>
