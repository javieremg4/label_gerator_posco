<?php
    session_start();
    if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
        if($_SESSION['user_role']==="admin"){
            echo "menu_admin.php";
        }else{
            echo "menu_user.php";
        }
    }else{
        echo "back-error";
    }
?>
