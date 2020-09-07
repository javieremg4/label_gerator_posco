<?php
    if(!isset($_FILES['file-862']['tmp_name'])){
        header("location:../../pages/error.html");
    }
    
    function getSerial(){
        require "connection.php";
        $query = "SELECT serial FROM budomari LIMIT 1";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        $serial = "";
        if($result = mysqli_fetch_array($result)){
            if((empty($result['serial']) && $serial!=0) || !is_numeric($result['serial']) || $result['serial']<0){
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
        require "connection.php";
        $query = "UPDATE budomari SET serial='".$value."' LIMIT 1";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            return "Serial actualizado con éxito";
        } 
        exit(jsonERR("No se pudo actualizar el serial"));
    }
?>
