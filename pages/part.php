<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Parte</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/part.css">
</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Nueva Parte</h1>
    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
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
                    Kg./Pc
                    <input type="text" id="kgpc" maxlength="8">
                </div>
                <div class="div-part">
                    SNP PZ
                    <input type="number" id="snppz">
                </div>
                <div class="div-part">
                    Especificación
                    <input type="text" id="esp" maxlength="15">
                </div>
            </div>
            <div class="div-center">
                <input type="submit" id="btn-part" value="Registrar">
                <button class="btn-cancel" id="clean_all">Limpiar</button>            
            </div>
        </form>
    </div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/part.js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/quitMsg.js"></script>
</body>
</html>
