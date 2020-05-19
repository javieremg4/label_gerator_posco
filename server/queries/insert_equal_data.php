<?php
    function insert_equal_data($fecha_rollo,$fecha_lote,$bloque,$hora,$origen){
        require_once "connection.php";
        require_once "equal_data.php";
        $result = search_equal_data("fecha_lote,fecha_rollo,bloque,origen,DATE_FORMAT(hora_abasto,'%H:%i') AS hora_abasto");
        if($result[0]){
            $result = $result[1];
            if($fecha_rollo!==$result['fecha_rollo'] || $fecha_lote!==$result['fecha_lote'] || $bloque!==$result['bloque'] || $hora!==$result['hora_abasto'] || $origen!==$result['origen']){
                $query = "INSERT INTO datos_fijos (fecha_rollo,fecha_lote,bloque,hora_abasto,origen) VALUES ('$fecha_rollo','$fecha_lote','$bloque','$hora','$origen')";
                $result = mysqli_query($connection,$query);
                mysqli_close($connection);
                if($result){
                    return "Datos actualizados con éxito";
                } 
            }else{
                return "Datos actualizados con éxito";
            }  
        }
        mysqli_close($connection);
        return "Error: No se pudieron actualizar los datos.";
    }
?>
