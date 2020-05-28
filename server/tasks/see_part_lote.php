<?php
    if(isset($_POST['no-parte']) || isset($_POST['buscar-parte']) || isset($_POST['eliminar-parte'])){
        require_once "../queries/data_part.php";
        if(isset($_POST['no-parte'])){
            $result = data_part($_POST['no-parte'],null);
        }else if(isset($_POST['buscar-parte'])){
            $result = update_part($_POST['buscar-parte']);
        }else if(isset($_POST['eliminar-parte'])){
            $result = data_part($_POST['eliminar-parte'],true);
        }
        echo $result;
    }else{
        require_once "../queries/data_lote.php";
        if(isset($_POST['no-lote'])){
            $result = data_lote($_POST['no-lote']);
            echo $result;
        }else if(isset($_POST['buscar-lote'])){
            $result = view_data_lote($_POST['buscar-lote']);
            echo $result;
        }
    }
?>
