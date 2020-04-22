<?php
    function data_part($no_parte){
        require_once "connection.php";
        $query = "SELECT no_parte,`desc`,esp,kgpc FROM parte WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        if($result && mysqli_num_rows($result)===1){
            $info = mysqli_fetch_array($result);
            $data = "<table>
                    <tr><th>Parte BLK<th>Descripción<th>Kg./Pc<th>SPEC";
            $data .= "<tr><td>".$info['no_parte'];
            $data .= "<td>".$info['desc'];
            $data .= "<td>".$info['kgpc'];
            $data .= "<td>".$info['esp'];
            $data .= "</table>";
            return $data;
        }else{
            return "";
        }
    }
    function update_part($no_parte){
        $info = search_part($no_parte);
        if(!(!$info)){
            $data = "<table><tr><th>No. Parte <th>Descripción<th>Especificación<th>Kg./Pc";
            $data .= "<tr><td><input type='text' id='no-parte' maxlength='13' value='".$info['no_parte']."'>";
            $data .= "<td><input type='text' id='desc' maxlength='50' value='".$info['desc']."'>";
            $data .= "<td><input type='text' id='esp' maxlength='15' value='".$info['esp']."'>";
            $data .= "<td><input type='text' id='kgpc' value='".$info['kgpc']."'>";
            $data .= "</table>";
            $data .= "<input type='submit' id='btn-update' value='Guardar Cambios'>";
            $data .= "<button id='btn-cancel'>Cancelar</button>";
            return $data;      
        }else{
            return "";
        }
    }
    function search_part($no_parte){
        require "connection.php";
        $query = "SELECT no_parte,`desc`,esp,kgpc FROM parte WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result && mysqli_num_rows($result)===1){
            return mysqli_fetch_array($result);
        }else{
            return false;
        }
    }
?>
