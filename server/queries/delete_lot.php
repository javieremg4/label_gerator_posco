<?php
    if(!isset($_POST['no-lote'])){
        header("location:../../pages/error.html");
    }
    function delete_lot($no_lote){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "UPDATE lote SET activo='0' WHERE no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        $result = mysqli_affected_rows($connection);
        mysqli_close($connection);
        if($result>-1){
            if($result===1){
                return jsonOK("Se eliminó el No. ".$no_lote);
            }else if($result>1){
                return jsonOK("Se eliminaron ".$result." registros con el No. ".$no_lote);
            }else{
                return jsonERR("Error: No se encontró el No. ".$no_lote);
            }
        }
        mysqli_close($connection);
        return jsonERR("Error: No se eliminaron los datos. Consulte al Administrador");
    }
?>
