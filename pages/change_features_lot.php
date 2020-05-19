<?php   
    include '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización Lotes</title>

    <!--Styles-->
    <link rel="stylesheet" href="../styles/label.css">
</head>
<body>
    
    <h1>Actualizar Lote</h1>
    <form id="form_lot" autocomplete="off">
        <div id="div-lote" style="background: yellow; width: 200px;">
            Buscar lote:
            <input type="text" id="buscar-lote">
            <ul id="sug-lote"></ul>
        </div>
        <div id="datos-lote"></div>
    </form>
    <div id="res-lote"></div>
</body>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/suggest_list.js"></script>
    <script src="../js/lot.js"></script>
    <script src="../js/features_lot.js"></script>
</html>