<?php
    function consult_labels($limit,$date){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query ="select l.serial,p.no_parte,l.ran,l.lote,i.no_lote,l.cantidad,DATE_FORMAT(l.fecha_consumo,'%d/%m/%Y') as fecha_consumo,df.origen from etiqueta l,parte p,lote i,datos_fijos df where l.id_inspec=i.id_lote and l.id_parte=p.id_parte and l.id_fijos=df.id ";
        if(!empty($limit)){
            $query .=  "order by serial desc limit ".$limit;
        }else{
            $query .= "and fecha_consumo='$date'";
        }
        $result = mysqli_query($connection,$query);
        mysqli_close($connection);
        if($result){
            if(mysqli_num_rows($result)>0){
                $data = "<table class='table-style'>
                        <tr><th>Serial<th>No. Parte<th>No. Inspección<th>Ran<th>Lote<th>Cantidad<th>Fecha<th>Origen<th>Acciones";
                while($info = mysqli_fetch_array($result)){
                    $data .= "<tr><td>".$info['serial']."<td>".$info['no_parte']."<td>".$info['no_lote']."<td>".$info['ran']."<td>".$info['lote']."<td>".$info['cantidad']."<td>".$info['fecha_consumo']."<td>".$info['origen'];           
                    $data .= "<td><a class='auto' href='see_label.php?lbl=".base64_encode($info['serial'])."'>Ver info.</a>";
                }
                $data .= "</table>";
                return jsonOKContent($data);
            }else{
                return jsonERR("No se encontraron etiquetas con esa fecha");
            }
        }
        return jsonERR("No se pudieron consultar las Etiquetas. Consulte al Administrador");
    }

    function consult_label($serial){
        require "connection.php";
        require "../tasks/jsonType.php";
        $query = "select l.id_parte,l.id_inspec,l.ran,l.lote,l.cantidad,l.fecha_consumo,df.fecha_lote,df.fecha_rollo,df.bloque,df.hora_abasto,df.origen from etiqueta l,datos_fijos df where l.serial=".$serial." and l.id_fijos=df.id";
        $lbl_data = mysqli_query($connection,$query);
        if($lbl_data = mysqli_fetch_array($lbl_data)){
            $div3 = "<div class='div-part half'>".
                        "<span>RAN</span>".$lbl_data['ran'].
                        "<span>Lote</span>".$lbl_data['lote'].
                        "<span>Cantidad</span>".$lbl_data['cantidad'].
                        "<span>Fecha Consumo</span>".$lbl_data['fecha_consumo'].
                    "</div>";   
            $div4 = "<div class='div-part half'>".
                        "<span>Origen</span>".$lbl_data['origen'].
                        "<span>Fecha Lote</span>".$lbl_data['fecha_lote'].
                        "<span>Fecha Rollo</span>".$lbl_data['fecha_rollo'].
                        "<span>Bloque</span>".$lbl_data['bloque'].
                        "<span>Hora Abasto</span>".$lbl_data['hora_abasto'].
                    "</div>";
            $query = "select activo,no_parte,`desc`,esp,kgpc,snppz from parte where id_parte=".$lbl_data['id_parte'];
            $part_data = mysqli_query($connection,$query);
            if($part_data = mysqli_fetch_array($part_data)){
                $div1 = "<span>Parte BLK # ".$part_data['no_parte']."</span>";
                $div1 .= ($part_data['activo']==='2') ? "<span class='span-note' title='La etiqueta puede sufrir cambios'>(actualizada)</span>" : "";
                $div1 .= "<div class='div-part ovx all'>".
                            "<table class='table-style'>".
                                "<tr><th>Descripción<th>SPEC<th>Kg./Pc<th>SNP PZ".
                                "<tr><td>".$part_data['desc']."<td>".$part_data['esp']."<td>".$part_data['kgpc']."<td>".$part_data['snppz'].
                            "</table>".
                        "</div>";   
            }else{
                mysqli_close($connection);
                exit(jsonERR("No se pudo consultar la Etiqueta. Inténtelo de nuevo"));
            }
            $query = "select activo,no_lote,peso_rollo,yp,ts,el,tc,bc from lote where id_lote='".$lbl_data['id_inspec']."'";
            $lot_data = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($lot_data = mysqli_fetch_array($lot_data)){
                $div2 = "<span>Inspección # ".$lot_data['no_lote']."</span>";
                $div2 .= ($lot_data['activo']==='2') ? "<span class='span-note' title='La etiqueta puede sufrir cambios'>(actualizada)</span>" : "";
                $div2 .= "<div class='div-part ovx all'>".
                            "<table class='table-style'>".
                                "<tr><th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM".
                                "<tr><td>".$lot_data['peso_rollo']."<td>".$lot_data['yp']."<td>".$lot_data['ts']."<td>".$lot_data['el']."<td>".$lot_data['tc']."<td>".$lot_data['bc'].
                            "</table>".
                        "</div>";

            }else{
                mysqli_close($connection);
                exit(jsonERR("No se pudo consultar la Etiqueta. Inténtelo de nuevo"));   
            }
            require "generate_label.php";
            $result = json_decode(generate_label(false,$serial,$lbl_data['id_parte'],$lbl_data['cantidad'],$lbl_data['fecha_consumo'],$lbl_data['ran'],$lbl_data['lote'],$lbl_data['id_inspec']),true); 
            if($result['status']==="OK"){
                exit (jsonOKContent(
                    "<div class='div-center'>
                        <div class='div-union'>".
                            "<h2>Etiqueta # ".$serial."</h2>".
                            $div1.$div2.$div3.$div4.
                        "</div>
                    </div>".
                    $result['content']
                )); 
            }else{
                exit (jsonERR("No se pudo consultar la etiqueta debido a: <br>".$result['message']));
            }            
        }
        mysqli_close($connection);
        exit(jsonERR("No se pudo consultar la Etiqueta. Inténtelo de nuevo"));
    }

    function checkSerial($serial,$dir){
        $serial = base64_decode($serial);
        if(!is_numeric($serial) || $serial<0){
            header("location:".$dir);
            exit;
        }else{
            require "alternate_connection.php";
            $query = "SELECT max(serial) AS serial FROM etiqueta";
            $result = mysqli_query($connection,$query);
            mysqli_close($connection);
            if($result = mysqli_fetch_array($result)){
                if($serial>$result['serial']){
                    header("location:".$dir);
                    exit;
                }
            }else{
                exit("No se pudo consultar la Etiqueta. Consulte al Administrador");
            }
        }
    }
?>
