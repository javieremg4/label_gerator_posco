$('#buscar-lote').on('keyup',function(event){
    if(!document.getElementById('buscar-lote').value.search(/^([a-zA-Z\d]|[a-zA-Z\d]\-)*[a-zA-Z\d]$/) && document.getElementById('buscar-lote').value!=='0'){
        var code = event.which || event.keyCode;
        suggest_list(code,'buscar-lote','sug-lote');
    }else{
        $('#sug-lote').html('Sin sugerencias');
        $('#sug-lote').addClass('sug-lote');
    }
});
//code: detectar «click» fuera de un elemento
$('html').on('click',function(){
    if(document.getElementById('sug-lote').hasChildNodes()){
        cleanList('sug-lote');
    }
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
    if(postData !== false){
        postData += "&no-lote="+document.getElementById('buscar-lote').value;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_lote.php',
            data: postData,
            success: function(result){
                $('#res-lote').html(result);
                clean_data();
            }
        });
    }
});
//***
