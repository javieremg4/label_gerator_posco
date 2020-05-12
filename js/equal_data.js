window.onload = function(){
    $.ajax({
        type: 'GET',
        url: '../server/tasks/view_equal_data.php',
        data: null,
        success: function(result){
            $('#form_data').html(result);
        }
    });
}
function equal_data_review(){
    //Validación input fecha-lote
    var fecha_lote = document.getElementById('fecha-lote').value;
    if(!white_review(fecha_lote,"Fecha Lote: obligatorio")){ return false; };
    if(fecha_lote.length!==13){
        alert("Fecha Lote: deben ser exactamente 13 caracteres");
        return false;
    }
    var dateExp = /^\d(\d|\s|\:|\-|\_){11}\d$/;
    if(fecha_lote.search(dateExp)){
        alert("Fecha Lote: valor inválido");
        return false;
    }
    //Validación input fecha-rollo
    var fecha_rollo = document.getElementById('fecha-rollo').value;
    if(!white_review(fecha_rollo,"Fecha Rollo: obligatorio")){ return false; };
    if(fecha_rollo.length!==13){
        alert("Fecha Rollo: deben ser exactamente 13 caracteres");
        return false;
    }
    if(fecha_rollo.search(dateExp)){
        alert("Fecha Rollo: valor inválido");
        return false;
    }
    //Validación input bloque
    var bloque = document.getElementById('bloque').value;
    if(!white_review(bloque,"Bloque: obligatorio")){ return false; };
    if(!char_limit(bloque,10,"Bloque: Max. 10 caracteres")){ return false; };
    var blockExp = /^[a-zA-Z\d](\w|\s|\:|\-){0,8}[a-zA-Z\d]$/;
    if(bloque.search(blockExp)){
        alert("Bloque: valor inválido");
        return false;
    }
    //Validación input hora
    var hora = document.getElementById('hora').value;
    if(hora===null || hora===''){
        alert("Hora abasto: obligatorio");
        return false;
    }
    //Validación input origen
    var origen = document.getElementById('origen').value;
    if(!char_limit(origen,8,"Origen: Max. 8 caracteres")){ return false; }
    var alphanumeric = /^([a-zA-Z\d]|[a-zA-Z\d]\-)*[a-zA-Z\d]$/;
    if(origen.search(alphanumeric)){
        alert("Origen: valor inválido (solo alfanumerico)");
        return false;
    }

    return "fecha-rollo="+fecha_rollo+"&fecha-lote="+fecha_lote+"&bloque="+bloque+"&hora="+hora+"&origen="+origen;
}
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        alert(msg);
        return false;
    }
    return true;
}
function white_review(variable,msg){
    var whiteExp = /^\s+$/;
    if(variable==="" || variable===null || variable.length===0 || !variable.search(whiteExp)){
        alert(msg);
        return false;
    }
    return true;
}
$('#form_data').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
$('#form_data').on('submit',function(event){
    event.preventDefault();
    var postData = equal_data_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            data: postData,
            url: '../server/tasks/change_equal_data.php',
            success: function(result){
                $('#res-data').html(result);
            }
        });
    }
});
