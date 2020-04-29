<?php
    function generate_label($parte,$cantidad,$fecha,$origen,$ran,$lote,$inspec){
        require_once "data_lote.php";
        $lot_data = search_lote($inspec);
        if($lot_data[0]){
            require_once "data_part.php";
            $part_data = search_part($parte);
            if($part_data[0]){
                require_once "equal_data.php";
                $equal_data = search_equal_data();
                if(!$equal_data){
                    return false;
                }
            }else{
                return $part_data[1];
            }
        }else{
            return $lot_data[1];
        }
        require_once "generate_code.php";
        return $qr = generate_code($part_data[1],$cantidad,$origen,$ran,$lot_data[1],$lote,$inspec,$equal_data);
    } 
?>
