<?php   
    include '../server/tasks/session_validate.php'; 
    session_validate("user");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/show_label.css">
</head>
<body>
    <button id="btn-menu" class="btn-menu">Menú</button>
    <ul class="nav" id="menu">
        <li><a href="menu_user.php">Inicio</a></li>
        <li><a href="label.php">Nueva Etiqueta</a></li>
        <li><a href="part.php">Nueva Parte</a></li>
        <li><a href="lot.php">Nuevo Lote</a></li>
        <li><a href="../server/tasks/close_session.php">Cerrar sesión</a></li>
    </ul>

    <div class="div-msg f32" id='user_name'>
        <?php echo "Bienvenido ".$_SESSION['user_name']; ?>
    </div>

    <div class="div-msg" id="val-msg"></div>
    <div class="div-center">
        <form id="form_show_labels">
            <div class="div-left">
                <span>Ingrese la fecha para buscar:</span>
                <input type="date" id="date-consult">
            </div>
            <div class="div-center">
                <input type="submit" value="Consultar">
            </div>
        </form>
    </div>
    <div class="div-center f14" id="label-panel"></div>
    
    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/validarFecha.js"></script>
    <script src="../js/show_labels.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>
