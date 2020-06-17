<?php
    function session_validate($role){
        session_start();
        if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
            if($role!=="ignore" && $role!==$_SESSION['user_role']){
                header("location:index.php");
                exit;
            }
        }else{
            header("location:index.php");
            exit;
        }
    }
?>
