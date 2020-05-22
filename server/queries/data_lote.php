<?php
    function data_lote($no_lote){
        $array = search_lote($no_lote,'no_lote,peso_rollo,yp,ts,el,tc,bc');
        if($array[0]){
            $info = $array[1];
            $data = "<table class='table-style'>
                    <tr><th>Lot No. <th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM";
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
        $array = search_lote($no_lote,'no_lote,peso_rollo,yp,ts,el,tc,bc');
        if($array[0]){
            $info = $array[1];
            $data = "<div class='div-part'>
                        Inspeccion
                        <input type='text' id='lot' value='".$info['no_lote']."' maxlength='15'>
                    </div>";
            $data .= "<div class='div-part'>
                        Peso (MT)
                        <input type='text' id='wgt' value='".$info['peso_rollo']."' maxlength='7'>
                    </div>";
            $data .= "<div class='div-part'>
                        YP
                        <input type='text' id='yp' value='".$info['yp']."' maxlength='6'>
                    </div>";
            $data .= "<div class='div-part'>
                        TS
                        <input type='text' id='ts' value='".$info['ts']."' maxlength='6'>
                    </div>";
            $data .= "<div class='div-part'>
                        EL
                        <input type='text' id='el' value='".$info['el']."' maxlength='6'>
                    </div>";
            $data .= "<div class='div-part'>
                        TOP
                        <input type='text' id='tc' value='".$info['tc']."' maxlength='6'>
                    </div>";
            $data .= "<div class='div-part'>
                        BOTTOM
                        <input type='text' id='bc' value='".$info['bc']."' maxlength='6'>
                    </div>";
            $data .= "<div class='div-center'>
                        <input type='submit' id='btn-lot' value='Guardar Cambios'>
                        <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                    </div>";
            return $data;      
        }
        return $array[1];
    }
    function search_lote($no_lote,$campos){
        require "connection.php";
        $query = "SELECT $campos FROM lote WHERE no_lote='$no_lote'";
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
        return array(false,"No se pudieron consultar los datos del Lote. Consulte al Administrador");
    }
?>
