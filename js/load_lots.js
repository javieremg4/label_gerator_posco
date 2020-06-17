//function: revisar la extensión del archivo cargado
function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.csv)$/i;
    if(!allowedExtensions.exec(filePath)){
        showQuitMsg('validation-msg','btn-submit','Archivo: sólo extensión .csv');
        fileInput.value = '';
        return false;
    }
    return true;
}
//***
//event: validar cada vez que se cambia el archivo
$('#file').on("change",function(){
    fileValidation();
});
//***
//event: limpiar el input y el div con los datos
$('#clean_all').on("click",function(e){
    e.preventDefault();
    cleanMsg('validation-msg');
    $('#file').val("");
    $('#server_answer').html("");
});
//***
//event: enviar el formulario (consultar información del archivo)
$('#form_load_lots').on("submit",function(e){
    e.preventDefault();
    cleanMsg('validation-msg');
    $('#server_answer').html("");
    var fileInput = document.getElementById('file');
    if(fileInput.files.length <= 0){ showQuitMsg('validation-msg','btn-submit',"Archivo: obligatorio"); return false; }
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
                if(result.indexOf("||")!==-1){
                    var array = result.split("||");
                    quitMsgEvent('validation-msg',array[0],'div-red');
                    result = array[1];
                }
                $('#server_answer').html(result);
                result=$('#server_answer').html();
                if($('#send').length){
                    $('#send').on("click",function(){
                        if($('#server_answer').html()==result){
                            insert_lot();
                        }else{
                            quitMsgEvent('validation-msg','No se pudieron subir los datos. Inténtelo de nuevo','div-red');
                        }
                    });
                }
            }
        },
        error: function(){
            quitMsgEvent('validation-msg',"No se pudo consultar el archivo. Inténtelo de nuevo",'div-red');
            $('#file').val("");
            $('#server_answer').html("");
        }
    });
});
//***
//function: enviar los lotes del archivo para insertarlos
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
        dataType: 'json',
        success: function(data){
            if(data.status==="OK" && data.content){
                $('#server_answer').html(data.content);
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('validation-msg',data.message,'div-red');
            }else{
                window.location = "../pages/index.php";
            }
        },
        error: function(){
            quitMsgEvent('validation-msg',"No se pudieron registrar los datos. Consulte al Administrador",'div-red');
        }
    });
}
//***
