<?php
    print_r($_FILES["file-862"]);
    $content = file_get_contents($_FILES["file-862"]['tmp_name']);
    $content = explode("\r\n",$content);
    $curDate = "";
    $curQuant = "";
    $curTime = "";
    $continue = true;

    $parts[] = "";
    $nParts = 0;

    /*Estas variables se usan para comprobar que no hay rans repetidos*/
    $repeatParts[] = "";
    $indexRepeat = 0;

    /*Estas variables son las que se usan en la nueva revisión*/
    $supplier = "";
    $curPart = "";

    $curLoc[0] = "";
    $curLoc[1] = "";
    $curLoc[2] = "";
    $curLoc[3] = "";

    $curDesc = "";
    $curRAN = "";
    $lbls[] = "";
    $nLabel = 0;

    
    //Búsqueda y revisión del proveedor
    foreach ($content as $index => $line) {
        if(strpos($line,"LIN*")===0){ break; }
        if(strpos($line,"N1*SU*")===0){
            $line = explode("*",$line);
            echo "Array proveedor: =>".count($line)."<br>";
            if(empty($line) || count($line)<5){
                exit("No se encontró el código de proveedor");
            }
            $supplier = $line[4];
        }
    }
    if(empty($supplier)){ exit("No se encontró el código de proveedor"); }
    if(strlen($supplier)>6){ exit("Hay un error con el código de proveedor"); }

    $srch = "LIN*";
    for($i=$index; $i<count($content); $i++) {
        echo "<hr>Se busca: ".$srch." en => ".$content[$i]."<hr>";
        if(strpos($content[$i],$srch)===false){
            if($srch==="REF*82"){
                $line = $content[$i];
                if(strpos($line,"REF*KK")===0){
                    $line = explode("*",$line);
                    echo "Array ubicaciones: =>".count($line)."<br>";
                    if(empty($line) || count($line)<3){
                        exit("No se encontraron las ubicaciones (locations)");
                    }
                    $curLoc[0] = substr($line[2],0,5);
                    $curLoc[1] = substr($line[2],5,5);
                    $curLoc[2] = substr($line[2],10,5);
                    $curLoc[3] = substr($line[2],15,5);
                    if(empty($curLoc[0])){ $curLoc[0]=""; }
                    if(empty($curLoc[1])){ $curLoc[1]=""; }
                    if(empty($curLoc[2])){ $curLoc[2]=""; }
                    if(empty($curLoc[3])){ $curLoc[3]=""; }
                    echo $curLoc[0]."||".$curLoc[1]."||".$curLoc[2]."||".$curLoc[3]."<br>";

                    continue;

                }else{
                    exit("¡Carácter invalido!<br>");
                }
            }else{
                exit("¡Carácter invalido!<br>");
            }
        }
        $line = $content[$i];
        switch ($srch) {
            //Revisión del RAN y la Fecha
            case "FST*":
                $line = explode("*",$line);
                echo "Array ran => ".count($line)."<br>";
                if(empty($line) || count($line)<10){
                    exit("No se encontró el RAN");
                }
                if(empty($line[4]) || !is_numeric($line[4]) || strlen($line[4])!=8){
                    exit("Hay un error con la fecha");
                }
                if(empty($line[9]) || strlen($line[9])>8){
                    exit("Hay un error con el RAN");
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
                echo "Array cantidad => ".count($line)."<br>";
                if(empty($line) || count($line)<3){
                    exit("No se encontró la Hora");
                }
                if(empty($line[1]) || !is_numeric($line[1]) || strlen($line[1])>6){
                    exit("Hay un error con la Cantidad");
                }
                if(empty($line[2]) || !is_numeric($line[2]) || strlen($line[2])!=4){
                    exit("Hay un error con la Hora");
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
                $curLoc[0] = "";
                $curLoc[1] = "";
                $curLoc[2] = "";
                $curLoc[3] = "";                
                //******

                if(!empty($content[$i+1])){
                    $line = $content[$i+1];
                    if(strpos($line,"FST*")===0){
                        $srch = "FST*";
                    }elseif(strpos($line,"LIN*")===0) {
                        $srch = "LIN*";
                    }elseif(strpos($line,"CTT*")===0){
                        echo "<hr>Fin de archivo<hr>";
                        break 2;
                    }else{
                        exit("Error de línea: Se esperaba FST* , LIN* o fin de archivo (CTT*)");
                    }
                }
            break;
            //Revisión de la parte
            case "LIN*":
                $line = explode("*",$line);
                echo "Array parte => ".count($line)."<br>";
                if(empty($line) || count($line)<6){
                    exit("No se encontró el No. de parte");
                }
                if(empty($line[3]) || strlen($line[3])>14){
                    exit("Hay un error en el No. de parte");
                }
                $curPart = $line[3];
                $srch = "UIT*EA";
            break;
            case "UIT*EA":
                $srch = "REF*82";
            break;
            //Revisión de la descripción
            case "REF*82":
                $line = explode("*",$line);
                echo "Array desc => ".count($line)."<br>";
                if(empty($line) || count($line)<3){
                    exit("No se encontró la Descripción");
                }
                if(empty($line[2]) || strlen($line[2])>50){
                    exit("Hay un error en la Descripción");
                }
                $curDesc = $line[2];
                $srch = "FST*";
            break;
            default:
                exit("No se puede analizar el archivo. Consulte al Administrador");
            break;
        }
    }
    //exit("Fin de las pruebas");

    /*foreach ($content as $line) {
        if(strpos($line,"N1*SU*")===0){
            $line = explode("*",$line);
            $supplier = $line[4];
            break;
        }
    }
    
    foreach ($content as $index => $line) {
        $continue = true;
        if(strpos($line,"LIN*")===0){
            $line = explode("*",$line);
            $parts[$nParts] = $curPart = $line[3];
            $nParts += 1;
            //echo "linea ".$index." Parte: ".$line[3]."<br>";
            $continue = false;
        }
        if($continue && strpos($line,"REF*KK*")===0){
            $line = explode("*",$line);
            $curLoc[0] = substr($line[2],0,5);
            $curLoc[1] = substr($line[2],5,5);
            $curLoc[2] = substr($line[2],10,5);
            $curLoc[3] = substr($line[2],15,5);
            if(empty($curLoc[0])){ $curLoc[0]=""; }
            if(empty($curLoc[1])){ $curLoc[1]=""; }
            if(empty($curLoc[2])){ $curLoc[2]=""; }
            if(empty($curLoc[3])){ $curLoc[3]=""; }
            //echo "linea ".$index." Locaciones: ".$line[2]." - ".strlen($line[2])."<br>";
            //echo "  => Loc 1".substr($line[2],0,5)."<br>";
            //echo "  => Loc 2".substr($line[2],5,5)."<br>";
            //echo "  => Loc 3".substr($line[2],10,5)."<br>";
            //echo "  => Loc 4".substr($line[2],15,5)."<br>";
            $continue = false;
        }
        if($continue && strpos($line,"REF*82*")===0){
            $line = explode("*",$line);
            $curDesc = $line[2];
            //echo "linea ".$index." Descripción: ".$line[2]."<br>";
            $continue = false;
        }
        if($continue && strpos($line,"FST*")===0){
            $line = explode("*",$line);
            $curDate = $line[4];
            $curRAN = $line[9];
            //echo "linea ".$index." Fecha: ".$line[4]." RAN: ".$line[9]."<br>";
            $continue = false;

            $repeatParts[$indexRepeat] = $curRAN;
            $indexRepeat += 1;
        }
        if($continue && strpos($line,"JIT*")===0){
            $line = explode("*",$line);
            $curQuant = $line[1];
            $curTime = $line[2];
            //echo "linea ".$index." Cantidad: ".$line[1]." Hora: ".$line[2]."<br>";
            /*echo "<hr>".
                    "Código de proveedor: ".$supplier."<br>".
                    "Parte: ".$curPart."<br>".
                    "Descripción: ".$curDesc."<br>".
                    "Fecha: ".$curDate."<br>".
                    "RAN: ".$curRAN."<br>".
                    "Cantidad: ".$curQuant."<br>".
                    "Hora: ".$curTime."<br>".
                    "Locación 1: ".$curLoc[0]."<br>".
                    "Locación 2: ".$curLoc[1]."<br>".
                    "Locación 3: ".$curLoc[2]."<br>".
                    "Locación 4: ".$curLoc[3]."<br>";

        }
    }*/
    echo "Total de etiquetas = ".count($lbls);
    
    /* Prueba RAN repetido
    $indexRepeat += 1;
    $repeatParts[$indexRepeat] = "LX71001A";
    echo "<hr><hr>".count($repeatParts)."=>".count(array_unique($repeatParts))."<hr><hr>";
    */

    $nGroup = 0;
    $nLabel = 0;
    $curPart = $lbls[0];
    $curPart = $curPart['part'];
    $groupLbls[] = null;
    $groupArray[] = null;

    foreach ($lbls as $index => $curLbl) {
        if($curPart == $curLbl['part']){
            $groupLbls[$nLabel] = $curLbl;
        }else{
            $curPart = $curLbl['part'];
            $groupArray[$nGroup] = $groupLbls;
            $nGroup += 1;
            $groupLbls = null;
            $nLabel = 0;
            $groupLbls[$nLabel] = $curLbl;
        }
        $nLabel += 1;
    }
    $groupArray[$nGroup] = $groupLbls;

    $totLbls = 0;
    foreach ($groupArray as $index => $groupLbls) {
        $curPart = $groupLbls[0];
        //echo $curPart['part']." => ".count($groupLbls)."<hr>";
        $totLbls += count($groupLbls);
    }
    //echo "Etiquetas agrupadas: ".$totLbls;

    //echo "<hr>Total de grupos = ".count($groupArray);

    //print_r($groupArray);
    
    require "genLbls.php";
?>
