<?php
    function consult_lote($no_lote){
        require_once "connection.php";
        $query = "SELECT no_lote FROM lote WHERE activo='1' AND no_lote LIKE '$no_lote%'";
        $result = mysqli_query($connection,$query);
        $lotes = "";
        while($no_lote = mysqli_fetch_array($result)){
            $lotes .= "<li>".$no_lote['no_lote'];
        }
        mysqli_close($connection);
        return $lotes;
    }
?>
