<?php
    function insert_label($id_parte,$id_inspec,$ran,$lote,$cantidad,$fecha_consumo,$id_fijos){
        require "connection.php";
        $query = "SELECT serial FROM etiqueta WHERE id_parte='$id_parte' AND id_inspec='$id_inspec' AND ran='$ran' AND lote='$lote' AND cantidad='$cantidad' AND fecha_consumo='$fecha_consumo' AND id_fijos='$id_fijos'"; 
        $result = mysqli_query($connection,$query);
        if($result && mysqli_num_rows($result)>0){
            mysqli_close($connection);
            $result = mysqli_fetch_array($result);
            return $result['serial'];
        }
        $query = "INSERT INTO etiqueta (id_parte,id_inspec,ran,lote,cantidad,fecha_consumo,id_fijos) VALUES ('$id_parte','$id_inspec','$ran','$lote','$cantidad','$fecha_consumo','$id_fijos')";
        $result = mysqli_query($connection,$query);
        if($result){
            $query = "SELECT MAX(serial) AS serial FROM etiqueta";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result){
                $result = mysqli_fetch_array($result);
                return $result['serial'];
            }else{
                return array(false,"No se pudo obtener el serial de la etiqueta. Consulte al Administrador");
            }
        }else{
            mysqli_close($connection);
            return array(false,"La etiqueta no se registro. Consulte al Administrador");
        }
    }
?>
