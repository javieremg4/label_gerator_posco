<?php
    if(isset($_POST['user']) || isset($_POST['mail'])){
        require "../queries/consult_user.php";
        require "jsonType.php";
        $result = (isset($_POST['user'])) ? consult_user_mail($_POST['user'],null) : consult_user_mail(null,$_POST['mail']);
        if($result[0]){
            $token = $result[2];
            $result = $result[1];

            $body_message =
            "<p>Hola ".$result['user_name'].".</p>

             <p>Usted solicitó un restablecimiento de contraseña para su cuenta en el Generador de Etiquetas POSCO.</p>
             Para confirmar esta petición, y establecer una nueva contraseña para su cuenta, por favor vaya a la siguiente dirección de Internet:"."<br>".
             "<a href='http://192.168.70.5/qrCreator_Posco/pages/reset_pwd.php?token=".$token."'>http://192.168.70.5/qrCreator_Posco/pages/reset_pwd.php?token=".$token."</a>"."<br>
             (Este enlace es válido por 10 minutos desde el momento en que hizo la solicitud por primera vez)
             <p>Si usted no ha solicitado este restablecimiento de contraseña, no necesita realizar ninguna acción.</p>
             Si necesita ayuda, por favor póngase en contacto con un administrador.
            ";
            exit(json_encode(
                array(
                    "status" => "OK",
                    "email" => $result['user_mail'],
                    "message" => $body_message
                )
            ));
        }
        exit(jsonERR($result[1])); 
    }
    header("location:../../pages/error.html");
?>
