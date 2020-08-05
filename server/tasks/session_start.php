<?php
    if(isset($_POST['user'],$_POST['pass'])){
        require "../queries/consult_user.php";
        $result = consult_user_pass(trim($_POST['user']),$_POST['pass']);
        if($result[0]){
            $result = $result[1];
            session_start();
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_role'] = ($result['user_role']==='0') ? "user" : "admin";
            exit(json_encode(
                array(
                    "status" => "OK",
                    "location" => ($result['user_role']==='0') ? "menu_user.php" : "menu_admin.php",
                )
            ));
        }else{
            exit(json_encode(
                array(
                    "status" => "ERR",
                    "message" => $result[1],
                )
            ));
        }
    }
    header("location:../../pages/error.html");
?>
