//event: hacer focus al primer input al cargar el documento
window.onload = function(){
    inputFocus();
}
//***
//function: validar los datos de la parte
function part_review(){
    var no_parte = document.getElementById('no-parte').value.toUpperCase();
    if(!white_review(no_parte,"No. parte: obligatorio")){ return false; }
    if(!char_limit(no_parte,13,"No. parte: Max. 13 caracteres")){ return false; }
    const alphanumeric = /^([A-Z\d]|[A-Z\d]\-)*[A-Z\d]$/;
    if(!alphanumeric.test(no_parte)){
        showQuitMsg('server_answer','btn-part',"No. parte: valor inválido (sólo alfanumérico)");
        return false;
    }

    var desc = document.getElementById('desc').value.toUpperCase();
    if(!white_review(desc,"Descripción: obligatorio")){ return false; }
    if(!char_limit(desc,50,"Descripción: Max. 50 caracteres")){ return false; }
    if(/[\^'"<>&]/.test(desc)){ showQuitMsg('server_answer','btn-part',"Descripción: valor inválido"); return false; }

    var kgpc = document.getElementById('kgpc').value;
    if(!white_review(kgpc,"Kg./Pc: obligatorio")){ return false; }
    var expDecimal = /^(\d+|\d*\.\d+)$/
    if(!expDecimal.test(kgpc)){
        showQuitMsg('server_answer','btn-part',"Kg./Pc: valor inválido (sólo números)");
        return false;
    }
    if(parseFloat(kgpc)===0){
        showQuitMsg('server_answer','btn-part',"Kg./Pc: obligatorio");
        return false;
    }
    if(!char_limit(kgpc,8,"Kg./Pc: Max. 8 caracteres")){ return false; }
    if(kgpc>9999.999){
        showQuitMsg('server_answer','btn-part',"Kg./Pc: valor máximo (9999.999)");
        return false;
    }

    var snppz = document.getElementById('snppz').value;
    if(!/^\d+$/.test(snppz)){
        showQuitMsg('server_answer','btn-part',"SNP PZ: valor inválido (sólo números)");
        return false;
    }
    if(parseFloat(snppz)===0){
        showQuitMsg('server_answer','btn-part',"SNP PZ: obligatorio");
        return false;
    }
    if(!char_limit(snppz,4,"SNP PZ: Max. 4 caracteres")){ return false; }
    
    var esp = document.getElementById('esp').value.toUpperCase();
    if(!white_review(esp,"Especificación: obligatorio")){ return false; }
    if(!char_limit(esp,15,"Especificación: Max. 15 caracteres")){ return false; }
    if(!alphanumeric.test(esp)){
        showQuitMsg('server_answer','btn-part',"Especificación: valor inválido (sólo alfanumérico)");
        return false;
    }
    
    return "no-parte="+no_parte+"&desc="+desc+"&esp="+esp+"&kgpc="+kgpc+"&snppz="+snppz;
}
//***
//function: revisar longitud máxima de un input
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        showQuitMsg('server_answer','btn-part',msg);
        return false;
    }
    return true;
}
//***
//function: revisar que el input no este vacío
const whiteExp = /^\s+$/;
function white_review(variable,msg){
    if(variable==="" || variable===null || variable.length===0 || whiteExp.test(variable)){
        showQuitMsg('server_answer','btn-part',msg);
        return false;
    }
    return true;
}
//***
//event: limpiar formulario y mensaje
$('#clean_all').on("click",function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    $('#form_part')[0].reset();
});
//***
//event: enviar formulario (registrar la parte)
$('#form_part').on('submit',function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    var postData = part_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_part.php',
            data: postData,
            dataType: 'json',
            beforeSend: function(){ 
                $('#btn-part').attr("disabled",true);
                $('#clean_all').attr("disabled",true);
            },
            success: function(data){
                if(data.status==="OK" && data.message){
                    quitMsgEvent('server_answer',data.message,'div-green');
                }else if(data.status==="ERR" && data.message){
                    quitMsgEvent('server_answer',data.message,'div-red');
                }else{
                    window.location="../pages/index.php";
                }
            },
            error: function(){
                quitMsgEvent('server_answer',"No se puede registrar la Parte. Consulte al Administrador",'div-red');
            },
            complete: function(){ 
                $('#btn-part').attr("disabled",false);
                $('#clean_all').attr("disabled",false);
            }
        });
    }
});
//***
