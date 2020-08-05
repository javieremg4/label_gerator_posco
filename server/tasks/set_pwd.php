<?php
    if(isset($_POST['new-pwd'],$_POST['user'])){
        require "../queries/consult_user.php";
        checkId($_POST['user'],"../../pages/error.html");
        require "../queries/update_email.php";
        $result = update_email($_POST['new-pwd'],$_POST['user']);
        return $result;
    }
    header("location:../../pages/error.html");
?>
