<?php
    session_start();
    if(isset($_SESSION['user_name'],$_SESSION['user_role'],$_GET['serial']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        require "../queries/consult_labels.php";
        checkSerial($_GET['serial'],"../../pages/error.html");
        exit(consult_label(base64_decode($_GET['serial'])));
    }
    header("location:../../pages/error.html");
?>
