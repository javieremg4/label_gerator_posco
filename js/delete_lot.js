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
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    cleanList('sug-lote');
});
//***
//code: perder el foco de un elemento
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
//function: limpiar el input el div con los datos
function clean_data(){
    $('#datos-lote').html("");
    $('#eliminar-lote').val("");
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
$('#form_delete_lot').on("submit",function(e){
    e.preventDefault();
    //Mensaje de confirmación antes de "eliminar" el lote
    var msg = "Los datos del Lote No. "+nlot_g+" no se podrán recuperar"+"\n¿Desea continuar?";
    msg = confirm(msg);
    if(!msg){ return false; }
    //***
    $.ajax({
        type: 'POST',
        data: 'no-lote='+nlot_g,
        url: '../server/tasks/remove_lot.php',
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
            alert("No se pudo eliminar el Lote. Consulte al Administrador");
        }
    })
});
