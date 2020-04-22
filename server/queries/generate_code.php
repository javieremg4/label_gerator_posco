<?php
    function generate_code($parte,$cantidad,$fecha,$origen,$ran,$lote,$inspec){
        require_once "data_lote.php";
        $lot_data = search_lote($inspec);
        if(!(!$lot_data)){
            require_once "data_part.php";
            $part_data = search_part($parte);
            if(!(!$part_data)){
                require_once "equal_data.php";
                $equal_data = search_equal_data();
                if(!$equal_data){
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }

        $code = "";

        $part_number = str_pad($part_data['no_parte'],13,' ');
        if(!review_length($part_number,13,'Código de Parte')) return false;
        $code .= $part_number;

        $ran = str_pad($ran,7,' ');
        if(!review_length($ran,7,'RAN')) return false;
        $code .= $ran;

        $cantidad = str_pad($cantidad,4,'0',STR_PAD_LEFT);
        if(!review_length($cantidad,4,'Cantidad de Plantillas')) return false;
        $code .= $cantidad;
        
        $lot_date = $equal_data['fecha_lote'];
        if(!review_length($lot_date,13,'Fecha de Producción')) return false;
        $code .= $lot_date;

        if(!review_length($lote,13,'Lote')) return false;
        $code .= $lote;

        $origen = str_pad($origen,50,' ');
        if(!review_length($origen,50,'Origen')) return false;
        $code .= $origen;

        if(!review_numeric($part_data['kgpc'],'Kg./Pc de la Parte')) return false;
        $kgpc = str_pad(truncateValue($part_data['kgpc'],2),7,'0',STR_PAD_LEFT);
        if(!review_length($kgpc,7,'Kg./Pc de la Parte')) return false;
        $code .= $kgpc;
        
        $inspec = str_pad($inspec,15,' ');
        if(!review_length($inspec,15,'Inspección')) return false;
        $code .= $inspec;

        $specification = str_pad($part_data['esp'],15,' ');
        if(!review_length($specification,15,'Especificación de la Parte')) return false;
        $code .= $specification;

        $roll_date = $equal_data['fecha_rollo'];
        if(!review_length($roll_date,13,'Fecha de Ingreso de Rollo a Planta')) return false;
        $code .= $roll_date;

        $roll_wgt = str_pad(totWgt($cantidad,$part_data['kgpc']),7,'0',STR_PAD_LEFT);
        if(!review_length($roll_wgt,7,'Peso total del Rollo')) return false;
        $code .= $roll_wgt;

        if(!review_numeric($lot_data['yp'],'YP del Lote')) return false;
        $yp = str_pad(truncateValue($lot_data['yp'],2),6,0,STR_PAD_LEFT);
        if(!review_length($yp,6,'YP')) return false;
        $code .= $yp;

        if(!review_numeric($lot_data['ts'],'TS del Lote')) return false;
        $ts = str_pad(truncateValue($lot_data['ts'],2),6,0,STR_PAD_LEFT);
        if(!review_length($ts,6,'TS')) return false;
        $code .= $ts;

        if(!review_numeric($lot_data['el'],'EL del Lote')) return false;
        $el = str_pad(truncateValue($lot_data['el'],2),6,0,STR_PAD_LEFT);
        if(!review_length($el,6,'EL')) return false;
        $code .= $el;

        if(!review_numeric($lot_data['tc'],'TOP del Lote')) return false;
        $tc = str_pad(truncateValue($lot_data['tc'],2),6,0,STR_PAD_LEFT);
        if(!review_length($tc,6,'TOP')) return false;
        $code .= $tc;

        if(!review_numeric($lot_data['bc'],'BOTTOM del Lote')) return false;
        $bc = str_pad(truncateValue($lot_data['bc'],2),6,0,STR_PAD_LEFT);
        if(!review_length($bc,6,'BOTTOM')) return false;
        $code .= $bc;

        return $code;
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
            echo "Error: el dato ".$data_name." no es numérico (".$data.")<br>";
            return false;
        }
        return true;
    }
    function review_length($data,$maxlength,$data_name){
        if(strlen($data)>$maxlength){
            echo "Error: el dato ".$data_name." tiene mas de ".$maxlength." caracteres (".$data.")<br>";
            return false;
        }
        //echo $data_name.": ".$data." => (".strlen($data).")<br>";
        return true;
    }
?>
