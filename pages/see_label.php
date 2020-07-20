<?php
    require '../server/tasks/session_validate.php'; 
    session_validate("ignore");    
    if(isset($_GET['lbl'])){
        require "../server/queries/consult_labels.php";
        checkSerial($_GET['lbl'],"error.html");
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

    <?php require "../server/tasks/select_menu.php"; ?>
    <div class="div-center">
        <div class="div-msg" id="validation-msg"></div>
    </div>
    <div id="server_answer"></div>
    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--librerias-->
    <script src="https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
    <script>window.html2canvas || document.write(unescape('%3Cscript src="../js/libraries/html2canvas.min.js"%3E%3C/script%3E'))</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script>window.jsPDF || document.write(unescape('%3Cscript src="js/libraries/jspdf.min.js"%3E%3C/script%3E'))</script>
    <script src="../js/libraries/jsBarcode.all.min.js"></script>
    <!--js-->
    <script src="../js/menu.js"></script>
    <script src="../js/label.js"></script>
    <script src="../js/dateReview.js"></script>
    <script src="../js/quitMsg.js"></script>
    <script>
        window.onload = function(){
            $.ajax({
                type: 'get',
                data: 'serial='+'<?php echo $_GET['lbl']; ?>',
                url: '../server/tasks/getLabel.php',
                dataType: 'json',
                success: function(data){
                    if(data.status==="OK" && data.content){
                        $('#server_answer').html(data.content);
                        pdfBtnEvent();
                    }else if(data.status==="ERR" && data.message){
                        $('#server_answer').html(data.message);
                    }else{
                        window.location = "error.html";
                    }
                },
                error: function(){
                    $('#server_answer').html("No se pudo consultar la Etiqueta. Consulte al Administrador");
                }
            });
        }
    </script>
</body>
</html>
