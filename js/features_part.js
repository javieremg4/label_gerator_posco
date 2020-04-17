//code: se agrega la lista al input
$('#buscar-parte').on('keyup',function(event){
    var code = event.which || event.keyCode;
    suggest_list(code,'buscar-parte','sug-part');
});
//***
//jQuery: detectar «click» fuera de un elemento
$('html').on('click',function(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList('sug-part');
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
//function: limpiar el input el div con los datos
function clean_data(){
    $('#datos-parte').html("");
    document.getElementById('buscar-parte').value = "";
    document.getElementById('buscar-parte').disabled = false;
}
//***
//code: enviar la info al servidor
$('#form_features_part').on('submit',function(event){
    event.preventDefault();
    var postData = part_review();
    if(postData !== false){
        postData += "&parte="+document.getElementById('buscar-parte').value;
        $.ajax({
            type: 'post',
            url: '../server/tasks/change_part.php',
            data: postData,
            success: function(result){
                $('#res-parte').html(result);
                clean_data();
            }
        });
    }
});
//***
