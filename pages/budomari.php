<?php
    require '../server/tasks/session_validate.php'; 
    session_validate("ignore"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiquetas Budomari</title>

    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/load_lots.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Generar Etiquetas Budomari</h1>
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form enctype="multipart/form-data" id="load-file">
            <input type="file" id="file-862" name="file-862">
            <span class="i f12">Nota: Sólo se permite .txt</span>
            <div id="wait-msg" class="div-center mt10">
                <input type="submit" id="btn-submit" value="Generar">
                <button class="btn-cancel" id="clean-all">Limpiar</button>
            </div>
        </form>
    </div>
    <iframe frameborder="0" id="pdfFrame"></iframe>

    <!--librerias-->
    <script src="../js/libraries/jquery-3.4.1.min.js"></script>
    <script src="../js/libraries/jspdf.min.js"></script>
    <!--js-->
    <script src="../js/budomari.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
