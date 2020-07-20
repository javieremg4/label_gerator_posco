<?php
/*Se elimina la sesión si existía una*/
    session_start();
    if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
        session_unset();
        session_destroy();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body class="f14">
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form class="login_form" id="login_form" autocomplete="off">
            Usuario <input type="text" id="user" minlength="3" maxlength="15">
            Contraseña <input type="password" id="pass" minlength="6" maxlength="15">
            <div class="div-center">
                <input id="btn-login" type="submit" value="Ingresar">
            </div>
        </form>
    </div>
    
    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/login.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
