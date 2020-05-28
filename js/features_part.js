//code: se agrega la lista al input
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
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
    }
});
//***
//code: perder el foco de un elemento
$('#buscar-parte').on('blur',function(event){
    if(document.getElementById('sug-part').hasChildNodes()){
        document.getElementById('buscar-parte').focus();
        //$('#buscar-parte').focus();
    }
});
//***
//code: evitar que se envie el formulario al dar enter
$('#form_features_part').on('keypress',function(event){
    var code = event.which || event.keyCode;
    if(code===13){
        return false;
    }
});
//***
//function: limpiar el input y el div con los datos
function clean_data(){
    $('#datos-parte').html("");
    $('#buscar-parte').val("");
}
//***
//code: enviar la info al servidor
$('#form_features_part').on('submit',function(event){
    event.preventDefault();
    var postData = part_review();
    if(postData !== false){

        //Validación del no. de parte
        if(npart_g!==$('#no-parte').val()){
            var msg = "¿Desea cambiar el No. Parte: "+npart_g+" por "+$('#no-parte').val()+"?\n"
                      +"Las etiquetas generadas con el No. Parte anterior se modificarán";
            msg = confirm(msg);
            if(!msg){ return false; }
        }
        //***

        postData += "&parte="+npart_g;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_part.php',
            data: postData,
            success: function(result){
                $('#server_answer').html(result);
                if(result.indexOf("Error")!==-1 || result.indexOf("Falló")!==-1){
                    $('#server_answer').addClass('div-red');
                    $('#btn-part').attr("disabled",true);
                    setTimeout(() => {
                    $('#server_answer').html("");
                    $('#server_answer').removeClass('div-red');
                    $('#btn-part').attr("disabled",false);
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
                alert("No se pudo actualizar la Parte. Consulte al Administrador");
            }
        });
    }
});
//***
