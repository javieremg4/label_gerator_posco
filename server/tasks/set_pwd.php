<?php
    if(isset($_POST['new-pwd'],$_POST['token'])){
        require "../queries/consult_user.php";
        checkToken($_POST['token']);
        require "../queries/update_pwd.php";
        $result = update_pwd($_POST['new-pwd'],$_POST['token']);
        return $result;
    }
    header("location:../../pages/error.html");
?>
