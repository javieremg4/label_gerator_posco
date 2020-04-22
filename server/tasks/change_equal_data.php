<?php
    if(isset($_POST['fecha-rollo'],$_POST['fecha-lote'],$_POST['bloque'],$_POST['hora'])){
        require_once "../queries/update_equal_data.php";
        $result = update_equal_data(trim($_POST['fecha-rollo']),trim($_POST['fecha-lote']),trim($_POST['bloque']),trim($_POST['hora']));
        echo $result;
    }else{
        echo "No se recibieron todos los datos";
    }
?>
