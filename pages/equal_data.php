<?php   
    include '../server/tasks/session_validate.php'; 
    session_validate("admin");    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos fijos</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/menu.css">
    <link rel="stylesheet" href="../styles/equal.css">
</head>
<body class="f14">
    <?php include '../server/tasks/select_menu.php'; ?>
    <h1>Actualizar Datos Fijos</h1>
    <div class="div-msg" id="server_answer"></div> 
    <div class="div-center">
        <form id="form_data">
        </form>
    </div>

    <!--js-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/jquery-3.4.1.js"%3E%3C/script%3E'))</script>
    <script src="../js/equal_data.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>
