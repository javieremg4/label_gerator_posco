<?php
    if(!isset($_POST['new-pwd'],$_POST['user'])){
        header("location:../../pages/error.html");
    }
    function update_email($new_pwd,$user){
        require "connection.php";
        require "jsonType.php";
        $new_pwd = sha1($new_pwd);
        $user = base64_decode($user);
        $query = "UPDATE usuarios SET user_pass='".$new_pwd."',user_token='0' WHERE user_id='".$user."'";
        $result = mysqli_query($connection,$query);
        if($result){
            exit(jsonOK("Contraseña actualizada con éxito"));
        }
        exit(jsonERR("No se pudo actualizar la contraseña. Inténtelo de nuevo."));
    }
?>
