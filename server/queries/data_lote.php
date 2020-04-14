<?php
    function data_lote($no_lote){
        require_once "connection.php";
        $query = "SELECT no_lote,peso_rollo,yp,ts,el,tc,bc FROM lote WHERE no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        if($result && mysqli_num_rows($result)===1){
            $info = mysqli_fetch_array($result);
            $data = "<table>
                    <tr><th>Inspeccion <th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM";
            $data .= "<tr><td>".$info['no_lote'];
            $data .= "<td>".$info['peso_rollo'];
            $data .= "<td>".$info['yp'];
            $data .= "<td>".$info['ts'];
            $data .= "<td>".$info['el'];
            $data .= "<td>".$info['tc'];
            $data .= "<td>".$info['bc'];
            $data .= "</table>";
            return $data;
        }else{
            return "";
        }
    }
?>
