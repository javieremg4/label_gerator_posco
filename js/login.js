//function: revisa usuario y contraseña del input
function login_review(){
    var user = $('#user').val();
    if(user==="" || user===null || user.length===0 || /^\s+$/.test(user)){
        showQuitMsg('server_answer','btn-login',"Usuario: obligatorio");
        return false;
    }
    var pass = $('#pass').val();
    if(pass==="" || pass===null || pass.length===0){
        showQuitMsg('server_answer','btn-login',"Contraseña: obligatoria");
        return false;
    }
    return "user="+user+"&pass="+encodeURIComponent(pass);
}
//***
//event: subir el formulario (revisar credenciales y dar acceso)
$('#login_form').on('submit',function(event){
    event.preventDefault();
    cleanMsg('server_answer');
    var postData = login_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            data: postData,
            url: '../server/tasks/session_start.php',
            dataType: 'json',
            beforeSend: function(){ $('#btn-login').attr("disabled",true); },
            success: function(data){
                if(data.status==="OK" && data.location){
                    window.location = data.location;
                }else if(data.status==="ERR" && data.message){
                    quitMsgEvent('server_answer',data.message,'div-red');
                }else{
                    window.location = "error.html";
                }
            },
            error: function(){
                quitMsgEvent('server_answer',"No se puede iniciar sesión. Consulte al Administrador",'div-red');
            },
            complete: function(){ $('#btn-login').attr("disabled",false); }
        });
    }
});
//***
