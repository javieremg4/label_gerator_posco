//event: modificar la navegación con tab al cargar la página
window.onload = function(){
    document.getElementById('user').tabIndex = 1;
    document.getElementById('pass').tabIndex = 2;
    document.getElementById('confirm').tabIndex = 3;
    document.getElementById('tuser').tabIndex = 4;
    document.getElementById('btn-login').tabIndex = 5;
    document.getElementById('clean_all').tabIndex = 6;
    inputFocus();
}
//***
//function: validar el tipo y las contraseñas
function validate_type(){
    if(!/[a-zA-Z]/.test($('#pass').val())){
        showQuitMsg('server_answer','btn-login',"Contraseña: debe incluir una letra");
        return false;
    }
    if(!/\d/.test($('#pass').val())){
        showQuitMsg('server_answer','btn-login',"Contraseña: debe incluir un número");
        return false;
    }
    if($('#confirm').val() !== $('#pass').val()){
        showQuitMsg('server_answer','btn-login',"Las contraseñas no coinciden");
        return false;
    }
    var user = document.getElementsByName('type')[0];
    var admin = document.getElementsByName('type')[1];
    if(!user.checked && !admin.checked){
        showQuitMsg('server_answer','btn-login',"Tipo: obligatorio");
        return false;
    }
    if(admin.checked){
        return "&type=1";
    }else{  
        return "&type=0";
    }
}
//***
//event: limpiar el formulario y el mensaje
$('#clean_all').on("click",function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    $('#new_user_form')[0].reset();
});
//***
//event: subir el formulario (registrar el usuario)
$('#new_user_form').on('submit',function(event){
    event.preventDefault();
    cleanMsg('server_answer');
    var postData = login_review();
    if(!postData){ return false; }
    var type = validate_type(postData);
    if(!type){ return false; }
    postData += type;
    $.ajax({
        type: 'POST',
        data: postData,
        url: '../server/tasks/set_user.php',
        dataType: 'json',
        beforeSend: function(){
            $('#btn-login').attr("disabled",true);
            $('#clean_all').attr("disabled",true);
        },
        success: function(data){
            if(data.status==="OK" && data.message){
                quitMsgEvent('server_answer',data.message,'div-green');
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('server_answer',data.message,'div-red');
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            quitMsgEvent('server_answer',"No se puede registrar el Usuario",'div-red');
        },
        complete: function(){
            $('#btn-login').attr("disabled",false);
            $('#clean_all').attr("disabled",false);
        }
    })
});
//***
