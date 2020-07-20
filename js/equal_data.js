//event: cargar los datos fijos
window.onload = function(){
    $.ajax({
        type: 'GET',
        url: '../server/tasks/view_equal_data.php',
        data: null,
        dataType: 'json',
        success: function(data){
            if((data.status==="OK" && data.content)){
                $('#form_data').html(data.content);
            }else if(data.status==="ERR" && data.message){
                $('#form_data').html(data.message);
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            $('#form_data').html("No se pudieron consultar los datos fijos");
        }
    });
    inputFocus();
}
//***
//function: revisar datos fijos
function equal_data_review(){
    //Validación input fecha-lote
    var fecha_lote = document.getElementById('fecha-lote').value;
    if(!white_review(fecha_lote,"Fecha Lote: obligatorio")){ return false; };
    if(fecha_lote.length!==13){
        showQuitMsg('server_answer','btn-equal',"Fecha Lote: deben ser exactamente 13 caracteres");
        return false;
    }
    var dateExp = /^\d(\d|\s|\:|\-|\_){11}\d$/;
    if(fecha_lote.search(dateExp)){
        showQuitMsg('server_answer','btn-equal',"Fecha Lote: valor inválido");
        return false;
    }
    //Validación input fecha-rollo
    var fecha_rollo = document.getElementById('fecha-rollo').value;
    if(!white_review(fecha_rollo,"Fecha Rollo: obligatorio")){ return false; };
    if(fecha_rollo.length!==13){
        showQuitMsg('server_answer','btn-equal',"Fecha Rollo: deben ser exactamente 13 caracteres");
        return false;
    }
    if(fecha_rollo.search(dateExp)){
        showQuitMsg('server_answer','btn-equal',"Fecha Rollo: valor inválido");
        return false;
    }
    //Validación input bloque
    var bloque = document.getElementById('bloque').value.toUpperCase();
    if(!white_review(bloque,"Bloque: obligatorio")){ return false; };
    if(!char_limit(bloque,10,"Bloque: Max. 10 caracteres")){ return false; };
    var blockExp = /^[A-Z\d]([A-Z\d]|\s|\:|\-){0,8}[A-Z\d]$/;
    if(bloque.search(blockExp)){
        showQuitMsg('server_answer','btn-equal',"Bloque: valor inválido");
        return false;
    }
    //Validación input hora
    var hora = document.getElementById('hora').value;
    if(hora===null || hora===''){
        showQuitMsg('server_answer','btn-equal',"Hora abasto: obligatorio");
        return false;
    }
    //Validación input origen
    var origen = document.getElementById('origen').value.toUpperCase();
    if(!white_review(origen,"Origen: obligatorio")){ return false; };
    if(!char_limit(origen,8,"Origen: Max. 8 caracteres")){ return false; }
    var alphanumeric = /^([A-Z\d]|[A-Z\d]\-)*[A-Z\d]$/;
    if(origen.search(alphanumeric)){
        showQuitMsg('server_answer','btn-equal',"Origen: valor inválido (solo alfanumérico)");
        return false;
    }

    return "fecha-rollo="+fecha_rollo+"&fecha-lote="+fecha_lote+"&bloque="+bloque+"&hora="+hora+"&origen="+origen;
}
//function: revisar longitud máxima de un input
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        showQuitMsg('server_answer','btn-equal',msg);
        return false;
    }
    return true;
}
//***
//function: revisar que el input no este vacío
const whiteExp = /^\s+$/;
function white_review(variable,msg){
    if(variable==="" || variable===null || variable.length===0 || !variable.search(whiteExp)){
        showQuitMsg('server_answer','btn-equal',msg);
        return false;
    }
    return true;
}
//***
//event: evitar que el formulario se envíe con enter
$('#form_data').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//event: enviar el formulario (actualizar los datos fijos de la etiqueta)
$('#form_data').on('submit',function(event){
    event.preventDefault();
    cleanMsg('server_answer');
    var postData = equal_data_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            data: postData,
            url: '../server/tasks/change_equal_data.php',
            dataType: 'json',
            beforeSend: function(){ $('#btn-equal').attr("disabled",true); },
            success: function(data){
                if(data.status==="OK" && data.message){
                    quitMsgEvent('server_answer',data.message,'div-green');
                }else if(data.status==="ERR" && data.message){
                    quitMsgEvent('server_answer',data.message,'div-red');
                }else{
                    window.location = "../pages/index.php";
                }
            },
            error: function(){
                quitMsgEvent('server_answer',"No se pueden actualizar los Datos",'div-red');
            },
            complete: function(){ $('#btn-equal').attr("disabled",false); }
        });
    }
});
//***
