<?php
    if(!isset($_POST['noparte'],$_POST['cantidad'],$_POST['fecha'],$_POST['noran'],$_POST['nolote'],$_POST['inspec'])){
        header("location:../../pages/error.html");
    }
    /* función insert_label: inserta una etiqueta en la BDD y retorna el serial correspondiente
        NOTA: Si la etiqueta no se registró se retorna un array( false , mensaje_de_error ) 
        Parametros
            - id_parte: id de la parte que va en la etiqueta
            - id_inspec: id de la inspección (lote) que va en la etiqueta
            - ran: ran de la etiqueta
            - lote: no. lote de la etiqueta
            - fecha_consumo: fecha (hoy) de la etiqueta
            - id_fijos: id de los datos fijos que le corresponden a la etiqueta
    */
    function insert_label($id_parte,$id_inspec,$ran,$lote,$cantidad,$fecha_consumo,$id_fijos){
        require "connection.php";
        $query = "SELECT serial FROM etiqueta WHERE id_parte='$id_parte' AND id_inspec='$id_inspec' AND ran='$ran' AND lote='$lote' AND cantidad='$cantidad' AND fecha_consumo='$fecha_consumo' AND id_fijos='$id_fijos'"; 
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                $result = mysqli_fetch_array($result);
                return $result['serial'];
            }else{
                $query = "INSERT INTO etiqueta (id_parte,id_inspec,ran,lote,cantidad,fecha_consumo,id_fijos) VALUES ('$id_parte','$id_inspec','$ran','$lote','$cantidad','$fecha_consumo','$id_fijos')";
                $result = mysqli_query($connection,$query);
                if($result){
                    $query = "SELECT MAX(serial) AS serial FROM etiqueta";
                    $result = mysqli_query($connection,$query);
                    mysqli_close($connection);
                    if($result){
                        $result = mysqli_fetch_array($result);
                        return $result['serial'];
                    }
                }
            }
        }
        mysqli_close($connection);
        return array(false,"La etiqueta no se registro. Consulte al Administrador");
    }
?>
