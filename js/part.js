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
function part_review(){

    var no_parte = document.getElementById('no-parte').value;
    if(!white_review(no_parte,"No. parte: obligatorio")){ return false; }
    if(!char_limit(no_parte,13,"No. parte: Max. 13 caracteres")){ return false; }
    var alphanumeric = /^([a-zA-Z\d]|[a-zA-Z\d]\-)*[a-zA-Z\d]$/;
    if(no_parte.search(alphanumeric)){
        showQuitMsg("No. parte: valor inválido (solo alfanumerico)");
        return false;
    }

    var desc = document.getElementById('desc').value;
    if(!white_review(desc,"Descripción: obligatorio")){ return false; }
    if(!char_limit(desc,50,"Descripción: Max. 50 caracteres")){ return false; }
    if(!/^[^'"<>&]*$/.test(desc)){ showQuitMsg("Descripción: valor inválido"); return false; }

    var esp = document.getElementById('esp').value;
    if(!white_review(esp,"Especificación: obligatorio")){ return false; }
    if(!char_limit(esp,15,"Especificación: Max. 15 caracteres")){ return false; }
    if(esp.search(alphanumeric)){
        showQuitMsg("Especificación: valor inválido (solo alfanumerico)");
        return false;
    }

    var kgpc = document.getElementById('kgpc').value;
    if(!white_review(kgpc,"Kg./Pc: obligatorio")){ return false; }
    if(parseFloat(kgpc)===0){
        showQuitMsg("Kg./Pc: obligatorio");
        return false;
    }
    var expDecimal = /^(\d+|\d*.\d+)$/
    if(kgpc.search(expDecimal)){
        showQuitMsg("Kg./Pc: valor inválido");
        return false;
    }
    if(kgpc>9999.99){
        showQuitMsg("Kg./Pc: valor máximo 9999.99");
        return false;
    }

    var snppz = document.getElementById('snppz').value;
    if(snppz<1){
        showQuitMsg("SNP PZ: valor inválido");
        return false;
    }
    if(snppz.length>4){
        showQuitMsg("SNP PZ: Max. 4 caracteres");
        return false;
    }
    
    return "no-parte="+no_parte+"&desc="+desc+"&esp="+esp+"&kgpc="+kgpc+"&snppz="+snppz;
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
    $('#btn-part').attr("disabled",true);
    setTimeout(() => {
        $('#server_answer').html("");
        $('#server_answer').removeClass('div-red');
        $('#btn-part').attr("disabled",false);
    }, 5000);
}
$('#form_part').on('submit',function(e){
    e.preventDefault();
    var postData = part_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_part.php',
            data: postData,
            success: function(result){
                if(result==="back-error"){
                    window.location = "../pages/error.html";
                }else{
                    $('#server_answer').html(result);
                    if(result.indexOf("Error")!==-1 || result.indexOf("Falló")!==-1){
                        $('#server_answer').addClass('div-red');
                        $('#btn-part').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-red');
                        $('#btn-part').attr("disabled",false);
                        }, 5000);
                    }else{
                        $('#server_answer').addClass('div-green');
                        $('#btn-part').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-green');
                        $('#btn-part').attr("disabled",false);
                        }, 5000);
                    }
                }
            },error: function(){
                alert("No se puede registrar la Parte. Consulte al Administrador");
            }
        });
    }
});
