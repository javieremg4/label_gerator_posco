<?php
    if(isset($_POST['no-lote'])){
        require_once "../queries/consult_lote.php";
        if(!empty($_POST['no-lote'])){
            $result = consult_lote($_POST['no-lote']);
            echo (empty($result)) ? "Sin sugerencias" : $result;
        }
    }else if(isset($_POST['no-parte'])){
        require_once "../queries/consult_part.php";
        if(!empty($_POST['no-parte'])){
            $result = consult_part($_POST['no-parte']);
            echo (empty($result)) ? "Sin sugerencias" : $result;
        }
    }
?>
