window.onload = function(){
    $.ajax({
        type: 'POST',
        url: '../server/tasks/view_labels.php',
        data: 'n=10',
        success: function(result){
            $('#label-panel').html(result);
        },
        error: function(){
            $('#label-panel').html("Seleccione una fecha");
        }
    });
}
function showQuitMsg(msg){
    $('#val-msg').html(msg);
    $('#val-msg').addClass('div-red');
    setTimeout(() => {
        $('#val-msg').html("");
        $('#val-msg').removeClass('div-red');
    }, 5000);
}
$('#form_show_labels').on("submit",function(e){
    e.preventDefault();
    if($('#date-consult').val()===null || $('#date-consult').val()===""){
        showQuitMsg("Fecha: obligatorio");
        return false;
    }
    if(!validarFormatoFecha($('#date-consult').val())){
        showQuitMsg("Fecha: formato inválido");
        return false;
    }
    if(!existeFecha($('#date-consult').val())){
        showQuitMsg("Fecha: valor inválido");
        return false;
    }
    $.ajax({
        method: "POST",
        data: "date="+$('#date-consult').val(),
        url: "../server/tasks/view_labels.php",
        success: function(result){
            if(result==="back-error"){
                window.location = "../pages/error.html";
            }else{
                $('#label-panel').html(result);
            }
        },
        error: function(){
            $('#label-panel').html("No se pudieron consultar las etiquetas consulte al Administrador");
        }
    });
});
