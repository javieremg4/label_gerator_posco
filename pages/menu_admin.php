<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("admin");    
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
    <ul id="menu" class="nav">
        <li><a href="menu_admin.php">Inicio</a></li>
        <li><a>Etiquetas<span class="flecha">&#9660</span></a>
            <ul>
                <li><a href="label.php">NISSAN</a></li>
                <li><a href="budomari.php">Budomari</a></li>
            </ul>
        </li>
        <li><a>Partes<span class="flecha">&#9660</span></a>
            <ul>
                <li><a href="part.php">Nueva Parte</a></li>
                <li><a href="change_features_part.php">Actualizar Parte</a></li>
                <li><a href="delete_part.php">Eliminar Parte</a></li>
            </ul>
        </li>
        <li><a>Inspección<span class="flecha">&#9660</span></a>
            <ul>
                <li><a href="load_lots.php">Cargar Nros. Insp</a></li>
                <li><a href="lot.php">Nuevo No. Insp</a></li>
                <li><a href="change_features_lot.php">Actualizar No. Insp</a></li>
                <li><a href="delete_lot.php">Eliminar No. Insp</a></li>
            </ul>
        </li>
        <li><a href="equal_data.php">Datos Fijos</a></li>
        <li><a href="new_user.php">Nuevo Usuario</a></li>
        <li><a href="../server/tasks/close_session.php">Cerrar Sesion</a></li>
    </ul>

    <div class="div-msg f32" id="user_name">
        <?php echo "Bienvenido ".$_SESSION['user_name']; ?>
    </div>

    <div class="div-center">
        <div class="div-msg" id="val-msg"></div>
    </div>
    <div class="div-center">
        <form id="form_show_labels">
            <div class="div-left">
                <span>Ingrese la fecha para buscar:</span>
                <input type="date" id="date-consult">
            </div>
            <div class="div-center">
                <input id="btn-show" type="submit" value="Consultar">
            </div>
        </form>
    </div>
    <div class="div-center f14" id="label-panel"></div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/menu.js"></script>
    <script src="../js/show_labels.js"></script>
    <script src="../js/dateReview.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
