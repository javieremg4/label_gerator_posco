<?php
    require "session_modules.php";
    if(isset($_POST['n']) || isset($_POST['date'])){
        require_once "../queries/consult_labels.php";
        if(!empty($_POST['n']) && is_numeric($_POST['n'])){
            if ($_POST['n']>0){
                $result = consult_labels($_POST['n'],null);
                echo $result;
                exit;
            }
        }else if(!empty($_POST['date'])){
            $result = consult_labels(null,$_POST['date']);
            echo $result;
            exit;
        }
    }
    echo "No se pudieron consultar las etiquetas consulte al Administrador";
?>
