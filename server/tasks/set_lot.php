<?php
    if(isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'])){
        require "session_modules.php";
        session_modules();
        require "../queries/insert_lot.php";
        exit(insert_lot(trim($_POST['lot']),trim($_POST['wgt']),trim($_POST['yp']),trim($_POST['ts']),trim($_POST['el']),trim($_POST['tc']),trim($_POST['bc'])));
    }
    header("location:../../pages/error.html");
?>
