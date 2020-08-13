<?php
    require '../vendor/autoload.php';
    require "getSerial.php";

    use Picqer\Barcode\BarcodeGeneratorPNG;
    /*use Endroid\QrCode\QrCode;
    use Endroid\QrCode\ErrorCorrectionLevel;*/

    const start = "!GP?";
    const end = "!END?";

    if(isset($_POST['data'])){
        $groupLbls = json_decode($_POST['data'],true);
        $codeArray[] = "";
        foreach ($groupLbls as $index => $data) {
            $codeArray[$index] = genLblCodes($data);
        }
        //var_dump($codeArray);
        exit(json_encode($codeArray));
    }
    function genLblCodes($data){

        $part = str_pad("P".$data['part'],15,'*');
        $snp = "Q".str_pad($data['quant'],6,'0',STR_PAD_LEFT);
        $ran = str_pad("15K".$data['ran'],11,'*');
        $supplier = str_pad("V".$data['supplier'],7,'*');

        $serial = getSerial($data['ran']);
        if(is_array($serial) && $serial[0]){
            $serial = str_pad($serial[1],18,'0',STR_PAD_LEFT);
            $serial = "4S".$serial;
        }else{
            exit(json_encode(
                array(
                    "status" => "ERR",
                    "message" => "No se pudo obtener serial"
                )
            ));
        }

        $loc1 = str_pad($data['loc1'],5,'*');
        $loc2 = str_pad($data['loc2'],5,'*');
        $loc3 = str_pad($data['loc3'],5,'*');
        $loc4 = str_pad($data['loc4'],5,'*');
        $free = str_pad("",41,'#');
        $code =  start.$part.$snp.$ran.$supplier.$serial.$loc1.$loc2.$loc3.$loc4.$data['date'].$data['time'].$free.end;
        return array(
                "qr"    => genQRCode($code),
                "part"  => genBarImg("P".$data['part']),
                "quant" => genBarImg("Q".$data['quant']),
                "ran"   => genBarImg("15K".$data['ran']),
                "sup"   => genBarImg("V".$data['supplier']),
                "serial"=> genBarImg($serial)
            );
    }
    function genBarImg($text){
        $generator = new BarcodeGeneratorPNG();
        return "data:image/png;base64,".base64_encode($generator->getBarcode($text, $generator::TYPE_CODE_128));
    }
    function genQRCode($code){

        //Inclusión de la librería que genera el código qr
        require_once "../server/phpqrcode/qrlib.php";

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

        return $base64;
    }
    function genQRImg($code){
        $qrCode = new QrCode($code);
        $qrCode->setSize(120);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::LOW());
        echo "<img src='".$qrCode->writeDataUri()."'>";
    }
?>
