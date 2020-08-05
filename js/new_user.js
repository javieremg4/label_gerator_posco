//event: modificar la navegación con tab al cargar la página
window.onload = function(){
    document.getElementById('user').tabIndex = 1;
    document.getElementById('pass').tabIndex = 2;
    document.getElementById('confirm').tabIndex = 3;
    document.getElementById('email').tabIndex = 4;
    document.getElementById('tuser').tabIndex = 5;
    document.getElementById('btn-login').tabIndex = 6;
    document.getElementById('clean_all').tabIndex = 7;
    inputFocus();
}
//***
//function: validar el tipo y las contraseñas
const userExp = /^[a-zA-Z\d]+([\s._-]?[a-zA-Z\d]+)*$/
const passExp = /^[\w\s!"#$%&'()*+,\-./\\:;<=>?@[\]^`{|}~]{3,50}$/;
const emailExp = /^\w+([\.\+\w-]?\w+)*@\w+([\.-]?\w+)*(\.\w+)/;
function validate_type(){
    let user = $('#user').val();
    let pass = $('#pass').val();
    /*Validación nombre de usuario*/
    if(user.length<3 || user.length>50){ // Longitud
        showQuitMsg('server_answer','btn-login',"Usuario: Min. 3 caracteres y Max. 50");
        return false;
    }
    if(!userExp.test(user) || /^\d+$/.test(user)){ // Contenido (valores aceptados)
        showQuitMsg('server_answer','btn-login',"Usuario: valor inválido");
        return false;
    }
    if(!/[a-zA-Z]/.test(pass)){
        showQuitMsg('server_answer','btn-login',"Contraseña: debe incluir una letra");
        return false;
    }
    if(pass.length<3 || pass.length>50){
        showQuitMsg('server_answer','btn-login',"Contraseña: Min. 3 caracteres y Max. 50");
        return false;
    }
    if(!passExp.test(pass)){
        showQuitMsg('server_answer','btn-login',"Contraseña: valor inválido");
        return false;
    }
    if(!/\d/.test(pass)){
        showQuitMsg('server_answer','btn-login',"Contraseña: debe incluir un número");
        return false;
    }
    if(!/[!"#$%&'()*+,\-./\\:;<=>?@[\]^`_{|}~]/.test(pass)){
        quitMsgEvent('server_answer',"Contraseña: debe incluir un caracter especial <br> ! \" # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _` { | } ~",'div-red');
        return false;
    }
    if($('#confirm').val() !== pass){
        showQuitMsg('server_answer','btn-login',"Las contraseñas no coinciden");
        return false;
    }
    var email = $('#email').val();
    if(email==="" || email===null || email.length===0 || /^\s+$/.test(email)){
        showQuitMsg('server_answer','btn-login',"Correo: obligatorio");
        return false;
    }
    if(email.length>50){
        showQuitMsg('server_answer','btn-login',"Correo: Máx. 50 caracteres");
        return false;
    }
    if(!emailExp.test(email)){
        showQuitMsg('server_answer','btn-login',"Correo: formato inválido");
        return false;
    }
    let usert = document.getElementsByName('type')[0];
    let admin = document.getElementsByName('type')[1];
    if(!usert.checked && !admin.checked){
        showQuitMsg('server_answer','btn-login',"Tipo: obligatorio");
        return false;
    }
    if(admin.checked){
        return "&email="+email+"&type=1";
    }else{  
        return "&email="+email+"&type=0";
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
                $('#new_user_form')[0].reset();
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
