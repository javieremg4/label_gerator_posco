<?php
    function insertProperties($lot,$wgt,$yp,$ts,$el,$tc,$bc){
        require_once "connection.php";
        $query = "SELECT id_lote FROM lote WHERE no_lote='$lot'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                return "Ese No. Lote ya existe";
            }else{
                $query = "INSERT INTO lote (no_lote,peso_rollo,yp,ts,el,tc,bc) VALUES ('$lot','$wgt','$yp','$ts','$el','$tc','$bc')";
                $result = mysqli_query($connection,$query);
                if($result){
                    return "Registro exitoso";
                }
                mysqli_close($connection);
            }
        }
        return "Registro fallido";
    }
?>
