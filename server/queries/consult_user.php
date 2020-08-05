<?php
    if(!isset($_GET['user']) && !isset($_POST['user']) && !isset($_POST['pass']) && !isset($_POST['mail']) && !isset($_POST['new-pwd'],$_POST['user'])){
        header("location:../../pages/error.html");
    }
    function consult_user_pass($user,$pass){
        require "connection.php";
        $pass = sha1($pass);
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
    function consult_user_mail($user,$mail){
        require "connection.php";
        $query = "SELECT user_id,user_name,user_mail FROM usuarios WHERE BINARY ";
        $query .= (!empty($user)) ? "user_name='$user'" : "user_mail='$mail'";
        $info = mysqli_query($connection,$query);
        if($info){
            if(mysqli_num_rows($info)===1){ 
                $query = "UPDATE usuarios SET user_token='1' WHERE BINARY ";
                $query .= (!empty($user)) ? "user_name='$user'" : "user_mail='$mail'";
                $result = mysqli_query($connection,$query);
                mysqli_close($connection);
                if($result){
                    return array(true,mysqli_fetch_array($info));
                }
                return array(false,"No se pudo consultar la información");
            }
            return (!empty($user)) ? array(false,"No se encontró el usuario") : array(false,"No se encontró el correo");
        }
        mysqli_close($connection);
        return array(false,"No se pudo consultar la información");
    }
    function checkId($id,$location){
        $id = base64_decode($id);
        if(!is_numeric($id) || $id<0){
            exit(header("location:".$location));
        }else{
            require "alternate_connection.php";
            $query = "SELECT max(user_id) AS maxid FROM usuarios";
            $result = mysqli_query($connection,$query);
            if($result=mysqli_fetch_array($result)){
                if($id>$result['maxid']){
                    exit(header("location:".$location));
                }
                $query = "SELECT user_token FROM usuarios WHERE user_id=$id";
                $result = mysqli_query($connection,$query);
                mysqli_close($connection);
                if($result = mysqli_fetch_array($result)){
                    if($result['user_token']==0){
                        exit(header("location:".$location));
                    }
                }else{
                    exit("No se puede cambiar la contraseña. Inténtelo más tarde");
                }
            }else{
                mysqli_close($connection);
                exit("No se puede cambiar la contraseña. Inténtelo más tarde");
            }
        }
    }
?>
