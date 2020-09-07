<?php
    if(!isset($_GET['user']) && !isset($_POST['user']) && !isset($_POST['pass']) && !isset($_POST['mail']) && !isset($_GET['token']) && !isset($_POST['new-pwd'],$_POST['token'])){
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
        $query = "SELECT user_name,user_mail,user_token FROM usuarios WHERE BINARY ";
        $query .= (!empty($user)) ? "user_name='$user'" : "user_mail='$mail'";
        $info = mysqli_query($connection,$query);
        if($info){
            if(mysqli_num_rows($info)===1){
                $info = mysqli_fetch_array($info);
                if(empty($info['user_token'])){
                    $token = createToken();
                    $query = "UPDATE usuarios SET user_token='$token',user_date=NOW() WHERE BINARY ";
                    $query .= (!empty($user)) ? "user_name='$user'" : "user_mail='$mail'";
                    $result = mysqli_query($connection,$query);
                    mysqli_close($connection);
                    if($result){
                        return array(true,$info,$token);
                    }
                    return array(false,"No se pudo consultar la información");
                }else{
                    $minDiff = minDiff($connection,$info['user_token']);
                    if($minDiff !== false){
                        if((empty($minDiff) && $minDiff!=0) ||  !is_numeric($minDiff)){
                            return array(false,"No se puede cambiar la contraseña. Consulte al Administrador");
                        }
                        if($minDiff>10){
                            $token = createToken();
                            $query = "UPDATE usuarios SET user_token='$token',user_date=NOW() WHERE BINARY ";
                            $query .= (!empty($user)) ? "user_name='$user'" : "user_mail='$mail'";
                            $result = mysqli_query($connection,$query);
                            mysqli_close($connection);
                            if($result){
                                return array(true,$info,$token);
                            }
                            return array(false,"No se pudo consultar la información");
                        }else{
                            return array(true,$info,$info['user_token']);
                        }
                    }
                    return array(false,"No se pudo consultar la información");
                }
            }
            return (!empty($user)) ? array(false,"No se encontró el usuario") : array(false,"No se encontró el correo");
        }
        mysqli_close($connection);
        return array(false,"No se pudo consultar la información");
    }
    function minDiff($connection,$token){
        $query = "SELECT TIMESTAMPDIFF(minute,(SELECT user_date FROM usuarios WHERE BINARY user_token='$token'),NOW()) AS minDiff";
        $result = mysqli_query($connection,$query);
        return ($result = mysqli_fetch_array($result)) ? $result['minDiff'] : false;
    }
    function createToken(){
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(8);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        return $token;
    }
    function checkToken($token){
        require "alternate_connection.php";
        $minDiff = minDiff($connection,$token);
        mysqli_close($connection);
        if($minDiff === false){
            exit(errMessage("No se puede cambiar la contraseña. Inténtelo de Nuevo"));
        }
        if((empty($minDiff) && $minDiff!=0) ||  !is_numeric($minDiff)){
            exit(errMessage("No se puede cambiar la contraseña. Inténtelo de Nuevo"));
        }
        if($minDiff>10){ 
            exit(errMessage("Enlace inválido por limite de tiempo")); 
        }
    }
    function errMessage($message){
        return "<div
                style='
                    border: 1px solid #d1d1d1;
                    font-family: sans-serif; 
                    font-weight: bold; 
                    height: 160px;
                    left: 50%;
                    margin-left: -300px;
                    margin-top: -80px;
                    position: absolute;
                    text-align: center;
                    top: 50%;
                    width: 600px;
                    '
                >
                <h1>".$message."</h1>
                <h4><a href='index.php'>Ir a inicio</a></h4>
                </div>";
    }
?>
