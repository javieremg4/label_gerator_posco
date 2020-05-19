<?php
    function update_part($no_parte,$desc,$esp,$kgpc,$parte){
        require_once "connection.php";
        $change_number = false;
        $bag = "";
        if($no_parte !== $parte){
            $query = "SELECT id_parte FROM parte WHERE no_parte='$no_parte'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection);
                    return "Error: ya existe una parte con el No.".$no_parte;
                }
            }else{
                mysqli_close($connection);
                return "Error: no se pudo actualizar la parte";
            }
            $change_number = true;
        }
        $query = "UPDATE parte SET no_parte='$no_parte',esp='$esp',`desc`='$desc',kgpc='$kgpc' WHERE no_parte='$parte'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if($change_number){
                return "No. Parte anterior:".$parte."<br>"."No. Parte actual:".$no_parte."<br>"."Parte actualizada con éxito";
            }else{
                return "Parte No.".$no_parte." actualizada con éxito";
            }
        }
        $bag .= " => Error: no se pudo actualizar la parte";
        return $bag;
    }
?>
