function validate_type(){
    var user = document.getElementsByName('type')[0];
    var admin = document.getElementsByName('type')[1];
    if(!user.checked && !admin.checked){
        alert("Tipo: obligatorio");
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
            $('#server_answer').html(result);
        }
    })
});
