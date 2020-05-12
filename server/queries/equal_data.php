<?php
    function equal_data(){
        $array = search_equal_data("fecha_lote,fecha_rollo,bloque,origen,DATE_FORMAT(hora_abasto,'%h:%i') AS hora_abasto");
        if($array[0]){
            $info = $array[1];
            $data = "<table>";
            $data .= "<tr><th>Fecha de creación de lote<th>Fecha de ingreso de rollo a planta<th>Bloque<th>Hora de abasto<th>Origen<tr>";
            $data .= "<td><input type='text' id='fecha-lote' value='".$info['fecha_lote']."' minlength='13' maxlength='13'>";
            $data .= "<td><input type='text' id='fecha-rollo' value='".$info['fecha_rollo']."' minlength='13' maxlength='13'>";
            $data .= "<td><input type='text' id='bloque' value='".$info['bloque']."' maxlength='10'>";
            $data .= "<td><input type='time' id='hora' value='".$info['hora_abasto']."'>";
            $data .= "<td><input type='text' id='origen' value='".$info['origen']."' maxlength='8'>";
            $data .= "</table>";
            $data .= "<div id='div-btn'><input type='submit' value='Actualizar'></div>";
            return $data;
        }
        return false;
    }
    function search_equal_data($campos){
        require "connection.php";
        //La consulta regresa los campos del ultimo elemento de la tabla 'datos_fijos'
        $query = "SELECT $campos FROM datos_fijos WHERE id=(SELECT MAX(id) FROM datos_fijos)";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }
        }
        return array(false,"No se pudieron consultar los datos fijos de la etiqueta. Consulte al Administrador");
    }
?>
