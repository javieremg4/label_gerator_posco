<?php
    function insert_label($id_parte,$id_inspec,$ran,$lote,$cantidad,$fecha_consumo,$origen){
        require "connection.php";
        $query = "SELECT serial FROM etiqueta WHERE id_parte='$id_parte' AND id_inspec='$id_inspec' AND ran='$ran' AND lote='$lote' AND cantidad='$cantidad' AND fecha_consumo='$fecha_consumo' AND origen='$origen'";
        $result = mysqli_query($connection,$query);
        if($result && mysqli_num_rows($result)>0){
            $result = mysqli_fetch_array($result);
            return $result['serial'];
        }
        $query = "INSERT INTO etiqueta (id_parte,id_inspec,ran,lote,cantidad,fecha_consumo,origen) VALUES ('$id_parte','$id_inspec','$ran','$lote','$cantidad','$fecha_consumo','$origen')";
        $result = mysqli_query($connection,$query);
        if($result){
            $query = "SELECT MAX(serial) AS serial FROM etiqueta";
            $result = mysqli_query($connection,$query);
            if($result){
                $result = mysqli_fetch_array($result);
                return $result['serial'];
            }else{
                return array(false,"No se pudo obtener el serial de la etiqueta. Consulte al Administrador");
            }
        }else{
            return array(false,"La etiqueta no se registro. Consulte al Administrador");
        }
    }
?>
