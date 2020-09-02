<?php
    if(isset($_GET['token']) && !empty($_GET['token'])){ 
        require "../server/queries/consult_user.php";
        checkToken($_GET['token']); 
    }else{
        exit(header("location:error.html"));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
    <!--css-->
    <link rel="stylesheet" href="../styles/basics.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body class="f14">

    <div class="div-center">
        <div class="div-msg" id="server_answer"></div>
    </div>
    <div class="div-center">
        <form id="reset_pwd_form">
            Nueva Contraseña: <input type="password" id="new-pwd">
            Confirmación: <input type="password" id="confirm-pwd">
            <input type="submit" value="Cambiar" id="btn-reset-pwd">
        </form>
    </div>

    <!--jQuery-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>window.jQuery || document.write(unescape('%3Cscript src="../js/libraries/jquery-3.4.1.min.js"%3E%3C/script%3E'))</script>
    <!--js-->
    <script src="../js/reset_pwd.js"></script>
    <script src="../js/quitMsg.js"></script>
    <script>
        $('#reset_pwd_form').on('submit',function(e){
            e.preventDefault();
            cleanMsg('server_answer');
            let new_pwd = pwd_review();
            if(!new_pwd){ return false; }
            $.ajax({
                type: 'post',
                url: '../server/tasks/set_pwd.php',
                data: new_pwd+'&token='+'<?php echo $_GET['token']; ?>',
                dataType: 'json',
                beforeSend: function(){ $('#btn-reset-pwd').attr('disabled',true); },
                success: function(data){
                    if(data.status==="OK" && data.message){
                        quitMsgEvent('server_answer',data.message,'div-green');
                        $('#reset_pwd_form').html("<a href='index.php'>Iniciar Sesión</a>");
                    }else if(data.status==="ERR" && data.message){
                        quitMsgEvent('server_answer',data.message,'div-red');
                        $('#btn-reset-pwd').attr('disabled',false); 
                    }else{
                        window.location = "error.html";
                    }
                },
                error: function(){
                    location.reload();
                },
            });
        });
    </script>
</body>
</html>
