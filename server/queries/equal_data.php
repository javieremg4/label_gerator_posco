<?php
    function equal_data(){
        $info = search_equal_data();
        if(!(!$info)){
            $data = "<table>";
            $data .= "<tr><th>Fecha de creación de lote<th>Fecha de ingreso de rollo a planta<th>Bloque<th>Hora de abasto<tr>";
            $data .= "<td><input type='text' id='fecha-lote' value='".$info['fecha_lote']."' maxlength='13'>";
            $data .= "<td><input type='text' id='fecha-rollo' value='".$info['fecha_rollo']."' maxlength='13'>";
            $data .= "<td><input type='text' id='bloque' value='".$info['bloque']."' maxlength='10'>";
            $data .= "<td><input type='time' id='hora' value='".$info['hora_abasto']."'>";
            $data .= "</table>";
            $data .= "<div id='div-btn'><input type='submit' value='Actualizar'></div>";
            return $data;
        }
        return false;
    }
    function search_equal_data(){
        require "connection.php";
        $query = "SELECT fecha_lote,fecha_rollo,bloque,DATE_FORMAT(hora_abasto,'%h:%i') AS hora_abasto FROM datos_fijos WHERE id='1'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)===1){
                mysqli_close($connection);
                return mysqli_fetch_array($result);
            }
        }
        mysqli_close($connection);
        return false;
    }
?>
