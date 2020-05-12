<?php
    if(isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'],$_POST['no-lote'])){
        require_once '../queries/update_lote.php';
        $result = update_lote(trim($_POST['lot']),trim($_POST['wgt']),trim($_POST['yp']),trim($_POST['ts']),trim($_POST['el']),trim($_POST['tc']),trim($_POST['bc']),trim($_POST['no-lote']));
        echo $result; 
    }
?>
