//function: crea el mensaje fijo
function quitMsgEvent(idElement,result,assignClass){
    if($('#'+idElement).length){
        cleanMsg(idElement);
        $('#'+idElement).html(result+"<label id='quit-msg'>&times</label>");
        $('#'+idElement).addClass(assignClass);
        $('#quit-msg').on('click',function(){
            $('#'+idElement).html("");
            $('#'+idElement).removeClass(assignClass);
        });
    }
}
//***
//function: limpia el mensaje fijo
function cleanMsg(idElement){
    if($('#'+idElement).hasClass('div-red')){
        $('#'+idElement).removeClass('div-red');
    }else if($('#'+idElement).hasClass('div-green')){
        $('#'+idElement).removeClass('div-green');
    }
    $('#'+idElement).html("");
}
//***
//function: da estilo al mensaje temporal y dehabilita el boton
function showQuitMsg(divId,btnId,msg){
    $('#'+divId).html(msg);
    $('#'+divId).addClass('div-red');
    $('#'+btnId).attr("disabled",true);
    setTimeout(() => {
        $('#'+divId).html("");
        $('#'+divId).removeClass('div-red');
        $('#'+btnId).attr("disabled",false);
    }, 5000);
}
//***
