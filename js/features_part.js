//event: poner el foco al primer input al cargar la pagina
window.onload = function(){
    inputFocus();
}
//***
//event: asignar la lista al input al teclear
$('#buscar-parte').on('keyup',function(event){
    if($('#buscar-parte').val()!==''){
        if(!$('#buscar-parte').val().search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*$/) && $('#buscar-parte').val()!=='0'){
            var code = event.which || event.keyCode;
            suggest_list(code,'buscar-parte','sug-part');
        }else{
            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
            $('#sug-part').width($('#buscar-parte').width());
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
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
    }
});
//***
//event: perder el foco del input con las listas desplegables
$('#buscar-parte').on('blur',function(event){
    if(document.getElementById('sug-part').hasChildNodes()){
        document.getElementById('buscar-parte').focus();
    }
});
//***
//event: evitar que se envie el formulario al dar enter
$('#form_features_part').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//function: limpiar el input y el div con los datos
function clean_data(){
    cleanMsg('server_answer');
    $('#buscar-parte').val("");
    $('#datos-parte').html("");
}
//***
//event: enviar el formulario (actualizar la parte)
$('#form_features_part').on('submit',function(event){
    event.preventDefault();
    cleanMsg('server_answer');
    var postData = part_review();
    if(postData !== false){
        var msg = "¿Desea cambiar los datos de la parte No. "+npart_g+"?\n"
                  +"Si hay etiquetas registradas, se modificarán";
        var no_parte = document.getElementById('no-parte').value.toUpperCase();
        if(npart_g!==no_parte){
            msg = "¿Desea cambiar el No. Parte: "+npart_g+" por "+no_parte+"?\n"
                      +"Las etiquetas generadas con el No. Parte anterior se modificarán";
        }
        msg = confirm(msg);
        if(!msg){ return false; }
        postData += "&parte="+npart_g;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_part.php',
            data: postData,
            dataType: 'json',
            beforeSend: function(){ 
                $('#btn-part').attr("disabled",true);
                $('#btn-cancel').attr("disabled",true);
            },
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
                quitMsgEvent('server_answer',"No se pudo actualizar la Parte. Consulte al Administrador",'div-red');
            },
            complete: function(){ 
                $('#btn-part').attr("disabled",false);
                $('#btn-cancel').attr("disabled",false);
            }
        });
    }
});
//***
