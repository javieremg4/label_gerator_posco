<?php   
    include '../server/tasks/session_validate.php'; 
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
    <nav class="menu-main">
        <a class='w150' href='menu_admin.php'>Volver</a>
        <a class='w150' href="../server/tasks/close_session.php">Cerrar sesión</a>
    </nav>
    <h1>Registrar Usuario</h1>
    <div class="div-msg" id="server_answer"></div>
    <div class="div-center">
        <form id="new_user_form" autocomplete="off">
            <div class="div-union">
                <div class="div-part">
                    Usuario: <input type="text" id="user">
                </div>
                <div class="div-part">
                    Contraseña: <input type="password" id="pass">
                </div>
                <div class="div-part">
                    Tipo: 
                    <div class="div-union">
                        <input type="radio" name="type" value="0">Usuario estándar
                    </div>
                    <div class="div-union">
                        <input type="radio" name="type" value="1"> Administrador
                    </div>
                </div>
                <div class="div-part">
                    Confirmación: <input type="password" id="confirm">
                </div>
            </div>
            <div class="div-center">
                <input type="submit" id="btn-login" value="Registrar">
                <input type="reset" value="Limpiar">
            </div>
        </form>
    </div>

</body>
    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/login.js"></script>
    <script src="../js/new_user.js"></script>
</html>