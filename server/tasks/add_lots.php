<?php
    if(isset($_POST['lots_array'])){
        require "session_modules.php";
        $lots_array = json_decode($_POST['lots_array'],true);
        require_once '../queries/insert_lot.php';
        $data = "<div class='ovx'><table class='table-style'><tr><th>Reg.<th>Resultado";
        $correct = 0;
        $fail = 0;
        $i = 1;
        foreach ($lots_array as $lot){
            $data .= "<tr><td>".$i;
            $result = insertProperties($lot[0],$lot[1],$lot[2],$lot[3],$lot[4],$lot[5],$lot[6]);
            if(strpos($result,"Error")===false){
                $data .= "<td>".$result;
                $correct += 1;
            }else{
                $data .= "<td class='text-red'>".$result;
                $fail += 1;
            }
            $i+=1;
        }
        $data .= "</div>";
        $alert = "<div class='result-report'>No. de Registros: ".($i-1)."\nLotes registrados: ".$correct."\nErrores: ".$fail."</div>";
        echo $alert;
        echo $data;
    }
?>
