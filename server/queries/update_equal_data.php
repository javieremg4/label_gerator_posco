<?php
    function update_equal_data($fecha_rollo,$fecha_lote,$bloque,$hora){
        require_once "connection.php";
        $query = "UPDATE datos_fijos SET fecha_rollo='$fecha_rollo',fecha_lote='$fecha_lote',bloque='$bloque',hora_abasto='$hora' WHERE id=1";
        $result = mysqli_query($connection,$query);
        if($result){
            return "Datos actualizados con éxito";
        }
        return "Error: No se pudieron actualizador los datos";
    }
?>
