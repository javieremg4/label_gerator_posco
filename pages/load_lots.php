<?php
    require '../server/tasks/session_validate.php'; 
    session_validate("admin"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Nros. Inpección</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/load_lots.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Cargar Nros. Inspección</h1>
    <div class="div-center">
        <div class="div-msg" id="validation-msg"></div>
    </div>
    <div class="div-center">
        <form enctype="multipart/form-data" id="form_load_lots">
            <!-- File input field -->
            <input type="file" name="file" id="file">
            <span class="i f12">Nota: Sólo se permite .csv</span>
            <div class="div-center mt10">
                <input type="submit"id="btn-submit" value="Ver registros">
                <button class="btn-cancel" id="clean_all">Limpiar</button>
            </div>
        </form>
    </div>
    <div class="div-union" id="server_answer"></div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/load_lots.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/quitMsg.js"></script>
    <script src="../js/load_lots.js"></script>
</body>
</html>
