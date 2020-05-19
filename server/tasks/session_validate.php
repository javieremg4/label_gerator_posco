<?php
    function session_validate($role){
        session_start();
        if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
            if($role!=="ignore" && $role!==$_SESSION['user_role']){
                header("location:../pages/index.php");
            }
        }else{
            header("location:../pages/index.php");
        }
    }
?>
