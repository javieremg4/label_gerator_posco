<?php
    function consult_labels($limit,$date){
        require_once "connection.php";
        $query ="select e.serial,p.no_parte,l.no_lote,e.ran,e.lote,e.cantidad,DATE_FORMAT(e.fecha_consumo,'%d/%m/%Y') as fecha_consumo,df.origen from etiqueta e,parte p,lote l,datos_fijos df where e.id_parte=p.id_parte and e.id_inspec=l.id_lote and e.id_fijos=df.id ";
        if(!empty($limit)){
            $query .=  "order by serial desc limit ".$limit;
        }else{
            $query .= "and fecha_consumo='$date'";
        }
        $result = mysqli_query($connection,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $data = "<table class='table-style'>
                        <tr><th>Serial<th>No. Parte<th>No. Inspección<th>Ran<th>Lote<th>Cantidad<th>Fecha<th>Origen";
                while($info = mysqli_fetch_array($result)){
    
                    $data .= "<tr><td>".$info['serial']."<td>".$info['no_parte']."<td>".$info['no_lote']."<td>".$info['ran']."<td>".$info['lote']."<td>".$info['cantidad']."<td>".$info['fecha_consumo']."<td>".$info['origen'];           
                }
                $data .= "</table>";
                return $data;
            }else{
                return "No se encontraron etiquetas";
            }
        }
        return "No se pudieron consultar las Etiquetas. Consulte al Administrador";
    }
?>
