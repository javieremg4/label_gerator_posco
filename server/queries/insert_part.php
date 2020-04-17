<?php
    function insert_part($no_parte,$desc,$esp,$kgpc){
        require_once "connection.php";
        $query = "SELECT id_parte FROM parte WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                return "Error: ya existe una Parte con el No. ".$no_parte;
            }
        }else{
            mysqli_close($connection);
            return "Error: la Parte no se registro";
        }
        $query = "INSERT INTO parte (no_parte,`desc`,esp,kgpc) VALUES ('$no_parte','$desc','$esp','$kgpc')";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            return "Parte registrada con éxito";
        }
        return "Error: la Parte no se registro";
    }
?>
