<?php
    if(!isset($_POST['no-parte'],$_POST['desc'],$_POST['esp'],$_POST['kgpc'],$_POST['snppz'])){
        header("location:../../pages/error.html");
    }
    function insert_part($no_parte,$desc,$esp,$kgpc,$snppz){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "SELECT 1 FROM parte WHERE activo>0 AND no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection);
                return jsonERR("Error: ya existe una Parte con el No. ".$no_parte);
            }
            $query = "INSERT INTO parte (no_parte,activo,`desc`,esp,kgpc,snppz) VALUES ('$no_parte','1','$desc','$esp','$kgpc','$snppz')";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result){
                return jsonOK("Parte No. ".$no_parte." registrada con éxito");
            }
        }
        mysqli_close($connection);
        return jsonERR("Error: la Parte no se registró");
    }
?>
