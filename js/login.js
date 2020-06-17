//function: revisa usuario y contraseña del input
    function login_review(){
        var user = $('#user').val();
        var whiteExp = /^\s+$/;
        var alphanumeric = /^[a-zA-Z\d]*$/;
        if(user==="" || user===null || user.length===0 || user.search(whiteExp)!==-1){
            showQuitMsg('server_answer','btn-login',"Usuario: obligatorio");
            return false;
        }
        if(user.length<3 || user.length>15){
            showQuitMsg('server_answer','btn-login',"Usuario: Min. 3 caracteres y Max. 15");
            return false;
        }
        if(user.search(alphanumeric)===-1){
            showQuitMsg('server_answer','btn-login',"Usuario: valor inválido (sólo alfanumérico)");
            return false;
        }
        var pass = $('#pass').val();
        if(pass==="" || pass===null || pass.length===0){
            showQuitMsg('server_answer','btn-login',"Contraseña: obligatoria");
            return false;
        }
        if(pass.length<6 || pass.length>15){
            showQuitMsg('server_answer','btn-login',"Contraseña: Min. 6 caracteres y Max. 15");
            return false;
        }
        if(pass.search(alphanumeric)===-1 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)){
            showQuitMsg('server_answer','btn-login',"Contraseña: valor inválido");
            return false;
        }
        return "user="+user+"&pass="+pass;
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
            }
        });
    }
});
//***
