<?php
    if(!isset($_POST['user'],$_POST['pass'])){
        header("location:../../pages/error.html");
    }
    function consult_user($user,$pass){
        require "connection.php";
        $query = "SELECT user_name,user_role FROM usuarios WHERE BINARY user_name='$user' AND BINARY user_pass='$pass'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }
            return array(false,"Usuario o Contraseña incorrecto");
        }
        return array(false,"No se pudieron validar las credenciales. Consulte al Administrador");
    }
?>
