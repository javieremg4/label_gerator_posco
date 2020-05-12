<?php
    require_once "../queries/equal_data.php";
    $result = equal_data();
    echo (!$result) ? "Error: No se pudieron mostrar los datos" : $result;
?>
