//function: revisar usuario y contraseña del input
    function login_review(){
        var user = $('#user').val();
        var whiteExp = /^\s+$/;
        var alphanumeric = /^[a-zA-Z\d]*$/;
        if(user==="" || user===null || user.length===0 || user.search(whiteExp)!==-1){
            alert("Usuario: obligatorio");
            return false;
        }
        if(user.length > 15){
            alert("Usuario: Max. 15 caracteres");
            return false;
        }
        if(user.search(alphanumeric)===-1){
            alert("Usuario: valor invalido");
            return false;
        }
        var pass = $('#pass').val();
        if(pass==="" || pass===null || pass.length===0){
            alert("Contraseña: obligatoria");
            return false;
        }
        if(pass.length<6 || pass.length>15){
            alert("Contraseña: Min. 6 caracteres y Max. 15");
            return false;
        }
        if(pass.search(alphanumeric)===-1 || !/[a-zA-Z]/.test(pass) || !/\d/.test(pass)){
            alert("Contraseña: valor invalido");
            return false;
        }
        return "user="+user+"&pass="+pass;
    }
//***
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
                    window.location = '../pages/menu_user.html';
                }else if(result==="admin"){
                    window.location = '../pages/menu_admin.html';
                }else{
                    $('#server_answer').html(result);
                }
            }
        })
    }
});
//***
