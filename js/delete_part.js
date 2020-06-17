//event: hacer focus al primer input al cargar el documento
window.onload = function(){
    inputFocus();
}
//***
//event: asignar la lista al input al teclear
$('#eliminar-parte').on('keyup',function(event){
    if($('#eliminar-parte').val()!==''){
        if(!document.getElementById('eliminar-parte').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#eliminar-parte').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'eliminar-parte','sug-part');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-part').width($('#eliminar-parte').width());
            //***
            $('#sug-part').html('Sin sugerencias');
            $('#sug-part').addClass('sug-part');
        }
    }else{
        cleanList('sug-part');
        $('#datos-parte').html("");
    }
});
//***
//event: detectar «click» en la página
$('html').on('click',function(){
    cleanList('sug-part');
});
//***
//event: perder el foco del input con las listas desplegables
$('#eliminar-parte').on('blur',function(event){
    if(document.getElementById('sug-part').hasChildNodes()){
        document.getElementById('eliminar-parte').focus();
    }
});
//***
//code: evitar que se envie el formulario al dar enter
$('#form_delete_part').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//function: limpiar el input y el div con los datos
function clean_data(){
    cleanMsg('server_answer');
    $('#datos-parte').html("");
    $('#eliminar-parte').val("");
}
//***
//event: enviar formulario (eliminar la parte)
$('#form_delete_part').on('submit',function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    var msg = "Los datos de la parte No. "+npart_g+" no se podrán recuperar"+"\n¿Desea continuar?";
    msg = confirm(msg);
    if(!msg){ return false; }
    $.ajax({
        type: 'POST',
        data: 'no-parte='+npart_g,
        url: '../server/tasks/remove_part.php',
        dataType: 'json',
        success: function(data){
            if(data.status==="OK" && data.message){
                quitMsgEvent('server_answer',data.message,'div-green');
                $('#datos-parte').html("");
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('server_answer',data.message,'div-red');
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            quitMsgEvent('server_answer',"No se pudo eliminar la Parte. Consulte al Administrador",'div-red');
        }
    })
});
//***
