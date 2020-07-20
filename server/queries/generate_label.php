<?php
    //insert es una bandera que indica si la etiqueta se va a insertar en la BDD o no
    function generate_label($insert,$serial,$parte,$cantidad,$fecha,$ran,$nolote,$inspec){
        require "data_part.php";
        $part_data = ($insert) ? search_part(null,$parte,'id_parte,no_parte,esp,kgpc',false) : search_part($parte,null,'id_parte,no_parte,esp,kgpc',true);
        if($part_data[0]){
            require "data_lot.php";
            $lot_data = ($insert) ? search_lot(null,$inspec,'*',false) : search_lot($inspec,null,'*',true);
            if($lot_data[0]){
                require "equal_data.php";
                $equal_data = search_equal_data("id,fecha_lote,fecha_rollo,bloque,origen,DATE_FORMAT(hora_abasto,'%h:%i') AS hora_abasto");
                if(!$equal_data[0]){
                    return jsonERR($equal_data[1]);
               }
            }else{
                return jsonERR($lot_data[1]);
            }
        }else{
            return jsonERR($part_data[1]);
        }
        $part_data = $part_data[1];
        $lot_data = $lot_data[1];
        $equal_data = $equal_data[1];

        require "generate_code.php";
        $qr = generate_code($part_data,$cantidad,$ran,$lot_data,$nolote,$inspec,$equal_data);
        if(is_array($qr)){
            return jsonERR($qr[1]);
        }

        $label = "";

        if($insert){
            require "insert_label.php";
            $serial_label = insert_label($part_data['id_parte'],$lot_data['id_lote'],$ran,$nolote,$cantidad,$fecha,$equal_data['id']);
            if(is_array($serial_label)){
                return jsonERR($serial_label[1]);
            }else{
                $serial_alt = $serial_label;
            }
        }else if(!empty($serial)){
            $serial_alt = $serial;
        }
        
        $label .= "<div class='div-center'><button class='btn-pdf' id='pdf'>Generar pdf</button></div>";

        $label .= "<div class='div-center mb10'>
                    <div class='letter' id='to-pdf'>
                        <div class='div-big-table'>
                            <table class='big-table top rig lef'>
                                <tr class='h62'>
                                    <td colspan='3' class='black-td f40 relative'>
                                        <span class='span-text-top'>NUM. PARTE<br>(P)</span>
                                        ".$part_data['no_parte']."
                                    </td>
                                    <td rowspan='2' class='qr-div'>    
                                        <div id='rpta-label' data-html2canvas-ignore='true'>".$qr."</div>
                                    </td>
                                </tr>
                                <tr class='h62 bot'>
                                    <td colspan='3' class='relative'>
                                        <img id='part' alt='".$part_data['no_parte']."' />
                                        <span class='span-text-bottom'>DRIVE ASSY-WS WIPER</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='relative w40 bot' id='td-quantity'>
                                        <span class='span-text-top'>CANTIDAD<br>(Q)</span>
                                        <img id='quantity' alt='".str_pad($cantidad,4,'0',STR_PAD_LEFT)."' />
                                    </td>
                                    <td rowspan='2' class='w10 lef' >
                                        <span>RAN (15K)</span>
                                    </td>
                                    <td colspan='2'>
                                        <img id='ran' alt='".$ran."' />
                                    </td>
                                </tr>
                                <tr>
                                    <td class='f20'>".date('d-m-Y',strtotime($fecha))."</td>
                                    <td colspan='2' class='black-td f32'>
                                        ".$ran."
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class='div-inline-table'>
                            <table class='inline-table w60'>
                                <tr>
                                    <td class='relative'>   
                                        <span class='span-text-top'>PROVEEDOR<br>(V)</span>    
                                        <img id='origin' alt='".$equal_data['origen']."' />            
                                    </td>
                                </tr>
                                <tr>
                                    <td class='relative'> 
                                        <span class='span-text-top'>SERIAL<br>(4S)</span>       
                                        <img id='serial' alt='".$serial_alt."' />
                                    </td>
                                </tr>
                            </table>
                            <table class='inline-table f18 w40'>
                                <tr>
                                    <td>EL %<br>".$lot_data['el']."</td>
                                    <td>".$equal_data['bloque']."</td>
                                </tr>
                                <tr>
                                    <td>YP(Mpa)<br>".$lot_data['yp']."</td>
                                    <td>TS(Mpa)<br>".$lot_data['ts']."</td>
                                </tr>
                                <tr>
                                    <td>".$equal_data['hora_abasto']."</td>
                                    <td></td>
                                </tr>    
                            </table>
                        </div>
                    </div>
                </div>";
        return json_encode(
            array(
                "status" => "OK",
                "message" => "La etiqueta se registró con éxito",
                "content" => $label
            )
        );
    } 
?>
