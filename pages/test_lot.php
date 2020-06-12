<?php   
    require '../server/tasks/session_validate.php'; 
    session_validate("ignore"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba con números</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">    
    <link rel="stylesheet" href="../styles/suggest_list.css">
    <link rel="stylesheet" href="../styles/label_module.css">
    <link rel="stylesheet" href="../styles/label.css">

</head>
<body class="f14">
    <?php require '../server/tasks/select_menu.php'; ?>
    <h1>Nueva Etiqueta</h1>
    <div class="div-msg" id="validation-msg"></div>
    <div class="div-center">
        <form id="form_label" autocomplete="off">
            <div class="div-union">
                <div class="div-part thirty">
                    No. parte
                    <input type="text" id="no-parte" maxlength="13">
                    <ul id='sug-part'></ul>
                </div>
                <div class="div-center seventy" id="datos-parte"></div>
            </div>
            <div class="div-union">
                <div class="div-part quarter">
                    Cantidad <input type="number" id="cantidad">
                </div>
                <div class="div-part quarter">
                    Fecha <input type="date" id="fecha">
                </div>
                <!--Input de origen
                Origen <input type="text" id="origen" maxlength="50">-->
                <div class="div-part quarter">
                    No. Ran <input type="text" id="no-ran" maxlength="8">
                </div>
            </div>
            <div class="div-union">
                <div class="div-part thirty">
                    Seleccione el No. Lote:
                    <input type="text" id="inspec" maxlength="22">
                    <ul id="sug-lote"></ul>        
                </div>
                <div class="div-center seventy" id="datos-lote"></div>
            </div>
            <div class="div-union">
                <div class="div-part quarter">
                    Lote <input type="text" id="nlot" minlength="13" maxlength="13">
                </div>
                <div class="div-part quarter">
                    Inspección <input type="text" id="ninspec" minlength="13" maxlength="13">
                </div>
            </div>
            <div class="div-center">
                <input id="btn-label" type="submit" value="Generar">
            </div>
        </form>
    </div>
    <div id="server_answer"></div>
    
    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/menu.js"></script>
    <script src="../js/suggest_list.js"></script>
    <script src="../js/validarFecha.js"></script>
    <script src="../js/label.js"></script>
    <script src="../js/JsBarcode.all.min.js"></script>
    <script src="https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <!--<script src="../js/link_menu.js"></script>-->
    <!--<script src="../js/qrcode.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>-->

</body>
</html>
