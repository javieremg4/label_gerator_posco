<?php   
    include '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Altas Lotes</title>

    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/lot.css">
</head>
<body class="f14">
    <?php include '../server/tasks/select_menu.php'; ?>
    <h1>Nuevo Lote</h1>
    <div class="div-msg" id="server_answer"></div>
    <div class="div-center">
        <form id="form_properties">
            <div class="div-union">
                <div class="div-part">
                    Lot No.<input type="text" id="lot" maxlength='15'>
                </div>
                <div class="div-part">
                    Wgt.<input type="text" id="wgt" maxlength='7'>
                </div>
                <div class="div-part yp">
                    Yield Point (YP)<input type="text" id="yp" maxlength='6'>
                </div>
                <div class="div-part ts">
                    Tensile Strength (TS)<input type="text" id="ts" maxlength='6'>
                </div>
                <div class="div-part">
                    Elongation (EL)<input type="text" id="el" maxlength='6'>
                </div>
                <div class="div-part">
                    Top Coating<input type="text" id="tc" maxlength='6'>
                </div>
                <div class="div-part">
                    Bot Coating<input type="text" id="bc" maxlength='6'>       
                </div>
            </div>
            <div class="div-center">
                <input type="submit" id="btn-lot" value="Registrar">
                <input type="reset" value="Limpiar">
            </div>
        </form>
    </div>

    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/lot.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>
