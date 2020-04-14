$('#form_properties').on('submit',function(e){
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: '../server/tasks/set_properties.php',
        data: formData,
        success: function(result){
            $('#answer').html(result);
        }
    });
});
