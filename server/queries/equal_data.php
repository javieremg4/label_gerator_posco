<?php
    function equal_data(){
        $array = search_equal_data("fecha_lote,fecha_rollo,bloque,origen,DATE_FORMAT(hora_abasto,'%H:%i') AS hora_abasto",null);
        if($array[0]){
            $info = $array[1];
            $data = "<div class='div-union'>";
            $data .= "<div class='div-part third'>
                        Fecha de creación de lote
                        <input type='text' id='fecha-lote' value='".$info['fecha_lote']."' minlength='13' maxlength='13'>
                    </div>";
            $data .= "<div class='div-part third'>
                        Fecha de ingreso de rollo
                        <input type='text' id='fecha-rollo' value='".$info['fecha_rollo']."' minlength='13' maxlength='13'>
                    </div>";
            $data .= "<div class='div-part third'>
                        Bloque
                        <input type='text' id='bloque' value='".$info['bloque']."' maxlength='10'>
                    </div>"; 
            $data .= "<div class='div-part'>
                        Hora de abasto
                        <input type='time' id='hora' value='".$info['hora_abasto']."'>
                    </div>";
            $data .= "<div class='div-part'>
                        Origen
                        <input type='text' id='origen' value='".$info['origen']."' maxlength='8'>
                    </div>";
            $data .= "</div>";
            $data .= "<div class='div-center'>
                        <input type='submit' id='btn-equal' value='Actualizar'>
                    </div>";
            return json_encode(
                array(
                    "status" => "OK",
                    "content" => $data
                ) 
            );
        }
        return json_encode(
            array(
                "status" => "ERR",
                "message" => $array[1]
            ) 
        );
    }
    /* función search_equal_data: se consultan los datos fijos y retorna dos tipos de array:
            1) array( true , datos_fijos )
            2) array( false , mensaje_de_error )
        Parametros:
            - campos: datos fijos que se quieren consultar (los campos se especifican cómo si fueran en una consulta)
            - id: número que identifica a esos datos fijos en la BDD
              NOTA: si el parametro id es null la función regresa los campos del ultimo elemento de la tabla 'datos_fijos'
    */
    function search_equal_data($campos,$id){
        require "connection.php";
        $query = "SELECT $campos FROM datos_fijos WHERE id=";
        $query .= (empty($id)) ? "(SELECT MAX(id) FROM datos_fijos)" : $id;
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }
        }
        return array(false,"No se pudieron consultar los datos fijos");
    }
?>
