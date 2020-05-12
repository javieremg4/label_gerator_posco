<?php
    session_start();
    if(isset($_SESSION['user_name'])){
        echo "Bienvenido ".$_SESSION['user_name'];
    }else{
        echo "Bienvenido desconocido :v";
    }
?>
