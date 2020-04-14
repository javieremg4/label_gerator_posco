<?php
    if(isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'])){
        require_once "../queries/insert_properties.php";
        $result = insertProperties($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc']);
        echo ($result) ? "<span class='green'>Registro exitoso</span>" : "<span class='red'>Registro fallido</span>";
    }
?>
