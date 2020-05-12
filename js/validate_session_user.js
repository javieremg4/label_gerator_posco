$.ajax({
    type: 'GET',
    data: null,
    url: '../server/tasks/session_validate.php',
    success: function(result){
        if(result==="admin"){
            window.location = "../pages/menu_admin.html"
        }
        if(result==="false"){
            window.location = "../pages/login.html";
        }
    }
});
