<?php
    if(!isset($_POST['lots_array']) && !isset($_POST['lot'],$_POST['wgt'],$_POST['yp'],$_POST['ts'],$_POST['el'],$_POST['tc'],$_POST['bc'])){
        header("location:../../pages/error.html");
    }
    function insert_lot($lot,$wgt,$yp,$ts,$el,$tc,$bc){
        require "connection.php";
        if(!isset($_POST['lots_array'])){   require "../tasks/jsonType.php";    }
        $query = "SELECT 1 FROM lote WHERE activo>0 AND no_lote='$lot'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                return jsonERR("Error: el No. ".$lot." ya está registrado");
            }
            $query = "INSERT INTO lote (no_lote,activo,peso_rollo,yp,ts,el,tc,bc) VALUES ('$lot','1','$wgt','$yp','$ts','$el','$tc','$bc')";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result){
                return jsonOK("No. ".$lot." registrado con éxito");
            }
        }
        mysqli_close($connection);
        return jsonERR("Error: los datos no se registraron");
    }
?>
