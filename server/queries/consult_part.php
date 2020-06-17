<?php
    if(!isset($_POST['no-parte'])){
        header("location:../../pages/error.html");
    }
    function consult_part($no_parte){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "SELECT no_parte FROM parte WHERE activo>0 AND no_parte LIKE '$no_parte%' ORDER BY no_parte LIMIT 20";
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        $parts = "";
        if($result){
            if(mysqli_num_rows($result)>0){
                while($no_parte = mysqli_fetch_array($result)){
                    $parts .= "<li>".$no_parte['no_parte'];
                }
                return jsonOKContent($parts);
            }else{
                return jsonOKContent("Sin sugerencias");
            }
        }
        return jsonERR("No se pudieron consultar las partes. Consule al Administrador");
    }
?>
