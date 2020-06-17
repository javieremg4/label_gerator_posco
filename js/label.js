//event: asigna la fecha actual al input
window.onload = function(){
    if($('#fecha').length){
        document.getElementById('fecha').value=getTodayDate('-');
        inputFocus();
    }
}
//event: detectar «click» en la página
$('html').on('click',function(){
    if($('#sug-part').length && $('#sug-lote').length){
        clean_lists();
    }
});
//***
//event: perder el foco del input con las listas desplegables
$('#no-parte').on('blur',function(event){
    if(document.getElementById('sug-part').hasChildNodes()){
        document.getElementById('no-parte').focus();
    }
});
$('#inspec').on('blur',function(event){
    if(document.getElementById('sug-lote').hasChildNodes()){
        document.getElementById('inspec').focus();
    }
});
//***
//function: elimina las listas y busca el input
function clean_lists(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
    }
    if(document.getElementById('sug-lote').hasChildNodes()){
        cleanList('sug-lote');
    }
}
//***
//function: limpiar los input de lote e inspección incluyendo el botón de cambios
function cleanInputs(){
    $('#no-lote').val("");
    $('#no-inspec').val("");
    if($('#change-lot').length){
        document.getElementById("div-lot").removeChild(document.getElementById("change-lot"));
    }
}
//***
$('#lot-input').on('keyup',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        cleanInputs();
        getLot();
        consult_part_lote('inspec');
    }
});
// function: calcular los números de lote e inpección según los casos
const lotExp = /^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/;
const hyphen = /\-/;
const beforeHyphen = /-[A-Z\d]+/;
const case1 = /^9A[A-Z\d]+\-[A-Z\d]+$/;
const case2 = /^98[A-Z\d]+\-[A-Z\d]+$/;
const case3 = /^\d{2}[A-Z\d]+\-[A-Z\d]+$/;
const case4 = /^98[A-Z\d]+R$/;
const case5 = /^\d{2}[A-Z\d]+$/;
const case6 = /^98[A-Z\d]+(A|B|C|D){2}R\-[A-Z\d]+$/;
const case7 = /^9A[A-Z\d]+$/;
const case8 = /^85C[A-Z\d]+$/;
function getLot(){

    var lot_input = document.getElementById('lot-input').value;
    var nlot = "";
    var nlot_aux = "";
    var ninspec = "";

    if(lotExp.test(lot_input)){
        if(hyphen.test(lot_input)){
            /* Caso 1: Inicia con 9A y tiene guión */
            if(case1.test(lot_input)){
                console.log("Caso 1");      
                nlot = lot_input.replace('9A','')
                nlot = nlot.replace('-','');
                if(nlot.length!== 13){
                    nlot_aux = lot_input.replace('9A','');
                    nlot_aux = nlot_aux.replace(beforeHyphen,'');
                    addButton(nlot,nlot_aux);
                }
                ninspec = lot_input.replace(beforeHyphen,'');
            }else if(case6.test(lot_input)){
            /* Caso 6: Inicia con 98, tiene dos letras entre (A,B,C,D) y R antes del guión */
                console.log("Caso 6");
                nlot = lot_input.replace('-','');
                ninspec = lot_input.replace(beforeHyphen,'');
            }else if(case2.test(lot_input)){
            /* Caso 2: Inicia con 98 y tiene guión */
                console.log("Caso 2");
                nlot = lot_input;
                if(nlot.length!==13){
                    nlot_aux = lot_input.replace('-','');
                    addButton(nlot,nlot_aux);
                }
                ninspec = lot_input.replace(beforeHyphen,'');
            }else if(case3.test(lot_input)){
            /* Caso 3: Inica con cualquier número (diferente a 98 y 9A) y tiene guión */
                console.log("Caso 3");
                let addZeros = 13-lot_input.length;
                let zeros = "";
                if(addZeros>0){
                    for (let index = 0; index < addZeros; index++) {
                        zeros += "0";
                    }
                    nlot = lot_input.replace('-','-'+zeros);
                }else{
                    nlot = lot_input;
                }
                ninspec = lot_input.replace(beforeHyphen,'');          
            }
        }else{
            if(case7.test(lot_input)){
            /* Caso 7: Inicia con 9A y no tiene guión */
                console.log("Caso 7");
                nlot = ninspec = lot_input;
            }else if(case4.test(lot_input)){
            /* Caso 4: Inicia con 98, termina con R y no tiene guión */
                console.log("Caso 4");
                let addZeros = 13-lot_input.length;
                let zeros = "";
                if(addZeros>0){
                    for (let index = 0; index < addZeros; index++) {
                        zeros += "0";
                    }
                    nlot = lot_input+zeros;
                }else{
                    nlot = lot_input;
                }
                ninspec = lot_input.substring(0,lot_input.length-1);
            }else if(case8.test(lot_input)){
            /* Caso 8: Inicia con 85C */
                console.log("Caso 8");
                nlot = lot_input;
            }else if(case5.test(lot_input)){
            /* Caso 5: Inicia con cualquier número (diferente a 98 y 9A) y no tiene guión */
                console.log("Caso 5");
                let addZeros = 13-lot_input.length;
                let zeros = "";
                if(addZeros>0){
                    for (let index = 0; index < addZeros; index++) {
                        zeros += "0";
                    }
                    nlot = lot_input+zeros;
                }else{
                    nlot = lot_input;
                }
                ninspec = lot_input;
            }else{
                console.log("Caso no identificado");
            }
        }
        /*if(case8.test(lot_input)){
            /* Caso 8: Inicia con 85C 
                console.log("Caso 8");
                ninspec = lot_input;
            }
        */
        if($('#no-lote').length){
            $('#no-lote').val(nlot);
        }
        if($('#inspec').length){
            $('#inspec').val(ninspec);
        }
        console.log("Lote: "+nlot);         
        console.log("Inspección: "+ninspec);
    }else{
        console.log("Sin formato de lote \n Value="+lot_input);
    }
}
//***
//function: validar los datos de la etiqueta
function label_review(){
    var noparte = document.getElementById('no-parte').value.toUpperCase();
    var whiteExp = /^\s+$/;
    if(noparte==="" || noparte===null || noparte.length===0 || !noparte.search(whiteExp)){
        showQuitMsg('validation-msg','btn-label',"No. parte: obligatorio");
        return false;
    }
    if(noparte.length>13){
        showQuitMsg('validation-msg','btn-label',"No. parte: Max. 13 caracteres");
        return false;
    }
    var alphanumeric = /^([A-Z\d]|[A-Z\d]\-)*[A-Z\d]$/;
    if(noparte.search(alphanumeric)){
        showQuitMsg('validation-msg','btn-label',"No. parte: valor inválido (solo alfanumerico)");
        return false;
    }

    var cantidad = document.getElementById('cantidad').value;
    if(cantidad<1){
        showQuitMsg('validation-msg','btn-label',"Cantidad: valor inválido");
        return false;
    }
    if(cantidad.length>4){
        showQuitMsg('validation-msg','btn-label',"Cantidad: Max. 4 caracteres");
        return false;
    }

    var fecha = document.getElementById('fecha').value;
    if(fecha==="" || fecha===null){
        showQuitMsg('validation-msg','btn-label',"Fecha: obligatorio");
        return false;
    }
    if(!dateFormat(fecha)){
        showQuitMsg('validation-msg','btn-label',"Fecha: formato inválido");
        return false;
    }
    if(!dateExists(fecha)){
        showQuitMsg('validation-msg','btn-label',"Fecha: valor inválido");
        return false;
    }

    var noran = document.getElementById('no-ran').value.toUpperCase();
    if(noran==="" || noran===null || noran.length===0 || !noran.search(whiteExp)){
        showQuitMsg('validation-msg','btn-label',"No. Ran: obligatorio");
        return false;
    }
    if(noran.length > 8){
        showQuitMsg('validation-msg','btn-label',"No. Ran: Max. 8 caracteres");
        return false;
    }
    if(noran.search(alphanumeric)){
        showQuitMsg('validation-msg','btn-label',"<pre>No. Ran: valor inválido \n(solo alfanumerico)</pre>");
        return false;
    }

    const lotExp = /^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/;

    var lot_input = document.getElementById('lot-input').value.toUpperCase();

    if(lot_input==="" || lot_input===null || lot_input.length===0 || !lot_input.search(whiteExp)){
        showQuitMsg('validation-msg','btn-label',"Introduzca el No. Lote");
        return false;
    }
    if(lot_input.length > 22){
        showQuitMsg('validation-msg','btn-label',"No. Lote: Máx. 22 caracteres");
        return false;
    }
    if(lot_input.search(lotExp)){
        showQuitMsg('validation-msg','btn-label',"<pre>No. Lote: valor inválido \n(solo alfanumérico con máx. 1 guion medio)</pre>");
        return false;
    }

    var nolote = document.getElementById('no-lote').value.toUpperCase();

    if(nolote==="" || nolote===null || nolote.length===0 || !nolote.search(whiteExp)){
        showQuitMsg('validation-msg','btn-label',"Lote: obligatorio");
        return false;
    }
    if(nolote.length !== 13){
        showQuitMsg('validation-msg','btn-label',"Lote: deben ser exactamente 13 caracteres");
        return false;
    }
    if(nolote.search(lotExp)){
        showQuitMsg('validation-msg','btn-label',"<pre>Lote: valor inválido \n(solo alfanumérico con máx. 1 guion medio)</pre>");
        return false;
    }
    
    var inspec = document.getElementById('inspec').value.toUpperCase();
    
    if(inspec==="" || inspec===null || inspec.length===0 || !inspec.search(whiteExp)){
        showQuitMsg('validation-msg','btn-label',"Inspección: obligatorio");
        return false;
    }
    if(inspec.length > 15){
        showQuitMsg('validation-msg','btn-label',"Inspección: Max. 15 caracteres");
        return false;
    }
    if(inspec.search(lotExp)){
        showQuitMsg('validation-msg','btn-label',"<pre>Inspección: valor inválido \n(solo alfanumérico con máx. 1 guion medio)</pre>");
        return false;
    }
    
    return "noparte="+noparte+"&cantidad="+cantidad+"&fecha="+fecha+"&noran="+noran+"&nolote="+nolote+"&inspec="+inspec;
}   
//***
//event: evitar que se envie el formulario al dar enter
$('#form_label').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//event: enviar el formulario (registrar y generar la etiqueta)
$('#form_label').on('submit',function(event){
    event.preventDefault();
    cleanMsg('validation-msg');
    /*Para quitar la etiqueta con el boton de pdf*/
    $('#server_answer').html("");
    /********/
    var postData = label_review();
    if(postData !== false){
        /*var msg= "¿Está seguro que los datos son correctos?";
        msg = confirm(msg);
        if(!msg){ return false; }*/
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_label.php',
            data: postData,
            dataType: 'json',
            success: function(data){
                console.log(data);
                if(data.status==="OK" && data.message && data.content){
                    quitMsgEvent('validation-msg',data.message,'div-green');
                    $('#server_answer').html(data.content);
                    pdfBtnEvent();
                }else if(data.status==="ERR" && data.message){
                    quitMsgEvent('validation-msg',data.message,'div-red');
                }else{
                    window.location="../pages/index.php";
                }
            },
            error: function(data){
                console.log(data);
                quitMsgEvent('validation-msg',"No se pudo generar la etiqueta. Consulte al Administrador",'div-red');
            }
        });
    }
});
//***
//event: asignacion de la lista a los input
$('#no-parte').on('keyup',function(event){
    if($('#no-parte').val()!==''){
        if(!document.getElementById('no-parte').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#no-parte').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'no-parte','sug-part');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-part').width($('#no-parte').width());
            //***
            $('#sug-part').html('Sin sugerencias');
            $('#sug-part').addClass('sug-part');
        }
    }else{
        clean_lists();
        $('#datos-parte').html("");
    }
});
//***
//event: ejecuta la accion al teclear en el input
$('#inspec').on('keyup',function(event){
    if($('#inspec').val()!==''){
        if(!document.getElementById('inspec').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#inspec').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'inspec','sug-lote');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-lote').width($('#inspec').width());
            //***
            $('#sug-lote').html('Sin sugerencias');
            $('#sug-lote').addClass('sug-lote');
        }
    }else{
        clean_lists();
        $('#datos-lote').html("");
    }
});
//***
//function: generar código de barras y agregar el evento al boton pdf
function pdfBtnEvent(){
    if($('#qr_img').length && $('#pdf').length){
        generate_bar_codes();
        //Se genera el nombre del archivo año.mes.dia#serial.pdf ó año.mes.dia.pdf sino se pudo generar el serial
        var filename = "";
        if($('#serial').length && $('#serial').attr('alt') !== undefined){
            filename = getTodayDate('.')+'#'+$('#serial').attr('alt')+'.pdf';
        }else{
            filename = getTodayDate('.')+'.pdf';
        }
        //******
        $('#pdf').click(function(){
            //Validación para que no se pueda generar el pdf en pantallas < 633px
            if($(window).width()>632){
                //Asignar el src de la imagen del qr
                var qr_b64 = $('#qr_img').attr('src');
                //Generar el canvas de toda la etiqueta
                html2canvas($('#to-pdf')[0],{ dpi: 360, scrollX: 0, scrollY: -window.scrollY }).then(function(canvas){
                    var label = canvas.toDataURL("image/png");
                    //Crear el pdf
                    var doc = new jsPDF('p', 'pt', 'letter');
                    //Poner la imagen de la etiqueta en el pdf
                    doc.addImage(label, 'PNG', -6 ,10);
                    //Poner la imagen del qr arriba de la otra imagen
                    if(qr_b64 !== ''){
                        doc.addImage(qr_b64, 'PNG', 367, 12);
                    }
                    //Guardar el pdf
                    doc.save(filename);
                });
            }else{
                alert("No se puede generar el pdf en esta resolución y/o dispositivo");
            }
        });
    }
}
//***
//function: genera los codigos de barras con js
function generate_bar_codes(){
    var bar_fail = "";
    if($('#part').length && $('#part').attr('alt') !== undefined){
        var text = 'P'+$('#part').attr('alt');
        JsBarcode('#part',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: false,
            margin: 2
        });
    }else{
        bar_fail += "\nparte";
    }
    if($('#quantity').length && $('#quantity').attr('alt') !== undefined){
        var msg = $('#quantity').attr('alt');
        text = 'Q'+msg;
        JsBarcode('#quantity',text,{
            format: "CODE128",// El formato
            width: 2, // La anchura de cada barra
            height: 30, // La altura del código
            displayValue: true, // ¿Mostrar el valor (como texto) del código de barras?
            text: msg, // Texto (no código) que acompaña al barcode
            fontOptions: "bold", // Opciones de la fuente del texto del barcode
            textAlign: "center", // En dónde poner el texto. center, left o right
            textPosition: "top", // Poner el texto arriba (top) o abajo (bottom)
            textMargin: 2, // Margen entre el texto y el código de barras
            fontSize: 20, // Tamaño de la fuente
            margin: 1 // Tamaño de los margenes, se puede especificar el valor de cada margen. marginTop, marginRight, marginBottom, marginLeft
        });
    }else{
        bar_fail += "\ncantidad";
    }
    if($('#ran').length && $('#ran').attr('alt') !== undefined){
        text = '15K'+$('#ran').attr('alt');
        JsBarcode('#ran',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: false,
            margin: 2
        });
    }else{
        bar_fail += "\nran";
    }
    if($('#origin').length && $('#origin').attr('alt') !== undefined){
        msg = $('#origin').attr('alt');
        text = 'V'+msg;
        JsBarcode('#origin',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: true,
            text: msg,
            fontOptions: "bold",
            textAlign: "center",
            textPosition: "top",
            textMargin: 2,
            fontSize: 20,
            margin: 2
        });
    }else{
        bar_fail += "\norigen";
    }
    if($('#serial').length && $('#serial').attr('alt') !== undefined){
        msg = $('#serial').attr('alt');
        text = '4S'+msg;
        JsBarcode('#serial',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: true,
            text: msg,
            fontOptions: "bold",
            textAlign: "center",
            textPosition: "top",
            textMargin: 2,
            fontSize: 20,
            margin: 2
        });
    }else{
        bar_fail += "\nserial";
    }
    if(bar_fail!==""){
        quitMsgEvent("validation-msg","<pre>No se pudieron generar los códigos de barras de:"+bar_fail+"\nConsulte al Administrador</pre>","div-red");
    }
}
//***
