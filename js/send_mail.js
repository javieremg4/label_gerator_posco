const emailExp = /^\w+([\.\+\w-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})/;
function to_review(){
    let to = $('#to-send').val();
    if(to==="" || to===null || to.length===0 || /^\s+$/.test(to)){
        showQuitMsg('server_answer','btn-to-send',"Ingrese un usuario o un correo");
        return false;
    }
    if(/^\w+([\.\+\w-]?\w+)*@\w+([\.-]?\w+)*(\.\w+)/.test(to)){
        return "mail="+to;
    }else if(/^[a-zA-Z\d]+([\s\.\_-]?[a-zA-Z\d]+)*$/.test(to)){
        return "user="+to;
    }else{
        showQuitMsg('server_answer','btn-to-send',"Ingresó un valor inválido. Intente de nuevo");
        return false;
    }
    return "to-send="+to;
    
}
$('#send_mail_form').on('submit',function(e){
    e.preventDefault();
    cleanMsg('server_answer');
    let to = to_review();
    if(!to){ return false; }
    $.ajax({
        type: 'post',
        data: to,
        url: '../server/tasks/consult_user.php',
        dataType: 'json',
        beforeSend: function(){ $('#btn-to-send').attr("disabled",true); },
        success: function(data){
            if(data.status==="OK" && data.email && data.message){
                sendMail(data.email,data.message);
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('server_answer',data.message,'div-red');
                $('#btn-to-send').attr("disabled",false)
            }else{
                quitMsgEvent('server_answer',"No se pudo consultar la información. Por favor, inténtelo de nuevo",'div-red');
                $('#btn-to-send').attr("disabled",false)
            }
        },
        error: function(){
            quitMsgEvent('server_answer',"No se pudo consultar la información. Por favor, inténtelo de nuevo",'div-red');
            $('#btn-to-send').attr("disabled",false)
        }
    });
});
function sendMail(to,body) {
    Email.send({
        SecureToken: "481704d3-e61b-4637-bdc6-2cccd0b0e7ad",
        From : "no.reply.label.generator@gmail.com",
        To : to,
        Subject : "Recuperar Contraseña (No contestar a este correo)",
        Body : body
    }).then(
      message => ansSend(message)  
    );
}
function ansSend(message){
    if(message=="OK"){
        quitMsgEvent('server_answer',"Se envió el mensaje. Revise su correo",'div-green')
    }else{
        quitMsgEvent('server_answer',"El mensaje no se envió. Inténtelo de nuevo",'div-red')
    }
    $('#btn-to-send').attr("disabled",false)
}
