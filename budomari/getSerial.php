<?php
    function getSerial($ran){
        require "../server/queries/connection.php";
        $query = "SELECT serial FROM budomari WHERE ran='".$ran."'";
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $result = mysqli_fetch_array($result);
                return array(true,$result['serial']);
            }
            $query = "INSERT INTO budomari (ran) VALUES ('$ran')";
            $result = mysqli_query($connection,$query);
            if($result){
                $query = "SELECT serial FROM budomari WHERE ran='".$ran."'";
                $result = mysqli_query($connection,$query);
                if($result){
                    if(mysqli_num_rows($result)>0){
                        $result = mysqli_fetch_array($result);
                        return array(true,$result['serial']);
                    }    
                }
            }
        }
        return array(false,"No se pudo obtener el serial");
    }
?>
