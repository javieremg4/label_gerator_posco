<?php
    if(!isset($_POST['no-lote'])){
        header("location:../../pages/error.html");
    }
    function consult_lot($no_lote){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "SELECT no_lote FROM lote WHERE activo>0 AND no_lote LIKE '$no_lote%' ORDER BY no_lote LIMIT 20";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        $lotes = "";
        if($result){
            if(mysqli_num_rows($result)>0){
                while($no_lote = mysqli_fetch_array($result)){
                    $lotes .= "<li>".$no_lote['no_lote'];
                }
                return jsonOKContent($lotes);
            }else{
                return jsonOKContent("Sin sugerencias");
            }
        }
        return jsonERR("No se pudieron consultar los lotes. Consulte al Administrador");
    }
?>
