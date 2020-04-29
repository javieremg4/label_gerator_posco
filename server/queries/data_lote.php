<?php
    function data_lote($no_lote){
        $array = search_lote($no_lote);
        if($array[0]){
            $info = $array[1];
            $data = "<table><tr><th>Lot No. <th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM";
            $data .= "<tr><td>".$info['no_lote'];
            $data .= "<td>".$info['peso_rollo'];
            $data .= "<td>".$info['yp'];
            $data .= "<td>".$info['ts'];
            $data .= "<td>".$info['el'];
            $data .= "<td>".$info['tc'];
            $data .= "<td>".$info['bc'];
            $data .= "</table>";
            return $data;
        }
        return $array[1];
    }
    function  view_data_lote($no_lote){
        $array = search_lote($no_lote);
        if($array[0]){
            $info = $array[1];
            $data = "<table><tr><th>Inspeccion <th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM";
            $data .= "<tr><td><input type='text' id='lot' value='".$info['no_lote']."' maxlength='15'>";
            $data .= "<td><input type='text' id='wgt' value='".$info['peso_rollo']."' maxlength='7'>";
            $data .= "<td><input type='text' id='yp' value='".$info['yp']."' maxlength='6'>";
            $data .= "<td><input type='text' id='ts' value='".$info['ts']."' maxlength='6'>";
            $data .= "<td><input type='text' id='el' value='".$info['el']."' maxlength='6'>";  
            $data .= "<td><input type='text' id='tc' value='".$info['tc']."' maxlength='6'>";
            $data .= "<td><input type='text' id='bc' value='".$info['bc']."' maxlength='6'>";
            $data .= "</table>";
            $data .= "<input type='submit' id='btn-update' value='Guardar Cambios'>";
            $data .= "<button id='btn-cancel'>Cancelar</button>";
            return $data;      
        }
        return $array[1];
    }
    function search_lote($no_lote){
        require "connection.php";
        $query = "SELECT no_lote,peso_rollo,yp,ts,el,tc,bc FROM lote WHERE no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }else if(mysqli_num_rows($result)<=0){
                return array(false,"No se encontró el Lote. Revise el número ingresado");
            }else{
                return array(false,"Ese No. Lote existe más de una vez. Consulte al Administrador");
            }
        }
        return array(false,"No se pudieron consultar los datos del Lote");
    }
?>
