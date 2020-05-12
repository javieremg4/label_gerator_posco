<?php
    function insert_equal_data($fecha_rollo,$fecha_lote,$bloque,$hora,$origen){
        require_once "connection.php";
        $query = "INSERT INTO datos_fijos (fecha_rollo,fecha_lote,bloque,hora_abasto,origen) VALUES ('$fecha_rollo','$fecha_lote','$bloque','$hora','$origen')";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            return "Datos actualizados con éxito";
        }
        return "Error: No se pudieron actualizador los datos";
    }
?>
