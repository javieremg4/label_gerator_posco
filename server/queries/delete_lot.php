<?php
    function delete_part($no_lote){
        require_once "connection.php";
        $query = "UPDATE lote SET activo='0' WHERE no_lote='$no_lote'";
        $result = mysqli_query($connection,$query);
        if(mysqli_affected_rows($connection)>-1){
            if(mysqli_affected_rows($connection)===1){
                return "Se eliminó el lote No. ".$no_lote;
            }else if(mysqli_affected_rows($connection)===0){
                return "Error: No se encontró la Parte No. ".$no_lote;
            }else{
                return "Se eliminaron ".mysqli_affected_rows($connection)." lotes con el No. ".$no_lote;
            }
        }
        return "Error: No se eliminó el lote. Consulte al Administrador";
    }
?>
