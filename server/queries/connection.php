<?php
    $connection = mysqli_connect("localhost","root","root1234","posco");
    /* verify the connection */
    if (mysqli_connect_errno()){
        printf("Falló la conexión: %s\n", mysqli_connect_error());
        exit();
    }
    $connection->set_charset("utf8");
?>
