<?php
    //El if reconoce si la petición se hace mediante AJAX
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        require "session_modules.php";
        session_modules();
        require "../queries/equal_data.php";
        exit(equal_data());
    }
    header("location:../../pages/error.html");
?>
