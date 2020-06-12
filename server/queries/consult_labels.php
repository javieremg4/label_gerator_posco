<?php
    function consult_labels($limit,$date){
        require_once "connection.php";
        $query ="select l.serial,p.no_parte,l.ran,l.lote,l.inspec,l.cantidad,DATE_FORMAT(l.fecha_consumo,'%d/%m/%Y') as fecha_consumo,df.origen from etiqueta l,parte p,datos_fijos df where l.id_parte=p.id_parte and l.id_fijos=df.id ";
        if(!empty($limit)){
            $query .=  "order by serial desc limit ".$limit;
        }else{
            $query .= "and fecha_consumo='$date'";
        }
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $data = "<table class='table-style'>
                        <tr><th>Serial<th>No. Parte<th>No. Inspección<th>Ran<th>Lote<th>Cantidad<th>Fecha<th>Origen<th>Acciones";
                while($info = mysqli_fetch_array($result)){
                    $data .= "<tr><td>".$info['serial']."<td>".$info['no_parte']."<td>".$info['inspec']."<td>".$info['ran']."<td>".$info['lote']."<td>".$info['cantidad']."<td>".$info['fecha_consumo']."<td>".$info['origen'];           
                    $data .= "<td><a class='auto' href='see_label.php?lbl=".base64_encode($info['serial'])."'>Ver info.</a>";
                }
                $data .= "</table>";
                return $data;
            }else{
                return "No se encontraron etiquetas con esa fecha";
            }
        }
        return "No se pudieron consultar las Etiquetas. Consulte al Administrador";
    }

    function consult_label($serial){
        require "connection.php";
        $query = "select l.id_parte,l.id_inspec,l.ran,l.lote,l.inspec,l.cantidad,l.fecha_consumo,df.fecha_lote,df.fecha_rollo,df.bloque,df.hora_abasto,df.origen from etiqueta l,datos_fijos df where l.serial=".$serial." and l.id_fijos=df.id";
        $lbl_data = mysqli_query($connection,$query);
        if($lbl_data = mysqli_fetch_array($lbl_data)){
            $continue = true;
            $div3 = "<div class='div-part half'>".
                        "<span>RAN</span>".$lbl_data['ran'].
                        "<span>Inspección</span>".$lbl_data['inspec'].
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
            $query = "select no_parte,`desc`,esp,kgpc,snppz from parte where id_parte=".$lbl_data['id_parte'];
            $part_data = mysqli_query($connection,$query);
            if($part_data = mysqli_fetch_array($part_data)){
                $div1 = "<span>Parte BLK # ".$part_data['no_parte']."</span>".
                        "<div class='div-part ovx all'>".
                            "<table class='table-style'>".
                                "<tr><th>Descripción<th>SPEC<th>Kg./Pc<th>SNP PZ".
                                "<tr><td>".$part_data['desc']."<td>".$part_data['esp']."<td>".$part_data['kgpc']."<td>".$part_data['snppz'].
                            "</table>".
                        "</div>";   
            }else{
                $continue = false;
                $div1 = "<span>Parte BLK #".$part_data['no_parte']."</span>".
                        "<div class='div-part ovx all'>".
                            "No se pudieron consultar los datos de la Parte".
                        "</div>";
            }
            $query = "select no_lote,peso_rollo,yp,ts,el,tc,bc from lote where id_lote='".$lbl_data['id_inspec']."'";
            $lot_data = mysqli_query($connection,$query);
            if($lot_data = mysqli_fetch_array($lot_data)){
                $div2 = "<span>Lote # ".$lot_data['no_lote']."</span>".
                        "<div class='div-part ovx all'>".
                            "<table class='table-style'>".
                                "<tr><th>Peso (MT)<th>YP<th>TS<th>EL<th>TOP<th>BOTTOM".
                                "<tr><td>".$lot_data['peso_rollo']."<td>".$lot_data['yp']."<td>".$lot_data['ts']."<td>".$lot_data['el']."<td>".$lot_data['tc']."<td>".$lot_data['bc'].
                            "</table>".
                        "</div>";   
            }else{
                $continue = false;
                $div2 = "<span>Lote #".$lot_data['no_lote']."</span>".
                        "<div class='div-part ovx all'>".
                            "No se pudieron consultar los datos del Lote".
                        "</div>";
            }
            echo "<div class='div-center'>
                    <div class='div-union'>".
                        "<h2>Etiqueta #".$serial."</h2>".
                        $div1.$div2.$div3.$div4.
                    "</div>
                 </div>";
            if($continue){
                require "generate_label.php";
                echo generate_label(false,$serial,$part_data['no_parte'],$lbl_data['cantidad'],$lbl_data['fecha_consumo'],$lbl_data['ran'],$lbl_data['lote'],$lbl_data['inspec'],$lot_data['no_lote']); 
            }            
            
        }else{
            echo "No se pudo consultar la Etiqueta. Inténtelo de nuevo";
        }
    }

    function checkSerial($serial){
        require_once "connection.php";
        $query = "SELECT max(serial) AS serial FROM etiqueta";
        $result = mysqli_query($connection,$query);
        if($result = mysqli_fetch_array($result)){
            if($serial>$result['serial']){
                header("location:error.html");
                exit;
            }
        }else{
            echo "No se pudo consultar la Etiqueta. Consulte al Administrador";
            exit;
        }
    }
?>
