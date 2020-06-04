<?php
    function insertProperties($lot,$wgt,$yp,$ts,$el,$tc,$bc){
        require "connection.php";
        $query = "SELECT id_lote FROM lote WHERE activo='1' AND no_lote='$lot'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                return "Error: ya existe un Lote con el No. ".$lot;
            }
            $query = "INSERT INTO lote (no_lote,activo,peso_rollo,yp,ts,el,tc,bc) VALUES ('$lot','1','$wgt','$yp','$ts','$el','$tc','$bc')";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result){
                return "Lote No. ".$lot." registrado con éxito";
            }
        }
        mysqli_close($connection);
        return "Error: el Lote no se registró.";
    }
?>
