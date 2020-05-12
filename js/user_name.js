$.ajax({
    type: 'GET',
    data: null,
    url: "../server/tasks/get_user_name.php",
    success: function(result){
        $('#user_name').html(result);
    }
});
