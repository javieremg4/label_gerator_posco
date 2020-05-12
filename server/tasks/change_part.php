<?php
    if(isset($_POST['no-parte'],$_POST['desc'],$_POST['esp'],$_POST['kgpc'],$_POST['parte'])){
        require_once "../queries/update_part.php";
        $result = update_part(trim($_POST['no-parte']),trim($_POST['desc']),trim($_POST['esp']),trim($_POST['kgpc']),trim($_POST['parte']));
        echo $result;
    }
?>
