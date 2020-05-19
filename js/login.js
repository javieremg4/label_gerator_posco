//function: revisar usuario y contraseña del input
    function login_review(){
        var user = $('#user').val();
        var whiteExp = /^\s+$/;
        var alphanumeric = /^[a-zA-Z\d]*$/;
        if(user==="" || user===null || user.length===0 || user.search(whiteExp)!==-1){
            showQuitMsg("Usuario: obligatorio");
            return false;
        }
        if(user.length<3 || user.length>15){
            $('#server_answer').html("Usuario: Min. 3 caracteres y Max. 15");
            showQuitMsg();
            return false;
        }
        if(user.search(alphanumeric)===-1){
            showQuitMsg("Usuario: valor inválido");
            return false;
        }
        var pass = $('#pass').val();
        if(pass==="" || pass===null || pass.length===0){
            showQuitMsg("Contraseña: obligatoria");
            return false;
        }
        if(pass.length<6 || pass.length>15){
            showQuitMsg("Contraseña: Min. 6 caracteres y Max. 15");
            return false;
        }
        if(pass.search(alphanumeric)===-1 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)){
            showQuitMsg("Contraseña: valor inválido");
            return false;
        }
        return "user="+user+"&pass="+pass;
    }
//***
function showQuitMsg(msg){
    $('#server_answer').html(msg);
    $('#server_answer').addClass('div-red');
    $('#btn-login').attr("disabled",true);
    setTimeout(() => {
        $('#server_answer').html("");
        $('#server_answer').removeClass('div-red');
        $('#btn-login').attr("disabled",false);
    }, 5000);
}
//code: revisar usuario y contraseña en el servidor
$('#login_form').on('submit',function(event){
    event.preventDefault();
    var postData = login_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            data: postData,
            url: '../server/tasks/session_start.php',
            success: function(result){
                if(result==="user"){
                    window.location = '../pages/menu_user.php';
                }else if(result==="admin"){
                    window.location = '../pages/menu_admin.php';
                }else{
                    $('#server_answer').html(result);
                    $('#btn-login').attr("disabled",true);
                    $('#server_answer').addClass('div-red');
                    setTimeout(() => {
                        $('#server_answer').html("");
                        $('#server_answer').removeClass('div-red');
                        $('#btn-login').attr("disabled",false);
                    }, 5000);
                }
            },
            error: function(){
                alert("No se puede iniciar sesión. Consulte al Administrador");
            }
        })
    }
});
//***
