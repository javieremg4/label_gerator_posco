<?php
    if(isset($_POST['lots_array'])){
        include "../tasks/jsonType.php";
        if(empty($_POST['lots_array'])){ exit(jsonERR("Hubo un problema. Inténtelo de nuevo")); }
        require "session_modules.php";
        session_modules();
        $lots_array = json_decode($_POST['lots_array'],true);
        if(empty($lots_array)){ exit(jsonERR("Hubo un problema. Inténtelo de nuevo")); }
        require '../queries/insert_lot.php';
        $data = "<div class='ovx'><table class='table-style'><tr><th>Reg.<th>Resultado";
        $correct = 0;
        $fail = 0;
        $i = 1;
        foreach ($lots_array as $lot){
            $data .= "<tr><td>".$i;
            $result = json_decode(insert_lot($lot[0],$lot[1],$lot[2],$lot[3],$lot[4],$lot[5],$lot[6]),true);
            if($result['status']==="OK"){
                $data .= "<td>".$result['message'];
                $correct += 1;
            }else{
                $data .= "<td class='text-red'>".$result['message'];
                $fail += 1;
            }
            $i+=1;
        }
        $data .= "</div>";
        $alert = "<div class='result-report'>No. de Registros: ".($i-1)."\nNros. Insp. registrados: ".$correct."\nErrores: ".$fail."</div>";
        exit(jsonOKContent($alert.$data));
    }
    header("location:../../pages/error.html");
?>
