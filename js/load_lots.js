function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.csv)$/i;
    if(fileInput.files.length>0){
        if(!allowedExtensions.exec(filePath)){
            showQuitMsg('Archivo: sólo extensión .csv');
            fileInput.value = '';
            return false;
        }
        return true;
    }
    showQuitMsg('Archivo: obligatorio')
    return false;
}

$('#file').on("change",function(){
    fileValidation();
});

$('#clean_all').on("click",function(e){
    e.preventDefault();
    clean();
});

function clean(){
    $('#file').val("");
    $('#server_answer').html("");

}

function showQuitMsg(msg){
    $('#validation-msg').html(msg);
    $('#validation-msg').addClass('div-red');
    $('#btn-submit').attr("disabled",true);
    setTimeout(() => {
        $('#validation-msg').html("");
        $('#validation-msg').removeClass('div-red');
        $('#btn-submit').attr("disabled",false);
    }, 5000);
}

$('#form_load_lots').on("submit",function(e){
    e.preventDefault();
    if(!fileValidation()){ return false; }
    var formData = new FormData(document.getElementById('form_load_lots'));
    $.ajax({
        url: '../server/tasks/consult_csv.php',
        type: 'post',
        data: formData,
        dataType: 'html',
        cache: false,
        contentType: false,
        processData: false,
        success: function(result){
            if(result==="back-error"){
                window.location = "../pages/error.html";
            }else{
                $('#server_answer').html(result);
                result=$('#server_answer').html();
                if($('#send').length){
                    $('#send').on("click",function(){
                        if($('#server_answer').html()==result){
                            insert_lot();
                        }else{
                            showQuitMsg('No se pudieron subir los Lotes. Inténtelo de nuevo');
                        }
                    });
                }
            }
        },
        error: function(){
            alert("No se pudo consultar el archivo. Inténtelo de nuevo");
            clean();
        }
    });
});

function insert_lot(){
    var table = document.getElementById("table_lots");
    var lotsArray = new Array();
    for (let i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        var lot = new Array();
        for (let j = 1; j < row.cells.length; j++) {
            lot[j-1] = row.cells[j].innerText;
        }
        lotsArray[i-1] = lot;
    }
    $.ajax({
        url: '../server/tasks/add_lots.php',
        type: 'post',
        data: "lots_array="+JSON.stringify(lotsArray),
        success: function(result){
            if(result==="back-error"){
                    window.location = "../pages/error.html";
            }else{
                $('#server_answer').html(result);
            }
        },
        error: function(){
            alert("No se pudieron registrar los Lotes. Consulte al Administrador");
        }
    });
}
