$.ajax({
    type: 'GET',
    data: null,
    url: '../server/tasks/session_validate.php',
    success: function(result){
        if(result!=="admin"){
            window.location = "../pages/login.html";
        }
    }
})