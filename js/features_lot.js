//event: poner el foco al primer input al cargar la pagina
window.onload = function(){
    inputFocus();
}
//***
//event: asignar la lista al input al teclear
$('#buscar-lote').on('keyup',function(event){
    if($('#buscar-lote').val()!==''){
        if(!$('#buscar-lote').val().search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#buscar-lote').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'buscar-lote','sug-lote');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-lote').width($('#buscar-lote').width());
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
//event: perder el foco del input con las listas desplegables
$('#buscar-lote').on('blur',function(event){
    if(document.getElementById('sug-lote').hasChildNodes()){
        document.getElementById('buscar-lote').focus();
    }
});
//***
//event: evitar que se envie el formulario al dar enter
$('#form_lot').on('keypress',function(event){
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
    $('#buscar-lote').val("");
}
//***
//event: enviar el formulario (actualizar el lote)
$('#form_lot').on('submit',function(event){
    event.preventDefault();
    cleanMsg('server_answer');
    var postData = lote_review();
    if(postData !== false){
        var no_lote = document.getElementById('lot').value.toUpperCase();
        if(nlot_g!==no_lote){
            var msg = "¿Desea cambiar el No. Inspección: "+nlot_g+" por "+no_lote+"?\n"
                        +"Las etiquetas generadas con el No. Inspección anterior se podrían modificar";
            msg = confirm(msg);
            if(!msg){ return false; }
        }
        postData += "&no-lote="+nlot_g;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_lot.php',
            data: postData,
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
                quitMsgEvent('server_answer',"No se pudieron actualizar los datos. Consulte al Administrador",'div-red');
            }
        });
    }
});
//***
