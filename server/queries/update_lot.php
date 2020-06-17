<?php
    if(!isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'],$_POST['no-lote'])){
        header("location:../../pages/error.html");
    }
    function update_lot($lot,$wgt,$yp,$ts,$el,$tc,$bc,$no_lote){
        require "../queries/data_lot.php";
        require "../tasks/jsonType.php";
        $result = search_lot($no_lote,'no_lote,peso_rollo,yp,ts,el,tc,bc',false);
        if($result[0]){
            $result = $result[1];
            if($lot===$result['no_lote'] && $wgt===$result['peso_rollo'] && $yp===$result['yp'] && $ts===$result['ts'] && $el===$result['el'] && $tc===$result['tc'] && $bc===$result['bc']){
                return jsonOK("No. ".$no_lote." actualizado con éxito");
            }
        }else{
            return jsonERR("Error: No se pudieron actualizar los Datos. Consulte al Administrador");
        }
        require "connection.php";
        $change_number = false;
        if($lot !== $no_lote){
            $query = "SELECT 1 FROM lote WHERE activo>0 AND no_lote='$lot'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection);
                    return jsonERR("Error: el No. ".$lot." ya está registrado");
                }
            }else{
                mysqli_close($connection);
                return jsonERR("Error: no se pudieron actualizar los datos. Consulte al Administrador");
            }
            $change_number = true;
        }
        $query = "UPDATE lote SET activo='2',no_lote='$lot',peso_rollo='$wgt',yp='$yp',ts='$ts',el='$el',tc='$tc',bc='$bc' WHERE activo>0 AND no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if($change_number){
                return jsonOK("<div class='pre'>No. Inspección actualizado con éxito\nNo. anterior: ".$no_lote."\nNo. actual: ".$lot."</div>");
            }else{
                return jsonOK("No. ".$lot." actualizado con éxito");
            }
        }
        return jsonERR("Error: no se pudieron actualizar los datos. Consulte al Administrador");
    }
?>
