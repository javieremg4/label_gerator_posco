function validate_type(){
    if($('#confirm').val() !== $('#pass').val()){
        showQuitMsg("La contraseña no coincide");
        return false;
    }
    var user = document.getElementsByName('type')[0];
    var admin = document.getElementsByName('type')[1];
    if(!user.checked && !admin.checked){
        showQuitMsg("Tipo: obligatorio");
        return false;
    }
    if(admin.checked){
        return "&type=1";
    }else{
        return "&type=0";
    }
}
$('#new_user_form').on('submit',function(event){
    event.preventDefault();
    var postData = login_review();
    if(!postData){ return false; }
    var type = validate_type(postData);
    if(!type){ return false; }
    postData += type;
    $.ajax({
        type: 'POST',
        data: postData,
        url: "../server/tasks/set_user.php",
        success: function(result){
            if(result==="back-error"){
                window.location = "../pages/error.html";
            }else{
                $('#server_answer').html(result);
                if(result === "Usuario registrado con éxito"){
                        $('#server_answer').addClass('div-green');
                        $('#new_user_form')[0].reset();
                        $('#btn-login').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-green');
                        $('#btn-login').attr("disabled",false);
                        }, 5000);
                    }else{
                        $('#server_answer').addClass('div-red');
                        $('#btn-login').attr("disabled",true);
                        setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-red');
                        $('#btn-login').attr("disabled",false);
                        }, 5000);
                    }
            }
        },
        error: function(){
            alert("No se puede registrar el Usuario. Revise el archivo: new_user.js");
        }
    })
});
