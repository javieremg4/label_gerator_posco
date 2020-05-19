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
</head>
<body>
    <nav class="menu-main">
        <a href="label.php">Nueva Etiqueta</a>
        <a href="part.php">Nueva Parte</a>
        <a href="lot.php">Nuevo Lote</a>
        <a href="change_features_part.php">Actualizar una Parte</a>
        <a href="change_features_lot.php">Actualizar un Lote</a>
        <a href="../server/tasks/close_session.php">Cerrar sesión</a>
    </nav>
    <div class="div-msg f32" id='user_name'></div>

</body>
    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/user_name.js"></script>
</html>
