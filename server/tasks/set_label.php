<?php
    if(isset($_POST['noparte'],$_POST['cantidad'],$_POST['fecha'],$_POST['noran'],$_POST['nolote'],$_POST['inspec'])){
        require "session_modules.php";
        session_modules();
        require "../tasks/jsonType.php";
        require "../queries/generate_label.php";
        exit(generate_label(true,null,trim($_POST['noparte']),trim($_POST['cantidad']),trim($_POST['fecha']),trim($_POST['noran']),trim($_POST['nolote']),trim($_POST['inspec'])));
    }
    header("location:../../pages/error.html");
?>
