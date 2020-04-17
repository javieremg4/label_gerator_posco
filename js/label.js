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
//jQuery: detectar «click» fuera de un elemento
$('html').on('click',function(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
    }
    consult_part_lote('no-parte');
    if(document.getElementById('sug-lote').hasChildNodes()){
        cleanList('sug-lote');
    }
    consult_part_lote('no-lote');
});
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
    var cantidad = document.getElementById('cantidad').value;
    if(cantidad<1){
        alert("Cantidad: inválido");
        return false;
    }
    if(cantidad.length>4){
        alert("Cantidad: Max. 4 caracteres");
        return false;
    }
    var origen = document.getElementById('origen').value;
    if(origen==="" || origen===null || origen.length===0 || !origen.search(whiteExp)){
        alert("Origen: obligatorio");
        return false;
    }
    if(origen.length !== 8){
        alert("Origen: exactamente 8 caracteres");
        return false;
    }
    var noran = document.getElementById('no-ran').value;
    if(noran==="" || noran===null || noran.length===0 || !noran.search(whiteExp)){
        alert("No. Ran: obligatorio");
        return false;
    }
    if(noran.length > 8){
        alert("No. Ran: Max. 8 caracteres");
        return false;
    }
    var nolote = document.getElementById('no-lote').value;
    if(nolote==="" || nolote===null || nolote.length===0 || !nolote.search(whiteExp)){
        alert("No. Lote: obligatorio");
        return false;
    }
    if(nolote.length > 15){
        alert("No. Lote: Max. 15 caracteres");
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
    console.log("registrar etiqueta");
    return "noparte="+noparte+"&cantidad="+cantidad+"&fecha="+fecha+"&origen="+origen+"&noran="+noran+"&nolote="+nolote;
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
                $('#res-label').html(result);
            }
        });
    }
});
//***
//code: asignacion de la lista a los input
$('#no-parte').on('keyup',function(event){
    var code = event.which || event.keyCode;
    suggest_list(code,'no-parte','sug-part');
});
$('#no-lote').on('keyup',function(event){
    var code = event.which || event.keyCode;
    suggest_list(code,'no-lote','sug-lote');
});
//***
