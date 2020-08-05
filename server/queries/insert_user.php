<?php
    if(!isset($_POST['user'],$_POST['pass'],$_POST['email'],$_POST['type'])){
        header("location:../../pages/error.html");
    }
    function insert_user($name,$pass,$email,$type){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "SELECT user_id FROM usuarios WHERE user_name='$name'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                mysqli_close($connection); 
                return jsonERR("Ese Nombre de Usuario no esta Disponible");
            }
            $query = "SELECT user_id FROM usuarios WHERE user_mail='$email'";
            $result = mysqli_query($connection,$query);
            if($result){
                if(mysqli_num_rows($result)>0){
                    mysqli_close($connection); 
                    return jsonERR("Ese Correo ya esta Registrado");
                }
                $pass = sha1($pass);
                $query = "INSERT INTO usuarios (user_name,user_pass,user_mail,user_role) VALUES ('$name','$pass','$email','$type')";
                $result = mysqli_query($connection,$query);
                if($result){
                    mysqli_close($connection); 
                    return jsonOK(($type==1) ? "Administrador (".$name.") registrado con éxito" : "Usuario (".$name.") registrado con éxito");
                }
            }
        }
        mysqli_close($connection); 
        return jsonERR("No se Pudo Registrar el Usuario");
    }
?>
