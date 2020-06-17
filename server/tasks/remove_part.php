<?php
    if(isset($_POST['no-parte'])){
        require "session_modules.php";
        session_modules();
        require "../queries/delete_part.php";
        exit(delete_part($_POST['no-parte']));
    }
    header("location:../../pages/error.html");
?>
