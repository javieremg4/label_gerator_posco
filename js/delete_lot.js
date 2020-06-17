//event: hacer focus al primer input al cargar el documento
window.onload = function(){
    inputFocus();
}
//***
//event: asignar el foco al primer input al cargar la página
$('#eliminar-lote').on('keyup',function(event){
    if($('#eliminar-lote').val()!==''){
        if(!$('#eliminar-lote').val().search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#eliminar-lote').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'eliminar-lote','sug-lote');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-lote').width($('#eliminar-lote').width());
            //***
            $('#sug-lote').html('Sin sugerencias');
            $('#sug-lote').addClass('sug-lote');
        }
    }else{
        cleanList('sug-lote');
        $('#datos-lote').html("");
    }
});
//***
//event: detectar «click» en la página
$('html').on('click',function(){
    cleanList('sug-lote');
});
//***
//event: perder el foco de un elemento
$('#eliminar-lote').on('blur',function(event){
    document.getElementById('eliminar-lote').focus();
});
//***
//code: evitar que se envie el formulario al dar enter
$('#form_delete_lot').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//function: limpiar el input y el div con los datos
function clean_data(){
    cleanMsg('server_answer');
    $('#datos-lote').html("");
    $('#eliminar-lote').val("");
}
//***
//event: enviar formulario (eliminar el lote)
$('#form_delete_lot').on("submit",function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    var msg = "Los datos del No. "+nlot_g+" no se podrán recuperar"+"\n¿Desea continuar?";
    msg = confirm(msg);
    if(!msg){ return false; }
    $.ajax({
        type: 'POST',
        data: 'no-lote='+nlot_g,
        url: '../server/tasks/remove_lot.php',
        dataType: 'json',
        success: function(data){
            if(data.status==="OK" && data.message){
                quitMsgEvent('server_answer',data.message,'div-green');
                $('#datos-lote').html("");
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('server_answer',data.message,'div-red');
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            quitMsgEvent('server_answer',"No se pudieron eliminar los datos. Consulte al Administrador",'div-red');
        }
    })
});
//***
