<?php
    //Ocultar todas la errores (advertencias,notas,etc)
    error_reporting(0);
    //***
    if(isset($_FILES['file-862']['tmp_name']) && !empty($_FILES['file-862']['tmp_name'])){

        require "session_modules.php";
        session_modules();

        require "jsonType.php";

        $path = $_FILES['file-862']['name']; 
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if($ext!='txt' && $ext!='TXT'){
            exit(jsonERR("Archivo: extensión incorrecta"));
        }

        $content = file_get_contents($_FILES["file-862"]['tmp_name']);

        if($content===false){ 
            exit(jsonERR("No se pudo consultar el archivo. Consulte al Administrador")); 
        }else{
            $content = explode("\r\n",$content);
            if(empty($content)){ exit(jsonERR("No se pudo consultar el archivo. Consulte al Administrador")); }
        }


        $curLoc[0] = "";
        $curLoc[1] = "";
        $curLoc[2] = "";
        $curLoc[3] = "";

        $supplier = "";
        $curPart = "";
        $curDesc = "";
        $curRAN = "";
        $curDate = "";
        $lbls[] = "";
        $nLabel = 0;

        //Búsqueda y revisión del proveedor
        foreach ($content as $index => $line) {
            if(strpos($line,"LIN*")===0){ break; }
            if(strpos($line,"N1*SU*")===0){
                $line = explode("*",$line);
                //echo "Array proveedor: =>".count($line)."<br>";
                if(empty($line) || count($line)<5){
                    exit(jsonERR("No se encontró el código de proveedor"));
                }
                $supplier = $line[4];
            }
        }
        if(empty($supplier)){ exit(jsonERR("No se encontró el código de proveedor")); }
        if(strlen($supplier)>6){ exit(jsonERR("Hay un error con el código de proveedor")); }

        $srch = "LIN*";
        for($i=$index; $i<count($content); $i++) {
            //echo "<hr>Se busca: ".$srch." en => ".$content[$i]."<hr>";
            if(strpos($content[$i],$srch)===false){
                if($srch==="REF*82"){
                    $line = $content[$i];
                    if(strpos($line,"REF*KK")===0){
                        $line = explode("*",$line);
                        //echo "Array ubicaciones: =>".count($line)."<br>";
                        if(empty($line) || count($line)<3){
                            exit(jsonERR("No se encontraron las localizaciones"));
                        }
                        $curLoc[0] = substr($line[2],0,5);
                        $curLoc[1] = substr($line[2],5,5);
                        $curLoc[2] = substr($line[2],10,5);
                        $curLoc[3] = substr($line[2],15,5);
                        if(empty($curLoc[0])){ $curLoc[0]=""; }
                        if(empty($curLoc[1])){ $curLoc[1]=""; }
                        if(empty($curLoc[2])){ $curLoc[2]=""; }
                        if(empty($curLoc[3])){ $curLoc[3]=""; }
                        //echo $curLoc[0]."||".$curLoc[1]."||".$curLoc[2]."||".$curLoc[3]."<br>";
                        continue;
                    }else{
                        exit(jsonERR("bag 1 Hay un error en el archivo"));
                    }
                }else{
                    exit(jsonERR("bag 2 Hay un error en el archivo"));
                }
            }
            $line = $content[$i];
            switch ($srch) {
                //Revisión del RAN y la Fecha
                case "FST*":
                    $line = explode("*",$line);
                    //echo "Array ran => ".count($line)."<br>";
                    if(empty($line) || count($line)<10){
                        exit(jsonERR("No se encontró el RAN"));
                    }
                    if(empty($line[4]) || !is_numeric($line[4]) || strlen($line[4])!=8){
                        exit(jsonERR("Hay un error con la fecha"));
                    }
                    if(empty($line[9]) || strlen($line[9])>8){
                        exit(jsonERR("Hay un error con el RAN"));
                    }
                    $curDate = $line[4];
                    $curRAN = $line[9];
                    $srch = "SDQ*";
                break;
                case "SDQ*":
                    $srch = "JIT*";
                break;
                //Revisión de Cantidad y Hora
                case "JIT*": 
                    $line = explode("*",$line);
                    //echo "Array cantidad => ".count($line)."<br>";
                    if(empty($line) || count($line)<3){
                        exit(jsonERR("No se encontró la Hora"));
                    }
                    if(empty($line[1]) || !is_numeric($line[1]) || strlen($line[1])>6){
                        exit(jsonERR("Hay un error con la Cantidad"));
                    }
                    if(empty($line[2]) || !is_numeric($line[2]) || strlen($line[2])!=4){
                        exit(jsonERR("Hay un error con la Hora"));
                    }

                    //Etiqueta completa (los datos se pasan al array de etiquetas)
                    $lbls[$nLabel] =  array(
                        "supplier" => $supplier,
                        "part" => $curPart,
                        "desc" => $curDesc,
                        "date" => $curDate,
                        "ran" => $curRAN,
                        "quant" => $line[1],
                        "time" => $line[2],
                        "loc1" => $curLoc[0],
                        "loc2" =>  $curLoc[1],
                        "loc3" => $curLoc[2],
                        "loc4" => $curLoc[3]
                    );
                    $nLabel += 1;               
                    //******

                    if(!empty($content[$i+1])){
                        $line = $content[$i+1];
                        if(strpos($line,"FST*")===0){
                            $srch = "FST*";
                        }elseif(strpos($line,"LIN*")===0) {
                            $srch = "LIN*";
                        }elseif(strpos($line,"CTT*")===0){
                            break 2;
                        }else{
                            exit(jsonERR("Error de línea: Se esperaba FST* , LIN* o fin de archivo (CTT*)"));
                        }
                    }
                break;
                //Revisión de la parte
                case "LIN*":
                    $line = explode("*",$line);
                    //echo "Array parte => ".count($line)."<br>";
                    if(empty($line) || count($line)<4){
                        exit(jsonERR("No se encontró el No. de parte"));
                    }
                    if(empty($line[3]) || strlen($line[3])>14){
                        exit(jsonERR("Hay un error en el No. de parte"));
                    }
                    $curPart = $line[3];
                    $curLoc[0] = "";
                    $curLoc[1] = "";
                    $curLoc[2] = "";
                    $curLoc[3] = "";
                    $srch = "UIT*EA";
                break;
                case "UIT*EA":
                    $srch = "REF*82";
                break;
                //Revisión de la descripción
                case "REF*82":
                    $line = explode("*",$line);
                    //echo "Array desc => ".count($line)."<br>";
                    if(empty($line) || count($line)<3){
                        exit(jsonERR("No se encontró la Descripción"));
                    }
                    if(empty($line[2]) || strlen($line[2])>50){
                        exit(jsonERR("Hay un error en la Descripción"));
                    }
                    $curDesc = $line[2];
                    $srch = "FST*";
                break;
                default:
                    exit(jsonERR("No se puede analizar el archivo. Consulte al Administrador"));
                break;
            }
        }
        
        require "../queries/generate_b64.php";
    }
    header("location:../../pages/error.html");
?>
