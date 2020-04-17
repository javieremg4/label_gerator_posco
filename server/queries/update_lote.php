<?php
    function update_lote($lot,$wgt,$yp,$ts,$el,$tc,$bc,$no_lote){
        require_once "connection.php";
        $change_number = false;
        if($lot !== $no_lote){
            $query = "SELECT id_lote FROM lote WHERE no_lote='$lot'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection);
                    return "Error: ya existe un lote con el No.".$lot;
                }
            }else{
                mysqli_close($connection);
                return "Error: no se pudo actualizar el lote";
            }
            $change_number = true;
        }
        $query = "UPDATE lote SET no_lote='$lot',peso_rollo='$wgt',yp='$yp',ts='$ts',el='$el',tc='$tc',bc='$bc' WHERE no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if($change_number){
                return "No. Lote anterior:".$no_lote."<br>"."No. Lote actual:".$lot."<br>"."Lote actualizado con éxito";
            }else{
                return "Lote No.".$lot." actualizado con éxito";
            }
        }
        return "Error: no se pudo actualizar el lote";
    }
?>
