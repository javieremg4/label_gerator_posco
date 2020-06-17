<?php
    function data_lot($no_lote,$btn){
        $array = search_lot($no_lote,'no_lote,peso_rollo,yp,ts,el,tc,bc',false);
        if($array[0]){
            $info = $array[1];
            $data = "<div class='ovx'>";
            $data .= "<table class='table-style'>
                    <tr><th>No. Inspección<th>Wgt.<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM";
            $data .= "<tr><td>".$info['no_lote'];
            $data .= "<td>".$info['peso_rollo'];
            $data .= "<td>".$info['yp'];
            $data .= "<td>".$info['ts'];
            $data .= "<td>".$info['el'];
            $data .= "<td>".$info['tc'];
            $data .= "<td>".$info['bc'];
            $data .= "</table>";
            $data .= "</div>";
            if(isset($btn)){
                $data .= "<div class='div-center mt10'>
                        <input type='submit' id='btn-lot' value='Eliminar'>
                        <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                    </div>";
            }
            return array(
                "status" => "OK",
                "content" => $data
            );
        }
        if(isset($array[2],$btn)){
            $data = $array[1];
            $data .= "<div class='div-center mt10'>
                        <input type='submit' id='btn-submit' value='Eliminar Nros. Insp'>
                        <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                    </div>";
            return array(
                "status" => "OK",
                "content" => $data
            );
        }
        return array(
            "status" => "ERR",
            "message" => $array[1]
        );
    }
    function  view_data_lote($no_lote){
        $array = search_lot($no_lote,'id_lote,no_lote,peso_rollo,yp,ts,el,tc,bc',false);
        if($array[0]){
            $info = $array[1];
            $data = "<div class='div-part'>
                        No. Inspección
                        <input type='text' id='lot' value='".$info['no_lote']."' maxlength='15'>
                    </div>";
            $data .= "<div class='div-part'>
                        Wgt.
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
            $note = "<div class='div-note'><h3>NOTA</h3> Si actualiza los datos de este No. Inspección y ya había etiquetas registradas con ese lote, <u>las etiquetas podrían sufrir cambios</u>.<label id='lblx'>&times</label></div>";
            require "connection.php";
            $query = "select count(id_inspec) as lbls from etiqueta where id_inspec=".$info['id_lote'];
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result = mysqli_fetch_array($result)){
                if($result['lbls']>0){
                    $data .= "<div class='div-note'><h3>NOTA</h3> Si actualiza los datos de este No. Inspección <u>".$result['lbls'];
                    $data .= ($result['lbls']==='1') ? " etiqueta podría " : " etiquetas podrían ";
                    $data .=  " sufrir cambios</u><label id='lblx'>&times</label></div>";
                }   
            }else{
                $data .= $note;
            }
            return array(
                "status" => "OK",
                "content" => $data
            );     
        }
        return array(
            "status" => "ERR",
            "message" => $array[1]
        );
    }
    function search_lot($no_lote,$campos,$inactivos){
        require "connection.php";
        $query = "SELECT $campos FROM lote WHERE no_lote='$no_lote'";
        if(!$inactivos){ $query .= " AND activo>0"; } 
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }else if(mysqli_num_rows($result)<=0){
                return array(false,"No se encontró el No. Inspección. Revise el número ingresado");
            }else{
                return array(false,"Ese No. Inspección existe ".mysqli_num_rows($result)." veces. Consulte al Administrador",mysqli_num_rows($result));
            }
        }
        return array(false,"No se pudieron consultar los datos del No. Inspección. Consulte al Administrador");
    }
?>
