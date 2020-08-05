<?php
    //Ocultar todas la errores (advertencias,notas,etc)
    error_reporting(0);
    //***
    $connection = mysqli_connect("localhost","root","root1234","poscoetiq");
    /* verificar la conexión */
    if (mysqli_connect_errno()){
        exit("Falló la conexión: ¡Consulte al Administrador!");
    }
    $connection->set_charset("utf8");
?>
