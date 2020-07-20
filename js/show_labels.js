//event: al cargar la página se consultan 10 etiquetas
window.onload = function(){
    $.ajax({
        type: 'POST',
        url: '../server/tasks/view_labels.php',
        data: "n=10",
        dataType: 'json',
        success: function(data){
            if((data.status==="OK" && data.content)){
                $('#label-panel').html(data.content);
            }else if(data.status==="ERR" && data.message){
                $('#label-panel').html(data.message);
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            $('#label-panel').html("Seleccione una fecha");
        },
        complete: function(){
            $('#date-consult').val("");
        }
    });
}
//***
//event: subir el formulario (consultar etiquetas por fecha)
$('#form_show_labels').on("submit",function(e){
    e.preventDefault();
    if($('#date-consult').val()===null || $('#date-consult').val()===""){
        showQuitMsg('val-msg',null,"Fecha: obligatorio");
        return false;
    }
    if(!dateFormat($('#date-consult').val())){
        showQuitMsg('val-msg',null,"Fecha: formato inválido");
        return false;
    }
    if(!dateExists($('#date-consult').val())){
        showQuitMsg('val-msg',null,"Fecha: valor inválido");
        return false;
    }
    $.ajax({
        method: "POST",
        data: "date="+$('#date-consult').val(),
        url: "../server/tasks/view_labels.php",
        dataType: "json",
        beforeSend: function(){ $('#btn-show').attr("disabled",true); },
        success: function(data){
            if((data.status==="OK" && data.content)){
                $('#label-panel').html(data.content);
            }else if(data.status==="ERR" && data.message){
                $('#label-panel').html(data.message);
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            $('#label-panel').html("No se pudieron consultar las etiquetas consulte al Administrador");
        },
        complete: function(){
            $('#btn-show').attr("disabled",false);
        }
    });
});
//***
