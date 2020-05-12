<?php
    function data_part($no_parte){
        $array = search_part($no_parte,"no_parte,`desc`,esp,kgpc");
        if($array[0]){
            $info = $array[1];
            $data = "<table>
                    <tr><th>Parte BLK<th>Descripción<th>Kg./Pc<th>SPEC";
            $data .= "<tr><td>".$info['no_parte'];
            $data .= "<td>".$info['desc'];
            $data .= "<td>".$info['kgpc'];
            $data .= "<td>".$info['esp'];
            $data .= "</table>";
            return $data;
        }
        return $array[1];
    }
    function update_part($no_parte){
        $array = search_part($no_parte,"no_parte,`desc`,esp,kgpc");
        if($array[0]){
            $info = $array[1];
            $data = "<table><tr><th>No. Parte <th>Descripción<th>Especificación<th>Kg./Pc";
            $data .= "<tr><td><input type='text' id='no-parte' maxlength='13' value='".$info['no_parte']."'>";
            $data .= "<td><input type='text' id='desc' maxlength='50' value='".$info['desc']."'>";
            $data .= "<td><input type='text' id='esp' maxlength='15' value='".$info['esp']."'>";
            $data .= "<td><input type='text' id='kgpc' value='".$info['kgpc']."'>";
            $data .= "</table>";
            $data .= "<input type='submit' id='btn-update' value='Guardar Cambios'>";
            $data .= "<button id='btn-cancel'>Cancelar</button>";
            return $data;      
        }
        return $array[1];
    }
    function search_part($no_parte,$campos){
        require "connection.php";
        $query = "SELECT $campos FROM parte WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }else if(mysqli_num_rows($result)<=0){
                return array(false,"No se encontró la Parte. Revise el número ingresado");
            }else{
                return array(false,"Ese No. Parte existe más de una vez. Consulte al Administrador");
            }
        }
        return array(false,"No se pudieron consultar los datos de la Parte. Consulte al Administrador");
    }
?>
