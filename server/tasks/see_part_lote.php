<?php
    if(isset($_POST['no-lote'])){
        require_once "../queries/data_lote.php";
        $result = data_lote($_POST['no-lote']);
        echo (!empty($result)) ? $result : "No se encontró el lote";
    }else if(isset($_POST['no-parte'])){
        require_once "../queries/data_part.php";
        $result = data_part($_POST['no-parte']);
        echo (!empty($result)) ? $result : "No se encontró la parte";
    }
?>
