<?php
    function insertProperties($lot,$wgt,$yp,$ts,$el,$tc,$bc){
        require_once "connection.php";
        $query = "INSERT INTO lote (no_lote,peso_rollo,yp,ts,el,tc,bc) VALUES ('$lot','$wgt','$yp','$ts','$el','$tc','$bc')";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        return $result;
    }
?>
