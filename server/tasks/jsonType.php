<?php
    // Las siguientes funciones contienen los formatos de los json
    // función jsonERR: retorna el json con status=ERR y el mensaje que se le pasa como parametro
    function jsonERR($message){
        return json_encode(array(
            "status" => "ERR",
            "message" => $message
        ));
    }
    // función jsonOK: retorna el json con status=OK y el mensaje que se le pasa como parametro
    function jsonOK($message){
        return json_encode(array(
            "status" => "OK",
            "message" => $message
        ));
    }
    // función jsonOKContent: retorna el json con status=OK y el contenido html (tablas,botones,formularios,etc.) que se le pasa como parametro
    function jsonOKContent($content){
        return json_encode(array(
            "status" => "OK",
            "content" => $content
        ));
    }
?>
