<?php
    if(isset($_POST['no-parte']) || isset($_POST['buscar-parte']) || isset($_POST['eliminar-parte'])){
        require "session_modules.php";
        session_modules();
        require "../queries/data_part.php";
        if(isset($_POST['no-parte'])){
            exit(json_encode(data_part($_POST['no-parte'],null)));
        }else if(isset($_POST['buscar-parte'])){
            exit(json_encode(update_part($_POST['buscar-parte'])));
        }else if(isset($_POST['eliminar-parte'])){
            exit(json_encode(data_part($_POST['eliminar-parte'],true)));
        }
    }else if(isset($_POST['no-lote']) || isset($_POST['buscar-lote']) || isset($_POST['eliminar-lote'])){
        require "session_modules.php";
        session_modules();
        require "../queries/data_lot.php";
        if(isset($_POST['no-lote'])){
            exit(json_encode(data_lot($_POST['no-lote'],null)));
        }else if(isset($_POST['buscar-lote'])){
            exit(json_encode(view_data_lote($_POST['buscar-lote'])));
        }else if(isset($_POST['eliminar-lote'])){
            exit(json_encode(data_lot($_POST['eliminar-lote'],true)));
        }
    }else{
        header("location:../../pages/error.html");
    }
?>
