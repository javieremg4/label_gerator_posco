<?php
    if(!isset($_FILES['file-862']['tmp_name'])){
        header("location:../../pages/error.html");
    }

    require '../../vendor/autoload.php';
    require "getSerial.php";
    require "barcode.php";

    use Picqer\Barcode\BarcodeGeneratorPNG;
    
    const start = "!GP?";
    const end = "!END?";

    if(!is_array($lbls) || empty($lbls)){ exit(jsonERR("No se pueden generar las etiquetas")); }
    $codeArray[] = "";
    $serial = getSerial();
    foreach ($lbls as $index => $data) {
        if(isset($data['supplier'],$data['part'],$data['desc'],$data['date'],$data['ran'],$data['quant'],$data['time'],$data['loc1'],$data['loc2'],$data['loc3'],$data['loc4'])){
            $codeArray[$index] = genLblCodes($data,$serial+$index);
        }else{
            exit(jsonERR("No se recibieron todos los datos"));
        }
    }
    setSerial($serial+$index+1);
    exit(json_encode(
        array(
            "status" => "OK",
            "codes" => $codeArray,
            "labels" => $lbls
        )
    ));
    function genLblCodes($data,$serial){

        //Revisión del serial
        if((empty($serial) && $serial!=0) || !is_numeric($serial) || $serial<0){
            exit(jsonERR("Hay un error con el serial"));
        }

        //Revisión del ran
        if(empty($data['ran']) || strlen($data['ran'])>8){
            exit(jsonERR("Hay un error con el ran"));
        }

        //Revisión de la parte 
        if(empty($data['part']) || strlen($data['part'])>14){
            exit(jsonERR("Hay un error con la parte"));
        }

        //Revisión de la cantidad
        if(empty($data['quant']) || !is_numeric($data['quant']) || strlen($data['quant'])>6){
            exit(jsonERR("Hay un error con la cantidad"));
        }

        //Revisión del proveedor
        if(empty($data['supplier']) || strlen($data['supplier'])>6){
            exit(jsonERR("Hay un error con el código de proveedor"));
        }

        //Revisión de las ubicaciones
        if(strlen($data['loc1'])>5){
            exit(jsonERR("Hay un error con la ubicación 1"));
        }
        if(strlen($data['loc2'])>5){
            exit(jsonERR("Hay un error con la ubicación 2"));
        }
        if(strlen($data['loc3'])>5){
            exit(jsonERR("Hay un error con la ubicación 3"));
        }
        if(strlen($data['loc4'])>5){
            exit(jsonERR("Hay un error con la ubicación 4"));
        }

        //Revisión de la fecha
        if(empty($data['date']) || !is_numeric($data['date']) || strlen($data['date'])!=8){
            exit(jsonERR("Hay un error con la fecha"));
        }

        //Revisión de la hora
        if(empty($data['time']) || !is_numeric($data['time']) || strlen($data['time'])!=4){
            exit(jsonERR("Hay un error con la hora"));
        }

        //Creación del texto del QR
        $code = start;
        $code .= str_pad("P".$data['part'],15,' ');
        $code .= "Q".str_pad($data['quant'],6,'0',STR_PAD_LEFT);
        $code .= str_pad("15K".$data['ran'],11,' ');
        $code .= str_pad("V".$data['supplier'],8,' ');
        $code .= "4S".str_pad($serial,18,'0',STR_PAD_LEFT);
        $code .= str_pad($data['loc1'],5,' ');
        $code .= str_pad($data['loc2'],5,' ');
        $code .= str_pad($data['loc3'],5,' ');
        $code .= str_pad($data['loc4'],5,' ');
        $code .= $data['date'];
        $code .= $data['time'];
        $code .= str_pad("",41,' ');
        $code .= end;

        //$code =  start.$part.$snp.$ran.$supplier.$serial.$loc1.$loc2.$loc3.$loc4.$data['date'].$data['time'].$free.end;
        
        //Creación del QR y las barras
        return array(
                "qr"    => genQRCode($code),
                "part"  => genBarCode("P".$data['part'],2),//genBarImg("P".$data['part'],2,30),
                "quant" => genBarCode("Q".$data['quant'],1.1),//genBarImg("Q".$data['quant'],1,38),
                "ran"   => genBarCode("15K".$data['ran'],1.5),//genBarImg("15K".$data['ran'],1,30),
                "sup"   => genBarCode("V".$data['supplier'],2),//genBarImg("V".$data['supplier'],2,30),
                "serial" => strval($serial),
                "serialCode"=> genBarCode("4S".$serial,1.3),//genBarImg("4S".$serial,1,30),
            );
    }
    
    // La funcion genBarImg usa la libreria picquer/php-barcode-generator (versión php >= 7.2)
    function genBarImg($text,$width,$height){
        $generator = new BarcodeGeneratorPNG();
        return "data:image/png;base64,".base64_encode($generator->getBarcode($text, $generator::TYPE_CODE_39,$width,$height));
    }

    // La funcion genBarCode usa el archivo barcode.php (versión php <= 7.2)
    function genBarCode($code,$sizeFactor){
        //Directorio donde estará el archivo
        $tempDir = '../bars/';

        //Se genera el nombre del archivo
        $fileName = md5($code).'.png';

        //Se revisa si existe el directorio si no se crea
        if(!is_dir($tempDir)){
            if(!mkdir($tempDir, 0777)){
                exit(jsonERR("No se pudo crear la carpeta"));
            }
        }
    
        $pngAbsoluteFilePath = $tempDir.$fileName;
    
        // Generando la imagen del código de barras
        if(!file_exists($pngAbsoluteFilePath)){
            barcode( $pngAbsoluteFilePath , $code , "30" , "horizontal", "code39", false, $sizeFactor );
        }

        // Cargando la imagen
        $data = file_get_contents($pngAbsoluteFilePath);
        if($data === false) { exit(jsonERR("No se pudo consultar la imagen")); }

        // Decodificando la imagen en base64
        $base64 = base64_encode($data);
        if(!$base64){ exit(jsonERR("No se pudo codificar la imagen")); }
        $base64 = 'data:image/png;base64,'.$base64;
    
        // Eliminando la imagen
        unlink($pngAbsoluteFilePath);

        return $base64;
    }

    function genQRCode($code){

        //Directorio donde estará el archivo
        $tempDir = '../qr/';

        //Se genera el nombre del archivo
        $fileName = md5($code).'.png';

        //Se revisa si existe el directorio si no se crea
        if(!is_dir($tempDir)){
            if(!mkdir($tempDir, 0777)){
                exit(jsonERR("No se pudo crear la carpeta"));
            }
        }
    
        $pngAbsoluteFilePath = $tempDir.$fileName;
    
        // Generando la imagen con el qr
        if(!file_exists($pngAbsoluteFilePath)){
            QRcode::png($code, $pngAbsoluteFilePath,QR_ECLEVEL_L,3,0);
        }

        // Cargando la imagen
        $data = file_get_contents($pngAbsoluteFilePath);
        if($data === false) { exit(jsonERR("No se pudo consultar la imagen")); }

        // Decodificando la imagen en base64
        $base64 = base64_encode($data);
        if(!$base64){ exit(jsonERR("No se pudo codificar la imagen")); }
        $base64 = 'data:image/png;base64,'.$base64;
    
        // Eliminando la imagen
        unlink($pngAbsoluteFilePath);

        return $base64;
    }
?>
