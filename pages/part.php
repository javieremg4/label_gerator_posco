<?php   
    include '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altas partes</title>

    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/part.css">
</head>
<body class="f14">
    <nav class="menu-main">
        <?php
            echo ($_SESSION['user_role']==="admin") ? "<a class='w150' href='menu_admin.php'>Volver</a>" : "<a class='w150' href='menu_user.php'>Volver</a>";
        ?>
        <a class='w150' href="../server/tasks/close_session.php">Cerrar sesión</a>
    </nav>
    <h1>Altas Partes</h1>
    <div class="div-msg" id="server_answer"></div>
    <div class="div-center">
        <form id="form_part">
            <div class="div-union">
                <div class="div-part">
                    No. Parte
                    <input type="text" id="no-parte" maxlength="13">
                </div>
                <div class="div-part">
                    Descripción
                    <input type="text" id="desc" maxlength="50">
                </div>
                <div class="div-part">
                    Especificación
                    <input type="text" id="esp" maxlength="15">
                </div>
                <div class="div-part">
                    Kg./Pc
                    <input type="text" id="kgpc">
                </div>
            </div>
            <div class="div-center">
                <input type="submit" id="btn-part" value="Registrar">
                <input type="reset" value="Limpiar">
            </div>
        </form>
    </div>

    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/part.js"></script>

</body>
</html>
