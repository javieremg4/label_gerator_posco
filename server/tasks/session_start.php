<?php
    if(isset($_POST['user'],$_POST['pass'])){
        require_once "../queries/consult_user.php";
        $result = consult_user(trim($_POST['user']),$_POST['pass']);
        if($result[0]){
            $result = $result[1];
            session_start();
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_role'] = ($result['user_role']==='0') ? "user" : "admin";
            echo $_SESSION['user_role'];
        }else{
            echo $result[1];
        }
    }
?>
