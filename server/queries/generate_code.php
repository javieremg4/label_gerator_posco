<?php
    function generate_code($part_data,$quantity,$ran,$lot_data,$lote,$inspec,$equal_data){

        $code = "";
        $error = "";
        
        $part_number = str_pad($part_data['no_parte'],13,' ');
        $continue = review_length($part_number,13,'Código de Parte');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $part_number;
  
        $ran = str_pad($ran,8,' ');
        $continue = review_length($ran,8,'RAN');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $ran;

        $quantity = str_pad($quantity,4,'0',STR_PAD_LEFT);
        $continue = review_length($quantity,4,'Cantidad de Plantillas');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $quantity;
        
        $lot_date = $equal_data['fecha_lote'];
        $lot_date = str_pad($lot_date,13,' ');
        $continue = review_length($lot_date,13,'Fecha de Producción');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $lot_date;

        //Aquí se revisa que el lote tenga exactamente 13 caracteres
        $lote = str_pad($lote,13,' ');
        $continue = review_length($lote,13,'Lote');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $lote;

        $origin = str_pad($equal_data['origen'],50,' ');
        $continue = review_length($origin,50,'Origen');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $origin;

        $continue = review_numeric($part_data['kgpc'],'Kg./Pc de la Parte');
        if(is_array($continue)){
            $error .= $continue[1];
        } 
        $bale_wgt = str_pad(totWgt($quantity,$part_data['kgpc']),7,'0',STR_PAD_LEFT);
        $continue = review_length($bale_wgt,7,'Peso de la Paca de Plantillas');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $bale_wgt;
        
        $inspec = str_pad($inspec,15,' ');
        $continue = review_length($inspec,15,'Inspección');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $inspec;

        $specification = str_pad($part_data['esp'],15,' ');
        $continue = review_length($specification,15,'Especificación de la Parte');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $specification;

        $roll_date = $equal_data['fecha_rollo'];
        $roll_date = str_pad($roll_date,13,' ');
        $continue = review_length($roll_date,13,'Fecha de Ingreso de Rollo a Planta');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $roll_date;
              
        $continue = review_numeric($lot_data['peso_rollo'],'Peso total del Rollo');
        if(is_array($continue)){
            $error .= $continue[1];
        } 
        $roll_wgt = str_pad(truncateValue($lot_data['peso_rollo'],2),7,'0',STR_PAD_LEFT);
        $continue = review_length($roll_wgt,7,'Peso total del Rollo');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $roll_wgt;

        $continue = review_numeric($lot_data['yp'],'YP del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
        } 
        $yp = str_pad(truncateValue($lot_data['yp'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($yp,6,'YP');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $yp;

        $continue = review_numeric($lot_data['ts'],'TS del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
        } 
        $ts = str_pad(truncateValue($lot_data['ts'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($ts,6,'TS');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $ts;

        $continue = review_numeric($lot_data['el'],'EL del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
        }
        $el = str_pad(truncateValue($lot_data['el'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($el,6,'EL');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $el;

        $continue = review_numeric($lot_data['tc'],'TOP del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
        }
        $tc = str_pad(truncateValue($lot_data['tc'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($tc,6,'TOP');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $tc;

        $continue = review_numeric($lot_data['bc'],'BOTTOM del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
        }
        $bc = str_pad(truncateValue($lot_data['bc'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($bc,6,'BOTTOM');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $bc;

        if(!empty($error)){
            return array(false,$error);
        }
        
        $qr_code = generate_qr_code($code);

        return (!$qr_code) ? array(false,"Error: No se pudo generar el código QR. Consulte al Administrador") : $qr_code;
    }
    function truncateValue($number, $digitos){
        $multiplicador = pow (10,$digitos);
        $resultado = (intval($number * $multiplicador)) / $multiplicador;
        return number_format($resultado, $digitos,'.','');
    }
    function totWgt($cantidad, $kgpc){
        return truncateValue($cantidad*$kgpc,2);
    }
    function review_numeric($data,$data_name){
        if(!is_numeric($data)){
            return array(false,"Error: el dato ".$data_name." no es numérico (".$data.")<br>");
        }
        return true;
    }
    function review_length($data,$maxlength,$data_name){
        if(strlen($data)<$maxlength){
            return array(false,"Error: el dato ".$data_name." tiene menos de ".$maxlength." caracteres (".$data.")<br>");
        }else if(strlen($data)>$maxlength){
            return array(false,"Error: el dato ".$data_name." tiene mas de ".$maxlength." caracteres (".$data.")<br>");
        }
        return true;
    }
    function generate_qr_code($code){

        //Inclusión de la librería que genera el código qr
        require_once __DIR__."/../phpqrcode/qrlib.php";

        //Directorio donde estará el archivo
        $tempDir = '../qr/';

        //Se genera el nombre del archivo
        $fileName = md5($code).'.png';

        //Se revisa si existe el directorio sí no se crea
        if(!is_dir($tempDir)){
            if(!mkdir($tempDir, 0777)){
                return false;
            }
        }
    
        $pngAbsoluteFilePath = $tempDir.$fileName;
    
        // Generando la imagen con el qr
        if(!file_exists($pngAbsoluteFilePath)){
            QRcode::png($code, $pngAbsoluteFilePath,QR_ECLEVEL_L, 2.5);
        }else{
            return false;
        }

        // Cargando la imagen
        $data = file_get_contents($pngAbsoluteFilePath);
        if($data === false) { return false; }

        // Decodificando la imagen en base64
        $base64 = base64_encode($data);
        if(!$base64){ return false; }
        $base64 = 'data:image/png;base64,'.$base64;
    
        // Eliminando la imagen
        unlink($pngAbsoluteFilePath);

        return "<img id='qr_img' src='".$base64."' />";
    }
?>
