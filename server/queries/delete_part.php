<?php
    function delete_part($no_parte){
        require_once "connection.php";
        $query = "UPDATE parte SET activo='0' WHERE no_parte='$no_parte'";
        $result = mysqli_query($connection,$query);
        if(mysqli_affected_rows($connection)>-1){
            if(mysqli_affected_rows($connection)===1){
                return "Se eliminó la parte No. ".$no_parte;
            }else if(mysqli_affected_rows($connection)===0){
                return "Error: No se encontró la Parte No. ".$no_parte;
            }else{
                return "Se eliminaron ".mysqli_affected_rows($connection)." partes con el No. ".$no_parte;
            }
        }
        return "Error: No se eliminó la parte. Consulte al Administrador";
    }
?>
