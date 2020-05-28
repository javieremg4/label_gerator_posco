<?php 
    //Ocultar todas la errores (advertencias,notas,etc)
    //error_reporting(0);
    //***
    $connection = mysqli_connect("localhost","root","root1234","posco");
    //mysqli_close($connection);
    /* verificar la conexión */
    if (mysqli_connect_errno()){
        echo "Falló la conexión: ¡Consulte al Administrador!";
        //echo printf('Falló la conexión: %s ¡Consulte al Administrador! ',mysqli_connect_error());
        exit;
        //die(sprintf("back-error[%d] %s\n", mysqli_connect_errno(), mysqli_connect_error()));
    }
    $connection->set_charset("utf8");
?>
