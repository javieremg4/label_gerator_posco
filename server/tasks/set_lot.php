<?php
    if(isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'])){
        include "session_modules.php";
        require_once "../queries/insert_lot.php";
        $result = insertProperties(trim($_POST['lot']),trim($_POST['wgt']),trim($_POST['yp']),trim($_POST['ts']),trim($_POST['el']),trim($_POST['tc']),trim($_POST['bc']));
        echo $result;
    }
?>