<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("admin");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Partes</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/suggest_list.css">
    <link rel="stylesheet" href="../styles/part.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Actualizar una Parte</h1>
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form id="form_features_part" autocomplete="off">
            <div class="div-left">
                <span>Ingrese el No. parte para buscar</span>
                <input type="text" id="buscar-parte" maxlength="13">
                <ul id="sug-part"></ul>
            </div>
            <div class="div-union" id="datos-parte"></div>
        </form>
    </div>
    
    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/menu.js"></script>
    <script src="../js/suggest_list.js"></script>
    <script src="../js/part.js"></script>
    <script src="../js/features_part.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
