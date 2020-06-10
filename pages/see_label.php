<?php
    require '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
    if(isset($_GET['lbl'])){
        $serial = base64_decode($_GET['lbl']);
        if(!is_numeric($serial) || $serial<0){
            header("location: error.html");
            exit;
        }else{
            require "../server/queries/consult_labels.php";
            checkSerial($serial);
        }
    }else{
        header("location: error.html");
        exit;
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Etiqueta</title>

    <!--css-->
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/see_label.css">
    <link rel="stylesheet" href="../styles/label.css">
</head>
<body>
    <?php 
        require "../server/tasks/select_menu.php";
        consult_label($serial);
    ?>
    <!--<div id="contenedorCanvas" style="border: 1px solid red;"></div>-->
    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/JsBarcode.all.min.js"></script>
    <script src="../js/see_label.js"></script>
    <script src="../js/menu.js"></script>
    <script src="https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
</body>
</html>
