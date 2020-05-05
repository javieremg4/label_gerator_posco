<?php
    function generate_code($part_data,$quantity,$origin,$ran,$lot_data,$lote,$inspec,$equal_data){

        $code = "";
        $error = "";
        
        //Funciona
        $part_number = str_pad($part_data['no_parte'],13,' ');
        $continue = review_length($part_number,13,'Código de Parte');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $part_number;
  
        //Funciona
        $ran = str_pad($ran,8,' ');
        $continue = review_length($ran,8,'RAN');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $ran;

        //Funciona
        $quantity = str_pad($quantity,4,'0',STR_PAD_LEFT);
        $continue = review_length($quantity,4,'Cantidad de Plantillas');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $quantity;
        
        //Funciona
        $lot_date = $equal_data['fecha_lote'];
        $continue = review_length($lot_date,13,'Fecha de Producción');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $lot_date;

        //Funciona
        $continue = review_length($lote,13,'Lote');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $lote;

        //Funciona
        $origin = str_pad($origin,50,' ');
        $continue = review_length($origin,50,'Origen');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $origin;

        //Funciona
        $continue = review_numeric($part_data['kgpc'],'Kg./Pc de la Parte');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        } 
        $bale_wgt = str_pad(totWgt($quantity,$part_data['kgpc']),7,'0',STR_PAD_LEFT);
        $continue = review_length($bale_wgt,7,'Peso de la Paca de Plantillas');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $bale_wgt;
        
        //Funciona
        $inspec = str_pad($inspec,15,' ');
        $continue = review_length($inspec,15,'Inspección');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $inspec;

        //Funciona
        $specification = str_pad($part_data['esp'],15,' ');
        $continue = review_length($specification,15,'Especificación de la Parte');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $specification;

        //Funciona
        $roll_date = $equal_data['fecha_rollo'];
        $continue = review_length($roll_date,13,'Fecha de Ingreso de Rollo a Planta');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $roll_date;
              
        //Funciona
        $continue = review_numeric($lot_data['peso_rollo'],'Peso total del Rollo');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        } 
        $roll_wgt = str_pad(truncateValue($lot_data['peso_rollo'],2),7,'0',STR_PAD_LEFT);
        $continue = review_length($roll_wgt,7,'Peso total del Rollo');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $roll_wgt;

        //Funciona
        $continue = review_numeric($lot_data['yp'],'YP del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        } 
        $yp = str_pad(truncateValue($lot_data['yp'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($yp,6,'YP');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $yp;

        //Funciona
        $continue = review_numeric($lot_data['ts'],'TS del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        } 
        $ts = str_pad(truncateValue($lot_data['ts'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($ts,6,'TS');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $ts;

        //Funciona
        $continue = review_numeric($lot_data['el'],'EL del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        }
        $el = str_pad(truncateValue($lot_data['el'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($el,6,'EL');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $el;

        //Funciona
        $continue = review_numeric($lot_data['tc'],'TOP del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        }
        $tc = str_pad(truncateValue($lot_data['tc'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($tc,6,'TOP');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $tc;

        //Funciona
        $continue = review_numeric($lot_data['bc'],'BOTTOM del Lote');
        if(is_array($continue)){
            $error .= $continue[1];
            return array(false,$error);
        }
        $bc = str_pad(truncateValue($lot_data['bc'],2),6,0,STR_PAD_LEFT);
        $continue = review_length($bc,6,'BOTTOM');
        if(is_array($continue)) $error .= $continue[1];
        $code .= $bc;

        if(!empty($error)){
            return array(false,$error);
        }
        //echo "Caracteres: <div id='contador'></div><textarea id='codigo' cols='180' rows='2'>".$code."</textarea><hr>";

        return generate_qr_code($code);
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
            //echo "Error: el dato ".$data_name." no es numérico (".$data.")<br>";
            return array(false,"Error: el dato ".$data_name." no es numérico (".$data.")<br>");
        }
        return true;
    }
    function review_length($data,$maxlength,$data_name){
        if(strlen($data)>$maxlength){
            //echo "Error: el dato ".$data_name." tiene mas de ".$maxlength." caracteres (".$data.")<br>";
            return array(false,"Error: el dato ".$data_name." tiene mas de ".$maxlength." caracteres (".$data.")<br>");
        }
        //echo $data_name.": ".$data." => (".strlen($data).")<br>";
        return true;
    }
    function generate_qr_code($code){
        require_once "../phpqrcode/qrlib.php";

        // how to save PNG codes to server
    
        $tempDir = '../qr/';
    
        $codeContents = 'This Goes From File';
    
        // we need to generate filename somehow, 
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = '005_file_'.md5($code).'.png';
    
        $pngAbsoluteFilePath = $tempDir.$fileName;
        $urlRelativeFilePath = "../server/qr/".$fileName;
    
        // generating
        if (!file_exists($pngAbsoluteFilePath)) {
            QRcode::png($code, $pngAbsoluteFilePath,QR_ECLEVEL_L, 2.5);
            //echo 'File generated!';
            //echo '<hr />';
        } else {
            //echo 'File already generated! We can use this cached file to speed up site on common codes!';
            //echo '<hr />';
        }

        // Cargando la imagen
        $data = file_get_contents($pngAbsoluteFilePath);

        // Decodificando la imagen en base64
        $base64 = 'data:image/png;base64,' . base64_encode($data);
    
        //echo 'Server PNG File: '.$pngAbsoluteFilePath;
        //echo '<hr />';
    
        // displaying
        unlink($pngAbsoluteFilePath);

        return '<img src="'.$base64.'" />';
        
    }
?>
