<?php
    function data_part($no_parte,$btn){
        $array = search_part($no_parte,"no_parte,`desc`,kgpc,esp,snppz",false);
        if($array[0]){
            $info = $array[1];
            $data = "<div class='ovx'>";
            $data .= "<table class='table-style'>
                    <tr><th>Parte BLK<th>Descripción<th>Kg./Pc<th>SNP PZ<th>SPEC";
            $data .= "<tr><td>".$info['no_parte'];
            $data .= "<td>".$info['desc'];
            $data .= "<td>".$info['kgpc'];
            $data .= "<td>".$info['snppz'];
            $data .= "<td>".$info['esp'];
            $data .= "</table>";
            $data .= "</div>";
            if(isset($btn)){
                $data .= "<div class='div-center mt10'>
                            <input type='submit' id='btn-submit' value='Eliminar'>
                            <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                        </div>";
            }
            return array(
                "status" => "OK",
                "content" => $data
            );
        }
        if(isset($array[2],$btn)){
            $data = $array[1];
            $data .= "<div class='div-center mt10'>
                        <input type='submit' id='btn-submit' value='Eliminar Partes'>
                        <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                    </div>";
            return array(
                "status" => "OK",
                "content" => $data
            );
        }
        return array(
            "status" => "ERR",
            "message" => $array[1]
        );
    }
    function update_part($no_parte){
        $array = search_part($no_parte,"id_parte,no_parte,`desc`,kgpc,snppz,esp",false);
        if($array[0]){
            $info = $array[1];
            $data = "<div class='div-part'>
                        No. Parte 
                        <input type='text' id='no-parte' value='".$info['no_parte']."'  maxlength='13'>
                    </div>";
            $data .= "<div class='div-part'>
                        Descripción
                        <input type='text' id='desc' value='".$info['desc']."'  maxlength='50' >
                    </div>";
            $data .= "<div class='div-part'>
                        Kg./Pc
                        <input type='text' id='kgpc' value='".$info['kgpc']."' maxlength='8'>
                    </div>";
            $data .= "<div class='div-part'>
                        SNP PZ
                        <input type='number' id='snppz' value='".$info['snppz']."'>
                    </div>";
            $data .= "<div class='div-part'>
                        Especificación
                        <input type='text' id='esp' value='".$info['esp']."' maxlength='15' >
                    </div>";
            $data .= "<div class='div-center'>
                        <input type='submit' id='btn-part' value='Guardar Cambios'>
                        <button class='btn-cancel' id='btn-cancel'>Cancelar</button>
                    </div>";
            $note = "<div class='div-note'><h3>NOTA</h3> Si actualiza los datos de una parte y ya había etiquetas registradas con esa parte, <u>las etiquetas podrían sufrir cambios</u>.<label id='lblx'>&times</label></div>";
            require "connection.php";
            $query = "select count(id_parte) as lbls from etiqueta where id_parte = ".$info['id_parte'];
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result = mysqli_fetch_array($result)){
                if($result['lbls']>0){
                    $data .= "<div class='div-note'><h3>NOTA</h3> Si actualiza los datos de esta parte <u>".$result['lbls'];
                    $data .= ($result['lbls']==='1') ? " etiqueta podría " : " etiquetas podrían ";
                    $data .=  " sufrir cambios</u><label id='lblx'>&times</label></div>";
                }   
            }else{
                $data .= $note;
            }
            return array(
                "status" => "OK",
                "content" => $data
            );      
        }
        return array(
            "status" => "ERR",
            "message" => $array[1]
        );
    }
    function search_part($no_parte,$campos,$inactivos){
        require "connection.php";
        $query = "SELECT $campos FROM parte WHERE no_parte='$no_parte'";
        if(!$inactivos){ $query .= " AND activo>0"; } 
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)===1){
                return array(true,mysqli_fetch_array($result));
            }else if(mysqli_num_rows($result)<=0){
                return array(false,"No se encontró la Parte. Revise el número ingresado");
            }else{
                return array(false,"Ese No. Parte existe ".mysqli_num_rows($result)." veces. Consulte al Administrador",mysqli_num_rows($result));
            }
        }
        return array(false,"No se pudieron consultar los datos de la Parte. Consulte al Administrador");
    }
?>
