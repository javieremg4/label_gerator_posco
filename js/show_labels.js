//event: al cargar la página se consultan 10 etiquetas
window.onload = function(){
    $.ajax({
        type: 'POST',
        url: '../server/tasks/view_labels.php',
        data: 'n=10',
        dataType: 'json',
        success: function(data){
            console.log(data);
            if((data.status==="OK" && data.content)){
                $('#label-panel').html(data.content);
            }else if(data.status==="ERR" && data.message){
                $('#label-panel').html(data.message);
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(data){
            console.log(data);
            $('#label-panel').html("Seleccione una fecha");
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
        success: function(data){
            console.log(data);
            if((data.status==="OK" && data.content)){
                $('#label-panel').html(data.content);
            }else if(data.status==="ERR" && data.message){
                $('#label-panel').html(data.message);
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(data){
            console.log(data);
            $('#label-panel').html("No se pudieron consultar las etiquetas consulte al Administrador");
        }
    });
});
//***
