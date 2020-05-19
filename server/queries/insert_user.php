<?php
    function insert_user($name,$pass,$type){
        require_once "connection.php";
        $query = "SELECT user_id FROM usuarios WHERE user_name='$name'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection); 
                return "Ese Nombre de Usuario no esta Disponible";
            }
            $query = "INSERT INTO usuarios (user_name,user_pass,user_role) VALUES ('$name','$pass','$type')";
            $result = mysqli_query($connection,$query);
            if($result){
                mysqli_close($connection); 
                return "Usuario registrado con éxito";
            }
        }
        mysqli_close($connection); 
        return "No se Pudo Registrar el Usuario";
    }
?>
