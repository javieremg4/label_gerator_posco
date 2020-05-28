<?php
    if(isset($_POST['no-parte'])){
        include "session_modules.php";
        require_once "../queries/delete_part.php";
        $result = delete_part($_POST['no-parte']);
        echo $result;
        exit;
    }
?>
