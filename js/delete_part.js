//code: asignacion de la lista a los input
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
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    cleanList('sug-part');
});
//***
//code: perder el foco de un elemento
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
    $('#datos-parte').html("");
    $('#eliminar-parte').val("");
}
//***
function showQuitMsg(msg,color){
    $('#server_answer').html(msg);
    $('#server_answer').addClass(color);
    $('#btn-submit').attr("disabled",true);
    setTimeout(() => {
        $('#server_answer').html("");
        $('#server_answer').removeClass(color);
        $('#btn-submit').attr("disabled",false);
    }, 5000);
}
//code: enviar la info al servidor
$('#form_delete_part').on('submit',function(e){
    e.preventDefault();
    //Mensaje de confirmación antes de "eliminar" la parte
    var msg = "Los datos de la parte No. "+npart_g+" no se podrán recuperar"+"\n¿Desea continuar?";
    msg = confirm(msg);
    if(!msg){ return false; }
    //***
    $.ajax({
        type: 'POST',
        data: 'no-parte='+npart_g,
        url: '../server/tasks/remove_part.php',
        success: function(result){
            if(result==="back-error"){
                window.location = "../pages/error.html";
            }else{
                if(result.indexOf("Error:")!==-1 || result.indexOf("Falló")!==-1){
                    showQuitMsg(result,'div-red');
                }else{
                    showQuitMsg(result,'div-green');
                    clean_data();
                }
            }
        },
        error: function(){
            alert("No se pudo eliminar la Parte. Consulte al Administrador");
        }
    })
});

