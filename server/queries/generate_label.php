<?php
    function generate_label($parte,$cantidad,$fecha,$origen,$ran,$lote,$inspec){
        require_once "data_lote.php";
        $lot_data = search_lote($inspec,'*');
        if($lot_data[0]){
            require_once "data_part.php";
            $part_data = search_part($parte,"id_parte,no_parte,esp,kgpc");
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
        $part_data = $part_data[1];
        $lot_data = $lot_data[1];

        require_once "generate_code.php";
        $qr = generate_code($part_data,$cantidad,$origen,$ran,$lot_data,$lote,$inspec,$equal_data);
        if(is_array($qr)){
            return $qr[1];
        }

        $label = "";

        require_once "insert_label.php";
        $serial_label = insert_label($part_data['id_parte'],$lot_data['id_lote'],$ran,$lote,$cantidad,$fecha,$origen);
        if(is_array($serial_label)){
            $label .= "<script>alert('".$serial_label[1]."');</script>";
            $serial_alt = "0000";
        }else{
            $label .= "<script>alert('La etiqueta se registró con éxito');</script>";
            $serial_alt = $serial_label;
        }
        
        $label .= "<div class='letter' id='to-pdf'>
            <div class='div-big-table'>
                <table class='big-table top rig lef'>
                    <tr class='h62'>
                        <td colspan='3' class='black-td f40 relative'>
                            <span class='span-text-top'>NUM. PARTE<br>(P)</span>
                            ".$part_data['no_parte']."
                        </td>
                        <td rowspan='2' class='qr-div'>    
                            <div id='rpta-label'>".$qr."</div>
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
                            <img id='origin' alt='".$origen."' />            
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
        </div>";

        $label .= "<div>
            <button id='pdf'>Generar pdf</button>
        </div>";
        
        return $label;
    } 
?>
