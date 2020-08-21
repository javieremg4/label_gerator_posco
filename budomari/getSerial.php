<?php
    function getSerial(){
        require "../server/queries/connection.php";
        $query = "SELECT serial FROM budomari LIMIT 1";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result = mysqli_fetch_array($result)){
            if(empty($result['serial']) || !is_numeric($result['serial']) || $result['serial']<0){
                exit(jsonERR("No se pudo obtener el serial (".$result['serial'].")"));
            }
            return $result['serial'];
        }
        exit(jsonERR("No se pudo obtener el serial"));
    }

    function setSerial($value){
        if($value<0 || $value>4294967295){
            exit(jsonERR("No se pudo actualizar el serial"));
        }
        require "../server/queries/connection.php";
        $query = "UPDATE budomari SET serial='".$value."' LIMIT 1";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            return "Serial actualizado con éxito";
        } 
        exit(jsonERR("No se pudo actualizar el serial"));
    }
        /*$query = "SELECT serial FROM budomari WHERE ran='".$ran."'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $result = mysqli_fetch_array($result);
                mysqli_close($connection);
                return array(true,$result['serial']);
            }
            $query = "INSERT INTO budomari (ran) VALUES ('$ran')";
            $result = mysqli_query($connection,$query);
            if($result){
                $query = "SELECT serial FROM budomari WHERE ran='".$ran."'";
                $result = mysqli_query($connection,$query);
                if($result){
                    if(mysqli_num_rows($result)>0){
                        $result = mysqli_fetch_array($result);
                        return array(true,$result['serial']);
                    }    
                }
            }
        }
        mysqli_close($connection);
        return array(false,"No se pudo obtener el serial");*/
?>
