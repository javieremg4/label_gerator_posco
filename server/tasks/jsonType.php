<?php
    function jsonERR($message){
        return json_encode(array(
            "status" => "ERR",
            "message" => $message
        ));
    }
    function jsonOK($message){
        return json_encode(array(
            "status" => "OK",
            "message" => $message
        ));
    }
    function jsonOKContent($content){
        return json_encode(array(
            "status" => "OK",
            "content" => $content
        ));
    }
?>
