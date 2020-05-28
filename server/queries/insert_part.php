<?php
    function insert_part($no_parte,$desc,$esp,$kgpc,$snppz){
        require_once "connection.php";
        $query = "SELECT id_parte FROM parte WHERE activo='1' AND no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                return "Error: ya existe una Parte con el No. ".$no_parte;
            }
            $query = "INSERT INTO parte (no_parte,activo,`desc`,esp,kgpc,snppz) VALUES ('$no_parte','1','$desc','$esp','$kgpc','$snppz')";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result){
                return "Parte No. ".$no_parte." registrada con éxito";
            }
        }
        mysqli_close($connection);
        return "Error: la Parte no se registró";
    }
?>
