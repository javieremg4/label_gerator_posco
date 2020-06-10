<?php
    require "session_modules.php";
    if(!isset($_FILES['file']['tmp_name']) || empty($_FILES['file']['tmp_name'])){
        echo "Hubo un error al consultar el archivo. Inténtelo de nuevo";
        exit;
    }
    $path = $_FILES['file']['name']; 
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if($ext!='csv' && $ext!='CSV'){
        echo "Archivo: extensión incorrecta";
        exit;
    }

    $array = explode("\n",file_get_contents($_FILES['file']['tmp_name']));
    if($array===false){ echo "No se pudo consultar el archivo. Consulte al Administrador"; }

    echo "<span class='i'>Se detectaron ".count($array)." registros</span>";

    $pattern = "/^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/";
    
    global $data,$showBtn;
    $showBtn = true;
    $data = "<div class='ovx'>
        <table class='table-style' id='table_lots'>
        <tr><th>Reg.</th><th>Lot No.</th><th>Wgt.</th><th>Yield Point(YP)</th><th>Tensile Strength(TS)</th><th>Elongation(EL)</th><th>Top Coating</th><th>Bot Coating</th></tr>";
    for ($i=0; $i < count($array); $i++) { 
        $data .= "<tr>";
        $data .= "<td>".($i+1);
        //Quitar el retorno de carro, el \n se "quita" en el explode anterior y la , en el explode que sigue
        $array[$i] = str_replace("\r","",$array[$i]);
        //Forma alternativa a lo anterior
        //$array[$i] = preg_replace("/\s+/","",$array[$i]);
        $register = explode(",",$array[$i]);
        if(count($register)===7){
            if(validateField($register[0],22,true)){
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
                                $data .= "<td>".$register[$j]."</td>";
                            }else{
                                $data .= "<td  class='text-red cp' title='Valor inválido: sólo números'>".$register[$j]." {invalid}";
                                $showBtn = false;
                            }   
                        }
                    }
                }else{
                    $data .= "<td class='text-red cp' title='Valor inválido: sólo alfanumérico con máx. un guion medio' colspan='7'>No. Lote: ".$register[0]." {invalid}";
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
        $data .= "<button class='btn-send-lots' id='send'>Registrar lotes</button>";
    }else{
        echo "<span class='cp' title='Pasa el ratón sobre los errores para saber de que se trata'>Es necesario corregir los errores (?) para subir los lotes</span>";
    }

    echo $data;

    function validateField($field,$limit,$flag){
        global $data,$showBtn;
        if(!empty($field) || $field==="0"){
            if(strlen($field)<=$limit){
                return true;
            }else{
                $data .= ($flag) ? "<td class='text-red cp' title='Máx. 22 caracteres' colspan='7'>No. Lote: ".$field." {limit}" : "<td class='text-red cp'  title='Máx. ".$limit." caracteres'>".$field." {limit}";
                $showBtn = false;
                return false;
            }
        }else{
            $data .= ($flag) ? "<td class='text-red cp' title='No se encontró el dato' colspan='7'>No. Lote: {vacío}" : "<td class='text-red cp' title='No se encontró el dato'>{vacío}";
            $showBtn = false;
            return false;
        }
    }
?>
