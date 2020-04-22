window.onload = function(){
    var getData = "view=1";
    $.ajax({
        type: 'get',
        url: '../server/tasks/view_equal_data.php',
        data: getData,
        success: function(result){
            $('#form_data').html(result);
        }
    });
}
function equal_data_review(){
    var fecha_rollo = document.getElementById('fecha-rollo').value;
    if(!white_review(fecha_rollo,"Fecha Rollo: obligatorio")){ return false; };
    if(!char_limit(fecha_rollo,13,"Fecha Rollo: Max. 13 caracteres")){ return false; };
    var fecha_lote = document.getElementById('fecha-lote').value;
    if(!white_review(fecha_lote,"Fecha Lote: obligatorio")){ return false; };
    if(!char_limit(fecha_lote,13,"Fecha Lote: Max. 13 caracteres")){ return false; };
    var bloque = document.getElementById('bloque').value;
    if(!white_review(bloque,"Bloque: obligatorio")){ return false; };
    if(!char_limit(bloque,10,"Bloque: Max. 10 caracteres")){ return false; };
    var hora = document.getElementById('hora').value;
    if(hora===null || hora===''){
        alert("Hora abasto: obligatorio");
        return false;
    }
    return "fecha-rollo="+fecha_rollo+"&fecha-lote="+fecha_lote+"&bloque="+bloque+"&hora="+hora;
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
