<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("admin");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/new_user.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Registrar Usuario</h1>
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form id="new_user_form" autocomplete="off">
            <div class="div-union">
                <div class="div-part">
                    Usuario: <input type="text" id="user" minlength='3' maxlength='50'>
                </div>
                <div class="div-part">
                    Contraseña: <input type="password" id="pass">
                </div>
                <div class="div-part">
                    Correo electrónico: <input type="email" id="email" maxlength='50'>
                </div>
                <div class="div-part">
                    Confirmación: <input type="password" id="confirm">
                </div>
                <div class="div-part">
                    Tipo: 
                    <div class="div-union mt5">
                        <input type="radio" name="type" id="tuser" value="0">Usuario estándar
                    </div>
                    <div class="div-union">
                        <input type="radio" name="type" value="1"> Administrador
                    </div>
                </div>
            </div>
            <div class="div-center">
                <input type="submit" id="btn-login" value="Registrar">
                <button class="btn-cancel" id="clean_all">Limpiar</button>            
            </div>
        </form>
    </div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/login.js"></script>
    <script src="../js/new_user.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
