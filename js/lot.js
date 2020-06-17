//event: hacer focus al primer input al cargar el documento
window.onload = function(){
    inputFocus();
}
//***
//function: revisar los datos del lote
function lote_review(){
    var lot = document.getElementById('lot').value.toUpperCase();
    if(!white_review(lot,"Nro. Inspección: obligatorio")){ return false; }
    if(!char_limit(lot,15,"Nro. Inspección: Max. 15 caracteres")){ return false; };
    var lotExp = /^\d[A-Z\d][A-Z\d]+\-{0,1}[A-Z\d]+$/;
    if(lot.search(lotExp)){
        showQuitMsg('server_answer','btn-lot',"Nro. Inspección: valor inválido (solo alfanumérico con máx. 1 guion medio)");
        return false;
    }

    var wgt = document.getElementById('wgt').value;
    if(!white_review(wgt,"Wgt: obligatorio")){ return false; };
    if(!char_limit(wgt,7,"Wgt: Max. 7 caracteres")){ return false; };
    if(!numeric_review(wgt,'Wgt',9999.99)){ return false; };

    var yp = document.getElementById('yp').value;
    if(!white_review(yp,"YP: obligatorio")){ return false; };
    if(!char_limit(yp,6,"YP: Max. 6 caracteres")){ return false; };
    if(!numeric_review(yp,'YP',999.99)){ return false; };

    var ts = document.getElementById('ts').value;
    if(!white_review(ts,"TS: obligatorio")){ return false; };
    if(!char_limit(ts,6,"TS: Max. 6 caracteres")){ return false; };
    if(!numeric_review(ts,'TS',999.99)){ return false; };

    var el = document.getElementById('el').value;
    if(!white_review(el,"EL: obligatorio")){ return false; };
    if(!char_limit(el,6,"EL: Max. 6 caracteres")){ return false; };
    if(!numeric_review(el,'EL',999.99)){ return false; };

    var tc = document.getElementById('tc').value;
    if(!white_review(tc,"TC: obligatorio")){ return false; };
    if(!char_limit(tc,6,"TC: Max. 6 caracteres")){ return false; };
    if(!numeric_review(tc,'TC',999.99)){ return false; };

    var bc = document.getElementById('bc').value;
    if(!white_review(bc,"BC: obligatorio")){ return false; };
    if(!char_limit(bc,6,"BC: Max. 6 caracteres")){ return false; };
    if(!numeric_review(bc,'BC',999.99)){ return false; };
    
    return "lot="+lot+"&wgt="+wgt+"&yp="+yp+"&ts="+ts+"&el="+el+"&tc="+tc+"&bc="+bc;
}
//***
//function: revisar que los datos sean números
function numeric_review(variable,name,limit){
    var expDecimal = /^(\d+|\d*.\d+)$/
    if(variable.search(expDecimal)){
        showQuitMsg('server_answer','btn-lot',name+": valor inválido (sólo números)");
        return false;
    }
    if(variable>limit){
        showQuitMsg('server_answer','btn-lot',name+": valor máximo ("+limit+")");
        return false;
    }
    return true;
}
//function: revisar longitud máxima de un input
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        showQuitMsg('server_answer','btn-lot',msg);
        return false;
    }
    return true;
}
//***
//function: revisar que el input no este vacío
const whiteExp = /^\s+$/;
function white_review(variable,msg){
    if(variable==="" || variable===null || variable.length===0 || !variable.search(whiteExp)){
        showQuitMsg('server_answer','btn-lot',msg);
        return false;
    }
    return true;
}
//***
//event: limpiar el formulario y el mensaje
$('#clean_all').on("click",function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    $('#form_properties')[0].reset();
});
//***
//event: enviar formulario (registrar lote)
$('#form_properties').on('submit',function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    var postData = lote_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_lot.php',
            data: postData,
            dataType: 'json',
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
                quitMsgEvent('server_answer',"No se puede registrar el No. Inspección. Consulte al Administrador",'div-red');
            }
        });
    }
});
//***
