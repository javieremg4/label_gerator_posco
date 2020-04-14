<?php
    require_once "../queries/consult_part.php";
    if(isset($_POST['no-parte'])){
        if(!empty($_POST['no-parte'])){
            $result = consult_part($_POST['no-parte']);
            echo (empty($result)) ? "Sin sugerencias" : $result;
        }
    }
?>
