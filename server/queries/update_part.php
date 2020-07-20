<?php
    if(!isset($_POST['no-parte'],$_POST['desc'],$_POST['esp'],$_POST['kgpc'],$_POST['snppz'],$_POST['parte'])){
        header("location:../../pages/error.html");
    }
    function update_part_module($no_parte,$desc,$esp,$kgpc,$snppz,$parte){
        require "../queries/data_part.php";
        require "../tasks/jsonType.php";
        $result = search_part(null,$parte,"no_parte,`desc`,esp,kgpc,snppz",false);
        if($result[0]){
            $result = $result[1];
            if($no_parte===$result['no_parte'] && $desc===$result['desc'] && $esp===$result['esp'] && $kgpc===$result['kgpc'] && $snppz===$result['snppz']){
                return jsonOK("Parte No. ".$parte." actualizada con éxito");
            }
        }else{
            return jsonERR("Error: No se pudo actualizar la parte. Consulte al Administrador");
        }
        require "connection.php";
        $change_number = false;
        if($no_parte !== $parte){
            $query = "SELECT 1 FROM parte WHERE activo>0 AND no_parte='$no_parte'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection);
                    return jsonERR("Error: ya existe una parte con el No. ".$no_parte);
                }
            }else{
                mysqli_close($connection);
                return jsonERR("Error: No se pudo actualizar la parte. Consulte al Administrador");
            }
            $change_number = true;
        }
        $query = "UPDATE parte SET activo='2',no_parte='$no_parte',esp='$esp',`desc`='$desc',kgpc='$kgpc',snppz='$snppz' WHERE activo>0 AND no_parte='$parte'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if($change_number){
                return jsonOK("<div class='pre'>Parte actualizada con éxito\nNo. anterior: ".$parte."\nNo. actual: ".$no_parte."</div>");
            }else{
                return jsonOK("Parte No. ".$no_parte." actualizada con éxito");
            }
        }
        return jsonERR("Error: No se pudo actualizar la parte. Consulte al Administrador");
    }
?>
