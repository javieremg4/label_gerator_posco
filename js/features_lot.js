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
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    cleanList('sug-lote');
});
//***
//code: perder el foco de un elemento
$('#buscar-lote').on('blur',function(event){
    document.getElementById('buscar-lote').focus();
});
//***
//code: evitar que se envie el formulario al dar enter
$('#form_lot').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//function: limpiar el input el div con los datos
function clean_data(){
    $('#datos-lote').html("");
    document.getElementById('buscar-lote').value = "";
    document.getElementById('buscar-lote').disabled = false;
}
//***
//code: enviar la info al servidor
$('#form_lot').on('submit',function(event){
    event.preventDefault();
    var postData = lote_review();

    //Validación del no. de lote
    if(nlot_g!==$('#lot').val()){
        var msg = "¿Desea cambiar el No. Lote: "+nlot_g+" por "+$('#lot').val()+"?\n"
                    +"Las etiquetas generadas con el No. Lote anterior no se modificarán";
        msg = confirm(msg);
        if(!msg){ return false; }
    }
    //***

    if(postData !== false){
        postData += "&no-lote="+document.getElementById('buscar-lote').value;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_lote.php',
            data: postData,
            success: function(result){
                $('#server_answer').html(result);
                if(result.indexOf("Error")!==-1 || result.indexOf("Falló")!==-1){
                    $('#server_answer').addClass('div-red');
                    $('#btn-lot').attr("disabled",true);
                    setTimeout(() => {
                    $('#server_answer').html("");
                    $('#server_answer').removeClass('div-red');
                    $('#btn-lot').attr("disabled",false);
                    }, 7000);
                }else{
                    $('#server_answer').addClass('div-green');
                    clean_data();
                    setTimeout(() => {
                    $('#server_answer').html("");
                    $('#server_answer').removeClass('div-green');
                    }, 7000);
                }
            },
            error: function(){
                alert("No se pudo actualizar el Lote. Consulte al Administrador");
            }
        });
    }
});
//***
