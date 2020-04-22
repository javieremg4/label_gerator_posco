<?php
    if(isset($_GET['view'])){
        if($_GET['view'] === '1'){
            require_once "../queries/equal_data.php";
            $result = equal_data();
            echo (!$result) ? "Error: No se pudieron mostrar los datos" : $result;
        }else{
            echo "Error: No se pudo mostrar la infomación";
        }
    }else{
        echo "Error: No se pudo mostrar la infomación";
    }
?>
