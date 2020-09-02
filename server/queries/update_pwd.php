<?php
    if(!isset($_POST['new-pwd'],$_POST['token'])){
        header("location:../../pages/error.html");
    }
    function update_pwd($new_pwd,$token){
        require "connection.php";
        require "jsonType.php";
        $new_pwd = sha1($new_pwd);
        $query = "SELECT 1 FROM usuarios WHERE user_token='$token'";
        $result = mysqli_query($connection,$query);
        if(mysqli_num_rows($result)==1){
            $query = "UPDATE usuarios SET user_pass='$new_pwd',user_token='' WHERE user_token='$token'";
            $result = mysqli_query($connection,$query);
            if($result){
                mysqli_close($connection);
                exit(jsonOK("Contraseña actualizada con éxito"));
            }
        }
        mysqli_close($connection);
        exit(jsonERR("No se pudo actualizar la contraseña. Inténtelo de nuevo."));
    }
?>
