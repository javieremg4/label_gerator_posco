<?php
    function consult_user($user,$pass){
        require_once "connection.php";
        $query = "SELECT user_name,user_role FROM usuarios WHERE user_name='$user' AND user_pass='$pass'";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }
            return array(false,"Usuario o Contraseña inválido");
        }
        return array(false,"No se pudo conectar al Servidor. Consulte al Administrador");
    }
?>
