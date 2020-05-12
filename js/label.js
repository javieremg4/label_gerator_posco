//function: asigna la fecha actual al input
window.onload = function(){
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var anio = fecha.getFullYear(); //obteniendo año
    if(dia<10){
        dia='0'+dia; //agrega cero si es menor de 10
    } 
    if(mes<10){
        mes='0'+mes //agrega cero si es menor de 10
    } 
    document.getElementById('fecha').value=anio+"-"+mes+"-"+dia;
}
//***
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    console.log("X:"+window.event.clientX+", Y:"+window.event.clientY);
    clean_search();
});
//***
//code: perder el foco de un elemento
$('#no-parte').on('blur',function(){
    clean_search();
});
$('#inspec').on('blur',function(){
    clean_search();
});
//***
//function: elimina las listas y busca el input
function clean_search(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
    }
    consult_part_lote('no-parte');
    if(document.getElementById('sug-lote').hasChildNodes()){
        cleanList('sug-lote');
    }
    consult_part_lote('inspec');
}
//***
//function: validar los datos de la etiqueta
function label_review(){
    var noparte = document.getElementById('no-parte').value;
    var whiteExp = /^\s+$/;
    if(noparte==="" || noparte===null || noparte.length===0 || !noparte.search(whiteExp)){
        alert("No. parte: obligatorio");
        return false;
    }
    if(noparte.length>13){
        alert("No. parte: Max. 13 caracteres");
        return false;
    }
    var alphanumeric = /^([a-zA-Z\d]|[a-zA-Z\d]\-)*[a-zA-Z\d]$/;
    if(noparte.search(alphanumeric)){
        alert("No. parte: valor inválido (solo alfanumerico)");
        return false;
    }

    var cantidad = document.getElementById('cantidad').value;
    if(cantidad<1){
        alert("Cantidad: inválido");
        return false;
    }
    if(cantidad.length>4){
        alert("Cantidad: Max. 4 caracteres");
        return false;
    }

    var fecha = document.getElementById('fecha').value;
    if(fecha==="" || fecha===null){
        alert("Fecha: obligatorio");
        return false;
    }
    if(!validarFormatoFecha(fecha)){
        alert("Fecha: formato invalido");
        return false;
    }
    if(!existeFecha(fecha)){
        alert("Fecha: invalido");
        return false;
    }

    /*---Validación del input origen
    var origen = document.getElementById('origen').value;
    if(origen==="" || origen===null || origen.length===0 || !origen.search(whiteExp)){
        alert("Origen: obligatorio");
        return false;
    }
    if(origen.length > 50){
        alert("Origen: Max. 50 caracteres");
        return false;
    }
    if(origen.search(alphanumeric)){
        alert("Origen: valor inválido (solo alfanumerico)");
        return false;
    }
    ---*/

    var noran = document.getElementById('no-ran').value;
    if(noran==="" || noran===null || noran.length===0 || !noran.search(whiteExp)){
        alert("No. Ran: obligatorio");
        return false;
    }
    if(noran.length > 8){
        alert("No. Ran: Max. 8 caracteres");
        return false;
    }
    if(noran.search(alphanumeric)){
        alert("No. Ran: valor inválido (solo alfanumerico)");
        return false;
    }

    var lote = document.getElementById('lote').value;
    if(lote==="" || lote===null || lote.length===0 || !lote.search(whiteExp)){
        alert("Lote: obligatorio");
        return false;
    }
    if(lote.length !== 13){
        alert("Lote: deben ser exactamente 13 caracteres");
        return false;
    }
    if(lote.search(alphanumeric)){
        alert("Lote: valor inválido (solo alfanumerico)");
        return false;
    }
    
    var inspec = document.getElementById('inspec').value;
    if(inspec==="" || inspec===null || inspec.length===0 || !inspec.search(whiteExp)){
        alert("Inspección: obligatorio");
        return false;
    }
    if(inspec.length > 15){
        alert("Inspección: Max. 15 caracteres");
        return false;
    }
    if(inspec.search(alphanumeric)){
        alert("Inspección: valor inválido (solo alfanumerico)");
        return false;
    }
    return "noparte="+noparte+"&cantidad="+cantidad+"&fecha="+fecha+"&noran="+noran+"&lote="+lote+"&inspec="+inspec;    //+"&origen="+origen
}   
//***
//code: evitar que se envie el formulario al dar enter
$('#form_label').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//code: enviar la info al servidor
$('#form_label').on('submit',function(event){
    event.preventDefault();
    var postData = label_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_label.php',
            data: postData,
            success: function(result){
                $('#server-answer').html(result);
                //generate_qr_code();
                generate_bar_codes();
                $('#pdf').click(function() {
                    //Asignar el src de la imagen del qr
                    var qr_b64 = "";
                    if($('#qr_img').length){
                        qr_b64 = $('#qr_img').attr('src');
                    }
                    /*//Generar el canvas del qr con html2canvas
                    html2canvas($('#thisQR')[0],{ dpi: 360, scrollY: -window.scrollY }).then(function(canvas){
                        qr = canvas.toDataURL("image/png");
                    });*/
                    //Generar el canvas de toda la etiqueta
                    html2canvas($('#to-pdf')[0],{ scrollX: 0, scrollY: -window.scrollY }).then(function(canvas){
                        var label = canvas.toDataURL("image/png");
                        //Crear el pdf
                        var doc = new jsPDF('p', 'pt', 'letter');
                        //Poner la imagen de la etiqueta en el pdf
                        doc.addImage(label, 'PNG', 0 ,10);
                        //Poner la imagen del qr arriba de la otra imagen
                        if(qr_b64 !== ''){
                            doc.addImage(qr_b64, 'PNG', 367, 12);
                        }
                        //Guardar el pdf
                        doc.save('test.pdf');
                    });
                });
            }
        });
    }
});
//***
//code: asignacion de la lista a los input
$('#no-parte').on('keyup',function(event){
    if($('#no-parte').val()!==''){
        if(!document.getElementById('no-parte').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#no-parte').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'no-parte','sug-part');
        }else{
            $('#sug-part').html('Sin sugerencias');
            $('#sug-part').addClass('sug-part');
        }
    }else{
        clean_search();
    }
});
//***
//code: ejecuta la accion al teclear en el input
$('#inspec').on('keyup',function(event){
    if($('#inspec').val()!==''){
        if(!document.getElementById('inspec').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#inspec').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'inspec','sug-lote');
        }else{
            $('#sug-lote').html('Sin sugerencias');
            $('#sug-lote').addClass('sug-lote');
        }
    }else{
        clean_search();
    }
});
//***
//function: genera el qr con js (ahorita no se usa)
function generate_qr_code(){
    var qrcode = new QRCode(document.getElementById('qrcodejs'),{
        width: 128,
        height: 128,
        colorDark: '#000000',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.L
    });
    qrcode.makeCode(document.getElementById('codigo').value);
}
//***
//function: genera el codigo de barras con js
function generate_bar_codes(){
    var text = 'P'+$('#part').attr('alt');
    JsBarcode('#part',text,{
        format: "CODE128",
		width: 2,
		height: 30,
		displayValue: false,
		margin: 2
    });
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
    text = '15K'+$('#ran').attr('alt');
    JsBarcode('#ran',text,{
        format: "CODE128",
		width: 2,
		height: 30,
		displayValue: false,
		margin: 2
    });
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
}
//***
