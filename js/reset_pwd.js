const passExp = /^[\w\s!"#$%&'()*+,\-./\\:;<=>?@[\]^`{|}~]{3,32}$/;
function pwd_review(){
    var new_pwd = $('#new-pwd').val();
    var confirm = $('#confirm-pwd').val();
    if(new_pwd==="" || new_pwd===null || new_pwd.length===0){
        showQuitMsg('server_answer','btn-reset-pwd',"Nueva Contraseña: obligatoria");
        return false;
    }
    if(new_pwd.length<3 || new_pwd.length>50){
        showQuitMsg('server_answer','btn-reset-pwd',"Nueva Contraseña: Min. 3 caracteres y Max. 50");
        return false;
    }
    if(!/[a-zA-Z]/.test(new_pwd)){
        showQuitMsg('server_answer','btn-reset-pwd',"Contraseña: debe incluir una letra");
        return false;
    }
    if(!/\d/.test(new_pwd)){
        showQuitMsg('server_answer','btn-reset-pwd',"Contraseña: debe incluir un número");
        return false;
    }
    if(!/[!"#$%&'()*+,\-./\\:;<=>?@[\]^`_{|}~]/.test(new_pwd)){
        quitMsgEvent('server_answer',"Contraseña: debe incluir un caracter especial <br> ! \" # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \ ] ^ _` { | } ~",'div-red');
        return false;
    }
    if(!passExp.test(new_pwd)){
        showQuitMsg('server_answer','btn-reset-pwd',"Nueva Contraseña: valor inválido");
        return false;
    }
    if(new_pwd != confirm){ 
        showQuitMsg('server_answer','btn-reset-pwd',"Las contraseñas no coinciden");
        return false;
    }
    return "new-pwd="+encodeURIComponent(new_pwd);
}
