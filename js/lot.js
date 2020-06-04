window.onload = function(){
    if(document.forms.length > 0) {
        for(var i=0; i < document.forms[0].elements.length; i++) {
            var campo = document.forms[0].elements[i];
            if(campo.type != "hidden") {
                campo.focus();
                break;
            }
        }
    }
}
function lote_review(){
    var lot = document.getElementById('lot').value;
    if(!white_review(lot,"Lot No: obligatorio")){ return false; }
    if(!char_limit(lot,15,"Lot No: Max. 15 caracteres")){ return false; };
    var alphanumeric = /^\d([A-Z\d]|[A-Z\d]\-)*([A-Z]|\d)$/;
    if(lot.search(alphanumeric)){
        showQuitMsg("Lot No: valor inválido (solo alfanumerico)");
        return false;
    }
    var wgt = document.getElementById('wgt').value;
    if(!white_review(wgt,"Wgt: obligatorio")){ return false; };
    if(!char_limit(wgt,7,"Wgt: Max. 7 caracteres")){ return false; };
    if(!numeric_review(wgt,'Wgt: valor inválido (sólo números)')){ return false; };
    var yp = document.getElementById('yp').value;
    if(!white_review(yp,"YP: obligatorio")){ return false; };
    if(!char_limit(yp,6,"YP: Max. 6 caracteres")){ return false; };
    if(!numeric_review(yp,'YP: valor inválido (sólo números)')){ return false; };
    var ts = document.getElementById('ts').value;
    if(!white_review(ts,"TS: obligatorio")){ return false; };
    if(!char_limit(ts,6,"TS: Max. 6 caracteres")){ return false; };
    if(!numeric_review(ts,'TS: valor inválido (sólo números)')){ return false; };
    var el = document.getElementById('el').value;
    if(!white_review(el,"EL: obligatorio")){ return false; };
    if(!char_limit(el,6,"EL: Max. 6 caracteres")){ return false; };
    if(!numeric_review(el,'EL: valor inválido (sólo números)')){ return false; };
    var tc = document.getElementById('tc').value;
    if(!white_review(tc,"TC: obligatorio")){ return false; };
    if(!char_limit(tc,6,"TC: Max. 6 caracteres")){ return false; };
    if(!numeric_review(tc,'TC: valor inválido (sólo números)')){ return false; };
    var bc = document.getElementById('bc').value;
    if(!white_review(bc,"BC: obligatorio")){ return false; };
    if(!char_limit(bc,6,"BC: Max. 6 caracteres")){ return false; };
    if(!numeric_review(bc,'BC: valor inválido (sólo números)')){ return false; };
    return "lot="+lot+"&wgt="+wgt+"&yp="+yp+"&ts="+ts+"&el="+el+"&tc="+tc+"&bc="+bc;
}
function numeric_review(variable,msg){
    var expDecimal = /^(\d+|\d*.\d+)$/
    if(variable.search(expDecimal)){
        showQuitMsg(msg);
        return false;
    }
    return true;
}
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        showQuitMsg(msg);
        return false;
    }
    return true;
}
function white_review(variable,msg){
    var whiteExp = /^\s+$/;
    if(variable==="" || variable===null || variable.length===0 || !variable.search(whiteExp)){
        showQuitMsg(msg);
        return false;
    }
    return true;
}
function showQuitMsg(msg){
    $('#server_answer').html(msg);
    $('#server_answer').addClass('div-red');
    $('#btn-lot').attr("disabled",true);
    setTimeout(() => {
        $('#server_answer').html("");
        $('#server_answer').removeClass('div-red');
        $('#btn-lot').attr("disabled",false);
    }, 5000);
}
$('#form_properties').on('submit',function(e){
    e.preventDefault();
    var postData = lote_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_lot.php',
            data: postData,
            success: function(result){
                if(result==="back-error"){
                    window.location = "../pages/error.html";
                }else{
                    $('#server_answer').html(result);
                    if(result.indexOf("Error")!==-1 || result.indexOf("Falló")!==-1){
                        $('#server_answer').addClass('div-red');
                        $('#btn-lot').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-red');
                        $('#btn-lot').attr("disabled",false);
                        }, 5000);
                    }else{
                        $('#server_answer').addClass('div-green');
                        $('#btn-lot').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-green');
                        $('#btn-lot').attr("disabled",false);
                        }, 5000);
                    }
                }
            },
            error: function(){
                alert("No se puede registrar el Lote. Consulte al Administrador");
            }
        });
    }
});
