<?php
    function consult_part($no_parte){
        require_once "connection.php";
        $query = "SELECT no_parte FROM parte WHERE activo='1' AND no_parte LIKE '$no_parte%'";
        $result = mysqli_query($connection,$query);
        $parts = "";
        while($no_parte = mysqli_fetch_array($result)){
            $parts .= "<li>".$no_parte['no_parte'];
        }
        mysqli_close($connection);
        return $parts;
    }
?>
