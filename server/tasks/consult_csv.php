<?php
    //Ocultar todas la errores (advertencias,notas,etc)
    error_reporting(0);
    //***
    if(isset($_FILES['file']['tmp_name'])){

        require "session_modules.php";
        session_modules_text();
        
        $path = $_FILES['file']['name']; 
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if($ext!='csv' && $ext!='CSV'){
            exit("Archivo: extensión incorrecta ||");
        }

        $array = file_get_contents($_FILES['file']['tmp_name']);
        if($array===false){ 
            exit("No se pudo consultar el archivo. Consulte al Administrador"); 
        }

        $array = explode("\r\n",$array);
        if($array===false){ 
            exit("No se pudo consultar el archivo. Consulte al Administrador"); 
        }

        /*Quitar lineas vacías del archivo*/
        $array = array_filter($array,"strlen");
        $array = array_values($array);

        if(count($array)===0){
            exit("No se detecto ningún registro. Revise el archivo");
        }

        echo "<span class='i'>Se detectaron ".count($array)." registros</span>";

        $pattern = "/^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/";
        
        global $data,$showBtn;
        $showBtn = true;
        $data = "<div class='ovx'>
            <table class='table-style' id='table_lots'>
            <tr><th>Reg.</th><th>No. Insp</th><th>Wgt.</th><th>Yield Point(YP)</th><th>Tensile Strength(TS)</th><th>Elongation(EL)</th><th>Top Coating</th><th>Bot Coating</th></tr>";
        for ($i=0; $i < count($array); $i++) { 
            $data .= "<tr>";
            $data .= "<td>".($i+1);
            $register = explode(",",$array[$i]);
            if(count($register)===7){
                if(validateField($register[0],15,true)){
                    if(preg_match($pattern,$register[0])===1){
                        $data .= "<td>".$register[0]."</td>";
                        for ($j=1; $j < count($register); $j++) {
                            if($j!=1){
                                $value = validateField($register[$j],6,false);
                            }else{
                                $value = validateField($register[$j],7,false);
                            }
                            if($value){
                                if(is_numeric($register[$j])){
                                    if($j!=1){
                                        if($register[$j]>999.99){
                                            $data .= "<td class='text-red cp'  title='Número grande (Máx. 999.99)'>".$register[$j]." {limit}";
                                            $showBtn = false;
                                        }else{
                                            $data .= "<td>".$register[$j]."</td>";
                                        }
                                    }else{
                                        if($register[$j]>9999.99){
                                            $data .= "<td class='text-red cp'  title='Número grande (Máx. 9999.99)'>".$register[$j]." {limit}";
                                            $showBtn = false;
                                        }else{
                                            $data .= "<td>".$register[$j]."</td>";
                                        }
                                    }
                                }else{
                                    $data .= "<td  class='text-red cp' title='Valor inválido: sólo números'>".$register[$j]." {invalid}";
                                    $showBtn = false;
                                }   
                            }
                        }
                    }else{
                        $data .= "<td class='text-red cp' title='Valor inválido: sólo alfanumérico con máx. un guion medio' colspan='7'>No. Insp: ".$register[0]." {invalid}";
                        $showBtn = false;
                    }
                }
            }else{
                $data .= "<td class='text-red cp' title='Se esperaban 7 datos separados por coma' colspan='7'>";
                $data .= (count($register)<7) ? "Se detectaron menos de 7 campos" : "Se detectaron más de 7 campos";
                $showBtn = false;
            }
            $data .= "</tr>";
        }
        $data .= "</table>
                </div>";
        
        
        if($showBtn){
            echo "<span>No olvide revisar los datos antes de subirlos <br>(el botón de registro está abajo de la tabla)</span>";
            $data .= "<button class='btn-send-lots' id='send'>Registrar Nros. Inspección</button>";
        }else{
            echo "<span class='cp' title='Pasa el ratón sobre los errores para saber de que se trata'>Es necesario corregir los errores (?) para subir los datos</span>";
        }

        exit($data);
    }
    header("location:../../pages/error.html");
    function validateField($field,$limit,$flag){
        global $data,$showBtn;
        if(!empty($field) || $field==="0"){
            if(strlen($field)<=$limit){
                return true;
            }else{
                $data .= ($flag) ? "<td class='text-red cp' title='Máx. 15 caracteres' colspan='7'>No. Insp: ".$field." {limit}" : "<td class='text-red cp'  title='Máx. ".$limit." caracteres'>".$field." {limit}";
                $showBtn = false;
                return false;
            }
        }else{
            $data .= ($flag) ? "<td class='text-red cp' title='No se encontró el dato' colspan='7'>No. Insp: {vacío}" : "<td class='text-red cp' title='No se encontró el dato'>{vacío}";
            $showBtn = false;
            return false;
        }
    }
?>
