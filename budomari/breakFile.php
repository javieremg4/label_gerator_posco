<?php
    echo "Analizando archivo<hr>";
    print_r($_FILES["file-862"]);
    $content = file_get_contents($_FILES["file-862"]['tmp_name']);
    $content = explode("\r\n",$content);
    $nLabel = 0;
    $supplier = "";
    $curPart = "";
    /*$curLoc[0] = "";
    $curLoc[1] = "";
    $curLoc[2] = "";
    $curLoc[3] = "";*/
    $curDesc = "";
    $curDate = "";
    $curRAN = "";
    $curQuant = "";
    $curTime = "";
    $continue = true;

    $parts[] = "";
    $nParts = 0;
    $lbls[] = "";

    /*Estas variables se usan para comprobar que no hay rans repetidos*/
    $repeatParts[] = "";
    $indexRepeat = 0;


    foreach ($content as $line) {
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
            $curLoc[0] = "";
            $curLoc[1] = "";
            $curLoc[2] = "";
            $curLoc[3] = "";
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
                    "Locación 4: ".$curLoc[3]."<br>";*/
            $lbls[$nLabel] =  array(
                "supplier" => $supplier,
                "part" => $curPart,
                "desc" => $curDesc,
                "date" => $curDate,
                "ran" => $curRAN,
                "quant" => $curQuant,
                "time" => $curTime,
                "loc1" => $curLoc[0],
                "loc2" =>  $curLoc[1],
                "loc3" => $curLoc[2],
                "loc4" => $curLoc[3]
            );
            $nLabel += 1;
        }
    }
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
        echo $curPart['part']." => ".count($groupLbls)."<hr>";
        $totLbls += count($groupLbls);
    }
    echo "Etiquetas agrupadas: ".$totLbls;

    echo "<hr>Total de grupos = ".count($groupArray);
    
    require "genLbls.php";
?>
