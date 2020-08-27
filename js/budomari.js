//function: revisar la extensión del archivo cargado
function fileValidation(){
    var fileInput = document.getElementById('file-862');
    var filePath = fileInput.value;
    var allowedExtensions = /(.txt)$/i;
    if(!allowedExtensions.exec(filePath)){
        showQuitMsg('server_answer','btn-submit','Archivo: sólo extensión .txt');
        fileInput.value = '';
        return false;
    }
    return true;
}
//***
//event: validar cada vez que se cambia el archivo
$('#file-862').change(
    function(){
        fileValidation();
    }
);
//***
$('#clean-all').click(
    function(e){
        e.preventDefault();
        cleanMsg('server_answer');
        $('#file-862').val("");
        $('#pdfFrame').attr('src',"");
    }
);
$('#load-file').submit(function(e){
    e.preventDefault();
    let fileInput = document.getElementById('file-862');
    if(fileInput.files.length <= 0){ showQuitMsg('server_answer','btn-submit',"Archivo: obligatorio"); return false; }
    if(!fileValidation()){ return false; }
    let call = $.ajax({
        type: 'post',
        url: '../server/tasks/edi_review.php',
        data: new FormData(document.getElementById('load-file')),
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function(){
            cleanMsg('server_answer');
            $('#clean-all').hide();
            $('#btn-submit').val("Espere...");
            $('#pdfFrame').attr('src',"");
            $('#btn-submit').attr('disabled',true);
        }
    });
    call.done(
        function(data){
            if(data.status==="OK" && Array.isArray(data.labels) && Array.isArray(data.codes) && (data.labels.length===data.codes.length)){ 
                doFile(data.labels,data.codes);         
            }else if(data.status==="ERR" && data.message){
                quitMsgEvent('server_answer',data.message,'div-red');
            }else{
                window.location = "../pages/index.php";
            }
        }
    );
    call.fail(
        function(){
            quitMsgEvent('server_answer',"Por favor, presione Limpiar y seleccione el archivo de nuevo",'div-red');
            console.log("ajax fail!");
        }
    );
    call.always(
        function(data){ 
            console.log(data);
            $('#btn-submit').val("Generar");
            $('#btn-submit').attr('disabled',false);
            $('#clean-all').show();
        }
    );
});

let label;
let date;
function doFile(groupLbls,codesArray){
    let doc = new jsPDF('l', 'mm', 'letter');
    if(Array.isArray(codesArray)){
        codesArray.forEach(function(codeArray,index){
            label = groupLbls[index];
            if(index!=0){   doc.addPage();  }
            drawLines(doc);   
            
            doc.setTextColor("1");       
            doc.setFontSize(40);
            doc.text(28,15,label['part']);

            doc.addImage(codeArray.part,'PNG',7,19);

            doc.setTextColor("0");
            doc.setFontSize(10);
            doc.text(7,31,label['desc']);
            
            doc.setFontSize(24);
            doc.text(12,48,label['quant']);
            doc.addImage(codeArray.quant,'PNG',4,50);

            doc.setFontSize(11);
            date = label['date'];
            doc.text(57,39.5,date.slice(6)+"/"+date.slice(4,6)+"/"+date.slice(2,4));

            doc.text(59,49.5,label['time'].slice(0,2)+":"+label['time'].slice(2));

            doc.addImage(codeArray.ran,'PNG',87,34.5);
            doc.setTextColor("1");
            doc.setFontSize(38);
            doc.text(83,60,label['ran']);

            doc.addImage(codeArray.sup,'PNG',4,70.5);
            doc.setTextColor("0");
            doc.setFontSize(15);
            doc.text(32,69,label['supplier']);

            doc.addImage(codeArray.serialCode,'PNG',15,86);
            doc.setFontSize(13);
            doc.text(32,85,codeArray.serial);

            doc.text(94,69,label['loc1']);
            doc.text(94,78,label['loc2']);
            doc.text(94,87,label['loc3']);
            doc.text(94,96,label['loc4']);

            doc.addImage(codeArray.qr,'PNG',127,65);
        }); 
        download(doc);
    }else{
        console.log("Hubo un error con los datos");
    }
}
function drawLines(doc){
    doc.setLineWidth(0.5);

    doc.rect(2,3,160,95);

    doc.setFontSize(9);

    doc.rect(2,3,160,30); //C1
    doc.rect(2,3,160,14,'F');
    doc.setTextColor("1");
    doc.setFontType("bold");
    doc.text(3,7,"PART NUM.\n(P)");

    doc.rect(2,33,45,29); //C2
    doc.setTextColor("0");
    doc.text(3,37,"QUANTITY\n(Q)");

    doc.rect(47,33,35,29); //C3

    doc.line(47,43,82,43); //L1
    doc.line(47,53,82,53); //L2
    
    doc.rect(2,62,80,18); //C4
    doc.text(3,65.5,"SUPPLIER\n(V)");

    doc.rect(2,80,80,18); //C5
    doc.text(3,83,"SERIAL\n(4S)");
    
    doc.rect(82,33,80,29); //C6
    doc.rect(82,48,80,14,'F');
    doc.text(84,46.5,"RAN (15K)");
    doc.text(3,97,"POSCO MPPC S.A. DE C.V.");

    doc.rect(82,62,40,36); //C7

    doc.setFontSize(6);
    doc.text(107,64.5,"(LOCATION 1)");
    doc.text(107,73.5,"(LOCATION 2)");
    doc.text(107,82.5,"(LOCATION 3)");
    doc.text(107,91.5,"(LOCATION 4)");


    doc.line(82,71,122,71); //L1
    doc.line(82,80,122,80); //L2
    doc.line(82,89,122,89); //L3

    doc.rect(122,62,40,36); //C8
}
function download(doc){
    doc.setProperties({
        title: 'PDF Title',
        subject: 'Info about PDF',
        author: 'PDFAuthor',
        keywords: 'generated, javascript, web 2.0, ajax',
        creator: 'My Company'
    });

    $('#pdfFrame').attr('src',doc.output('datauristring'));
}
