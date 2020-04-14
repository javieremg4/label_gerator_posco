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
?>
