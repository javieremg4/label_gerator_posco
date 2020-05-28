<?php
    function update_part($no_parte,$desc,$esp,$kgpc,$snppz,$parte){
        require_once "connection.php";
        $change_number = false;
        if($no_parte !== $parte){
            $query = "SELECT id_parte FROM parte WHERE activo='1' AND no_parte='$no_parte'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection);
                    return "Error: ya existe una parte con el No. ".$no_parte;
                }
            }else{
                mysqli_close($connection);
                return "Error: No se pudo actualizar la parte. Consulte al Administrador";
            }
            $change_number = true;
        }
        $query = "UPDATE parte SET no_parte='$no_parte',esp='$esp',`desc`='$desc',kgpc='$kgpc',snppz='$snppz' WHERE no_parte='$parte'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if($change_number){
                return "<div class='pre'>Parte actualizada con éxito\nNo. anterior: ".$parte."\nNo. actual: ".$no_parte."</div>";
            }else{
                return "Parte No. ".$no_parte." actualizada con éxito";
            }
        }
        return "Error: No se pudo actualizar la parte. Consulte al Administrador";
    }
?>
