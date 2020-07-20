<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("admin");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Inspección</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/suggest_list.css">
    <link rel="stylesheet" href="../styles/lot.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Actualizar No. Inspección</h1>
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form id="form_lot" autocomplete="off">
            <div class="div-left">
                <span>Ingrese un No. Inspección para buscar</span>
                <input type="text" id="buscar-lote">
                <ul id="sug-lote"></ul>
            </div>
            <div class="div-union" id="datos-lote"></div>
        </form>
    </div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/suggest_list.js"></script>
    <script src="../js/lot.js"></script>
    <script src="../js/features_lot.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
