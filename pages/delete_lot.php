<?php
    include '../server/tasks/session_validate.php'; 
    session_validate("admin"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Lote</title>

    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/suggest_list.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/lot.css">
</head>
<body class="f14">
    <?php include '../server/tasks/select_menu.php'; ?>
    <h1>Eliminar un Lote</h1>
    <div class="div-msg" id="server_answer"></div>
    <div class="div-center">
        <form id="form_delete_lot" autocomplete="off">
            <div class="div-left">
                <span>Ingrese el No. lote para buscar</span>
                <input type="text" id="eliminar-lote" maxlength="13">
                <ul id="sug-lote"></ul>
            </div>
            <div class="div-union" id="datos-lote"></div>
        </form>
    </div>

    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/suggest_list.js"></script>
    <script src="../js/delete_lot.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>
