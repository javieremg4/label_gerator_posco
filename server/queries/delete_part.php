<?php
    if(!isset($_POST['no-parte'])){
        header("location:../../pages/error.html");
    }
    function delete_part($no_parte){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "UPDATE parte SET activo='0' WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        $result = mysqli_affected_rows($connection);
        mysqli_close($connection);
        if($result>-1){
            if($result===1){
                return jsonOK("Se eliminó la parte No. ".$no_parte);
            }else if($result>1){
                return jsonOK("Se eliminaron ".$result." partes con el No. ".$no_parte);
            }else{
                return jsonERR("Error: No se encontró la Parte No. ".$no_parte);
            }
        }
        mysqli_close($connection);
        return jsonERR("Error: No se eliminó la parte. Consulte al Administrador");
    }
?>
