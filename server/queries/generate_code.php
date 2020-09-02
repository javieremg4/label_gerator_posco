<?php
    /*
    función generate_code: revisa los datos y retorna la imagen del qr
        Parametros: 
    |       - part_data: array con la info. de la parte
            - quantity: cantidad ingresada en el formulario
            - ran: ran ingresado en el formulario
            - lot_data: array con la info. de la inspección (lote)
            - lote: no. de lote ingresado en el formulario
            - inspec: no. de inspección ingresado en el formulario
            - equal_data: array con los datos fijos
            
        Funciones auxiliares:
            - is_array: Devuelve TRUE si var es un array, o de lo contrario FALSE.
                Sintaxis: is_array( var )
            - str_pad: Rellena un string hasta una longitud determinada con otro string
                Sintaxis: str_pad( string_a_rellenar , longitud , con_lo_que_va_rellenar , lado_por_el_que_va_rellenar (STR_PAD_LEFT/STR_PAD_RIGHT));
                Nota: el lado por el que va rellenar es opcional, por defecto es STR_PAD_RIGHT 
            - strlen: Obtiene la longitud de un string
                Sintaxis: strlen( string )
            - review_length: usa la función strlen para verificar la longitud del string y retorna un array con dos posiciones:
                    array( false (error) / true , mensaje_de_error )
                Sintaxis: review_length( dato , longitud , nombre_del_dato (para que aparezca en el error) )
            - is_numeric: Comprueba si una variable es un número o un string numérico
                Sintaxis: is_numeric( variable )
                Nota: retorna true si es numérico y de lo contrario retorna false
            - review_length: usa la función is_numeric para verificar si el dato es numérico y retorna un array con dos posiciones:
                    array( false (error) / true , mensaje_de_error )
            - bcmul: Multiplica el left_operand por el right_operand y scale se usa para establecer el número de dígitos después del punto decimal en el resultado
                Sintaxis: bcmul ( left_operand , right_operand , scale )
    */


    function generate_code($part_data,$quantity,$ran,$lot_data,$lote,$inspec,$equal_data){

        $code = ""; // String donde se almacena el texto del qr
        $error = ""; // String donde se almacenan los errores

        // el no_parte se saca del array que contiene la info. de la parte
        $part_number = str_pad($part_data['no_parte'],13,' '); // se completa con espacios a la derecha
        $continue = review_length($part_number,13,'Código de Parte'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $part_number; // se concatena el no. de parte ya formateado
  
        $ran = str_pad($ran,8,' '); // se completa con espacios a la derecha
        $continue = review_length($ran,8,'RAN'); //se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $ran; // se concatena el ran ya formateado

        $continue = review_numeric($quantity,"Cantidad de Plantillas"); // se revisa que sea numerico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        if($quantity==0) $error .= "Error: el dato Cantidad de Plantillas es igual a 0 <br>"; // se revisa que no sea 0
        $quantity = str_pad($quantity,4,'0',STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($quantity,4,'Cantidad de Plantillas'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $quantity; // se concatena la cantidad ya formateada
        
        // la fecha_lote se saca del array que tiene los datos fijos
        $lot_date = str_pad($equal_data['fecha_lote'],13,' '); // se completa con espacios a la derecha
        $continue = review_length($lot_date,13,'Fecha de Producción'); // se revisa la longitud 
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error    
        $code .= $lot_date; // se concatena la fecha de lote ya formateada

        // la longitud del no. de lote debe ser 13 caracteres
        $continue = review_length($lote,13,'Lote'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $lote; // se concatena el no. de lote ya formateado

        // el origen se saca del array que tiene los datos fijos
        $origin = str_pad($equal_data['origen'],50,' '); // se completa con espacios a la derecha
        $continue = review_length($origin,50,'Origen'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $origin; // se concatena el origen ya formateado

        // el dato kgpc de la parte se obtiene del array con la info. de la parte
        $continue = review_numeric($part_data['kgpc'],'Kg./Pc de la Parte'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        if($part_data['kgpc']==0) $error .= "Error: el dato Kg./Pc de la Parte es igual a 0 <br>"; // se revisa que no sea 0
        $bale_wgt = str_pad(bcmul($quantity,$part_data['kgpc'],2),7,'0',STR_PAD_LEFT); // se calcula el peso de la paca de plantillas y se completa con ceros a la izq. 
        $continue = review_length($bale_wgt,7,'Peso de la Paca de Plantillas'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $bale_wgt; // se concatena el peso ya formateado
        
        $inspec = str_pad($inspec,15,' '); // se completa con espacios a la derecha
        $continue = review_length($inspec,15,'Inspección'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $inspec; // se concatena el no. de inspección ya formateado

        // la especificación se obtiene del array con la info. de la parte
        $specification = str_pad($part_data['esp'],15,' '); // se completa con espacios a la derecha
        $continue = review_length($specification,15,'Especificación de la Parte'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $specification; // se concatena la especificación ya formateada

        // la fecha del rollo se obtiene del array que tiene los datos fijos
        $roll_date = str_pad($equal_data['fecha_rollo'],13,' '); // se completa con espacios a la derecha
        $continue = review_length($roll_date,13,'Fecha de Ingreso de Rollo a Planta'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $roll_date; //se concatena la fecha ya formateada
              
        // el peso del rollo se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['peso_rollo'],'Peso total del Rollo'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        if($lot_data['peso_rollo']==0) $error .= "Error: El dato Peso total del Rollo es igual a 0"; // se revisa que no sea 0
        $roll_wgt = str_pad(bcmul($lot_data['peso_rollo'],'1',2),7,'0',STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($roll_wgt,7,'Peso total del Rollo'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $roll_wgt; // se concatena el peso del rollo ya formateado

        // YP se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['yp'],'YP del Lote'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $yp = str_pad(bcmul($lot_data['yp'],'1',2),6,0,STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($yp,6,'YP'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $yp; // se concatena YP ya formateado

        // TS se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['ts'],'TS del Lote'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $ts = str_pad(bcmul($lot_data['ts'],'1',2),6,0,STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($ts,6,'TS'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; //  se concatena el error
        $code .= $ts; // se concate el TS ya formateado

        // EL se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['el'],'EL del Lote'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $el = str_pad(bcmul($lot_data['el'],'1',2),6,0,STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($el,6,'EL'); // se revisa la lontiud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $el; // se concatena EL ya formateado

        // TC se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['tc'],'TOP del Lote'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $tc = str_pad(bcmul($lot_data['tc'],'1',2),6,0,STR_PAD_LEFT); //  se completa con ceros a la izq.
        $continue = review_length($tc,6,'TOP'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $tc; // se concatena el TC ya formateado

        // BC se obtiene del array con la info. de la inspección (lote)
        $continue = review_numeric($lot_data['bc'],'BOTTOM del Lote'); // se revisa que sea numérico
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $bc = str_pad(bcmul($lot_data['bc'],'1',2),6,0,STR_PAD_LEFT); // se completa con ceros a la izq.
        $continue = review_length($bc,6,'BOTTOM'); // se revisa la longitud
        if(is_array($continue)) $error .= $continue[1]; // se concatena el error
        $code .= $bc; // se concatena el BC ya formateado

        // Si el String que guarda los errores no esta vacío, se retorna el array con todos los errores
        if(!empty($error)) return array(false,$error);
        
        // Si no hubo ningún error se genera el código qr
        $qr_code = generate_qr_code($code);

        // Si no se pudo generar el código qr se retorna un mensaje de error , de lo contrario se retorna el código qr en base 64
        return (!$qr_code) ? array(false,"Error: No se pudo generar el código QR. Consulte al Administrador") : $qr_code;
    }
    // Funciones auxiliares (se explican arriba)
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
    // función generate_qr_code: genera el código qr y retorna la imagen
    function generate_qr_code($code){

        //Inclusión de la librería que genera el código qr
        //require_once __DIR__."/../phpqrcode/qrlib.php";
        require '../../vendor/autoload.php';

        //Directorio donde estará el archivo
        $tempDir = '../qr/';

        //Se genera el nombre del archivo
        $fileName = md5($code).'.png';

        //Se revisa si existe el directorio si no se crea
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
