<?php
    if(isset($_POST['noparte'],$_POST['cantidad'],$_POST['fecha'],$_POST['noran'],$_POST['lote'],$_POST['inspec'])){
        include "session_modules.php";
        require_once "../queries/generate_label.php";
        $result = generate_label(trim($_POST['noparte']),trim($_POST['cantidad']),trim($_POST['fecha']),trim($_POST['noran']),trim($_POST['lote']),trim($_POST['inspec']));
        echo $result;
    }
?>
