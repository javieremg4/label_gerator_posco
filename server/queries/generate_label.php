<?php
    /*función generate_label: genera toda la etiqueta para mostrarla en el navegador
        Nota: está función se usa en dos casos: 
        1) al momento de generar una nueva etiqueta y 2) al consultar la info. de una etiqueta ya registrada
        Parametros: 
            - serial: es el id de la etiqueta pero el valor varia segun el caso:
                1) el serial es null por que la etiqueta apenas se va registrar en la BDD
                2) el serial es el número de la etiqueta que se quiere consultar
            - ideqData: es el id de los datos fijos que le corresponden a la etiqueta (es null en el caso 1)
            - parte: su valor depende de los casos
                1) el no. de parte ingresado en el formulario
                2) el id. de la parte
            - cantidad: la cantidad que irá en la etiqueta
            - fecha: es la fecha de consumo (hoy) que irá en la etiqueta
            - ran: es el ran que irá en la etiqueta
            - nolote: no. de lote que irá en la etiqueta
            - inspec: su valor depende de los casos
                1) el no. de inspección ingresado en el formulario
                2) el id. de la inspección (lote)
    */ 
    function generate_label($serial,$ideqData,$parte,$cantidad,$fecha,$ran,$nolote,$inspec){
        
        /* Se consultan los datos ya sea por id (caso 2) o no. de parte (caso 1) */  
        require "data_part.php"; // Consultar función search_part en archivo data_part.php
       
        //Si no hay serial los datos de la parte se consultan por no_parte, de lo contrario, se consultan por id
        $part_data = (empty($serial)) ? search_part(null,$parte,'id_parte,no_parte,esp,kgpc',false) : search_part($parte,null,'id_parte,no_parte,esp,kgpc',true);
        
        if($part_data[0]){ // si la primera posición del array el true la consulta se realizó con éxito

            /* Se consultan los datos ya sea por id (caso 2) o no. de lote (caso 1) */
            require "data_lot.php"; // Consultar función search_lot en archivo data_lot.php
            
            //Si no hay serial los datos del lote se consultan por no_lote, de lo contrario, se consultan por id
            $lot_data = (empty($serial)) ? search_lot(null,$inspec,'*',false) : search_lot($inspec,null,'*',true);
            
            if($lot_data[0]){ // si la primera posición del array el true la consulta se realizó con éxito
                
                /* Se consultan los datos fijos que le corresponden a la etiqueta */
                require "equal_data.php"; // Consultar la función search_equal_data en archivo equal_data.php
                $equal_data = "id,fecha_lote,fecha_rollo,bloque,origen,DATE_FORMAT(hora_abasto,'%h:%i') AS hora_abasto";
                
                //Si no hay serial se consultan los datos del ultimo registro, de lo contrario, se consultan por id
                $equal_data = (empty($serial)) ? search_equal_data($equal_data,null) : search_equal_data($equal_data,$ideqData);
                
                if(!$equal_data[0]){ // si la primera posición del array es false ocurrió un error en la consulta
                    
                    return jsonERR($equal_data[1]); // consultar función jsonERR en archivo jsonType.php
                
                }
            }else{

                // si la primera posición del array es false se retorna el error en formato json
                return jsonERR($lot_data[1]); // consultar función jsonERR en archivo jsonType.php

            }

        }else{

            // si la primera posición del array es false se retorna el error en formato json
            return jsonERR($part_data[1]); // consultar función jsonERR en archivo jsonType.php

        }
        // Los datos que se necesitan estan en la segunda posición del array
        $part_data = $part_data[1];
        $lot_data = $lot_data[1];
        $equal_data = $equal_data[1];

        /* Se genera el código QR */
        require "generate_code.php"; // consultar función generate_code en archivo generate_code.php
        
        $qr = generate_code($part_data,$cantidad,$ran,$lot_data,$nolote,$lot_data['no_lote'],$equal_data);
        
        if(is_array($qr)){ // si la función generate_code retorna un array ocurrió uno o varios errores durante la generación del QR
            return jsonERR($qr[1]); // consultar función jsonERR en archivo jsonType.php
        }

        $label = ""; // String que contendrá el formato de la etiqueta y el botón que genera el pdf

        if(empty($serial)){ // Si no hay serial, la etiqueta se registra en la BDD

            require "insert_label.php"; // Consultar la función insert_label en archivo insert_label.php
            $serial_label = insert_label($part_data['id_parte'],$lot_data['id_lote'],$ran,$nolote,$cantidad,$fecha,$equal_data['id']);
            
            if(is_array($serial_label)){ // si la función insert_label retorna un array, ocurrió un error al registrar la etiqueta en la BDD
                
                return jsonERR($serial_label[1]); // consultar función jsonERR en archivo jsonType.php

            }else{

                $serial_alt = $serial_label; // si no hubo, errores la etiqueta contendrá el serial que retorno la función insert_label

            }
        }else{

            $serial_alt = $serial; // Si se pasó un serial cómo parametro, ese irá en la etiqueta

        }
        
        // Se concatena el código del botón
        $label .= "<div class='div-center'><button class='btn-pdf' id='pdf'>Generar pdf</button></div>";

        // Se concatena el código html de la etiqueta
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
                                    <td colspan='3' class='relative pd5015'>
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
    
        /* Se retorna un json con status=OK, el mensaje de éxito y la vista previa de la etiqueta*/
        return json_encode(
            array(
                "status" => "OK",
                "message" => "La etiqueta se registró con éxito",
                "content" => $label
            )
        );
    } 
?>
