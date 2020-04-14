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
    document.getElementById('fecha-consumo').value=anio+"-"+mes+"-"+dia;
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
$('#sug-part').click(function(event){
    event.stopPropagation();
});
$('#sug-lote').click(function(event){
    event.stopPropagation();
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
        alert("No. parte: Max. 13 caracteres")
        return false;
    }
    var cantidad = document.getElementById('cantidad').value;
    if(cantidad<1){
        alert("Cantidad: error");
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
    var nolote = document.getElementById('no-lote');
    if(nolote==="" || nolote===null || nolote.length===0 || !nolote.search(whiteExp)){
        alert("No. Lote: obligatorio");
        return false;
    }
    if(nolote.length > 15){
        alert("No. Lote: Max. 15 caracteres");
        return false;
    }
    var fecha = document.getElementById('fecha_consumo').value;
}   
//***
//jQuery: evitar el evento por default del elemento
$('#form_label').on('submit',function(event){
    /*var postData = "no-parte"+
    $.ajax({
        type: 'post',
        url: '../server/tasks/set_label.php',
        data: postData,
        success: function(result){
            $('#res-label').html(result);
        }
    });*/
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
//function: evaluar las teclas pulsadas en el input
function suggest_list(code,idInput,idList){
    var input = document.getElementById(idInput);
    var list = document.getElementById(idList);
    if(code === 40){ //code: abajo
        if(list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = list.firstChild;
            var bool = true;
            while(bool && part !== list.lastChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.nextSibling;
                } 
            }
            if(part === list.lastChild){
                if(part.style.background === ""){
                    list.firstChild.style.background = color;
                    input.value = list.firstChild.innerHTML;
                }else{
                    part.style.background = "";
                    list.firstChild.style.background = color;
                    input.value = list.firstChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.nextSibling.style.background = color;
                input.value = part.nextSibling.innerHTML;
            }
        }
    }else if(code === 38){ //code: arriba
        if(list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = list.lastChild;
            var bool = true;
            while(bool && part !== list.firstChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.previousSibling;
                } 
            }
            if(part === list.firstChild){
                if(part.style.background === ""){
                    list.lastChild.style.background = color;
                    input.value = list.lastChild.innerHTML;
                }else{
                    part.style.background = "";
                    list.lastChild.style.background = color;
                    input.value = list.lastChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.previousSibling.style.background = color;
                input.value = part.previousSibling.innerHTML;
            }
        }
    }else if(code === 13){ //code: enter
        if(list.hasChildNodes()){
            cleanList(idList);
        }
        consult_part_lote(idInput); 
    }else{
        if(input.value !== ""){
            switch (idInput) {
                case 'no-parte':
                    var postData = "no-parte="+input.value;
                    break;
                default:
                    var postData = "no-lote="+input.value;
                    break;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/suggest_part_lote.php',
                data: postData,
                success: function(result){
                    if(idInput === 'no-parte'){
                        //code: se agregan las sugerencias a la lista y los eventos
                        $('#sug-part').html(result);
                        $('#sug-part').addClass('sug-part');
                        $('ul#sug-part li').on('click',function(){
                            input.value = this.innerHTML;
                            if(list.hasChildNodes()){
                                cleanList(idList);
                            }
                            consult_part_lote(idInput);
                        });
                        //***
                    }else{
                        //code: se agregan las sugerencias a la lista y los eventos
                        $('#sug-lote').html(result);
                        $('#sug-lote').addClass('sug-lote');
                        $('ul#sug-lote li').on('click',function(){
                            input.value = this.innerHTML;
                            if(list.hasChildNodes()){
                                cleanList(idList);
                            }
                            consult_part_lote(idInput);
                        });
                        //***
                    }
                }
            });
        }else{
            cleanList(idList);
        }
    }
}
//***
//function: limpia la lista de sugerencias
function cleanList(idList){
    var list = document.getElementById(idList);
    while(list.hasChildNodes()){
        list.removeChild(list.firstChild);
    }
    $('#'+idList).removeClass(idList);
}
//***
//function: consulta los datos de la parte o el lote
function consult_part_lote(idInput){
    var input = document.getElementById(idInput);
    if(input.value !== ""){
        if(idInput === 'no-parte' || idInput === 'no-lote'){
            switch (idInput) {
                case 'no-parte':
                    var postData = "no-parte="+input.value;
                    break;
                default:
                    var postData = "no-lote="+input.value;
                    break;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/see_part_lote.php',
                data: postData,
                success: function(result){
                    if(idInput === 'no-parte'){
                        $('#datos-parte').html(result);
                    }else{
                        $('#datos-lote').html(result);
                    }
                }
            });
        }
    }else{
        switch (idInput) {
            case 'no-parte':
                $('#datos-parte').html("");
                break;
            case 'no-lote':
                $('#datos-lote').html("");
                break;
            default:
                break;
        }
    }
}
//***
