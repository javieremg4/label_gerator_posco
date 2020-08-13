let doc;
function pdfGenerator(groupLbls){
    console.log("No. de etiquetas = "+groupLbls.length)
    doc = new jsPDF('p', 'mm', 'letter')
    doc.setFontSize(40)
    $.ajax({
        type: 'post',
        url: 'genImgCodes.php',
        data: "data="+JSON.stringify(groupLbls),
        dataType: 'json',
        success: function(data){
            console.log("ajax success!");
            if(data.length == groupLbls.length){
                doFile(data);         
            }else if(data.status==="OK" && data.message){
                console.log(message);
            }else{
                console.log("incorrect answer!");
            }
            console.log(data);
        },
        error: function(data){
            console.log("ajax fail!");
            console.log(data);
        }
    });
    //Ajax para generar una etiqueta
    /*for (let index = 0; index < groupLbls.length; index++) {
        $.ajax({
            type: 'post',
            url: 'genImgCodes.php',
            data: 'data='+JSON.stringify(groupLbls[index]),
            dataType: 'json',
            success: function(data){
                console.log(index);
                if(data.qr && data.part && data.quant && data.ran && data.sup && data.serial){
                    doc.addPage();
                    //drawLines();
                    console.log("ajax success");
                    doc.addImage(data.qr,'PNG',10,10);
                    doc.addImage(data.part,'PNG',10,50);
                    doc.addImage(data.quant,'PNG',10,60);
                    doc.addImage(data.ran,'PNG',10,70);
                    doc.addImage(data.sup,'PNG',10,80);
                    doc.addImage(data.serial,'PNG',10,90);
                }else{
                    console.log("ajax fail");
                }
                //$('#server_answer').html($('#server_answer').html()+"<br>"+data);
            },
            error: function(data){
                console.log("FAIL");
                doc.text(35,25,"No se pudo generar la etiqueta");
            },
            complete: function(){  }
        });
    }*/
}
function doFile($codesArray){

    $codesArray.forEach(function(codeArray,index){
        if(index!=0){   doc.addPage();  }
        //drawLines();
        doc.addImage(codeArray.qr,'PNG',10,10);
        doc.addImage(codeArray.part,'PNG',10,50);
        doc.addImage(codeArray.quant,'PNG',10,60);
        doc.addImage(codeArray.ran,'PNG',10,70);
        doc.addImage(codeArray.sup,'PNG',10,80);
        doc.addImage(codeArray.serial,'PNG',10,120); 
    });  
}
function drawLines(){
    doc.setLineWidth(0.5);

    doc.rect(2,3,160,95);
    
    doc.rect(2,3,160,30); //C1

    doc.rect(2,33,45,29); //C2

    doc.rect(47,33,35,29); //C3

    doc.line(47,43,82,43); //L1
    doc.line(47,53,82,53); //L2
    
    doc.rect(2,62,80,18); //C4
    doc.rect(2,80,80,18); //C5
    
    doc.rect(82,33,80,29); //C6

    doc.rect(82,62,40,36); //C7
    
    doc.line(82,71,122,71); //L1
    doc.line(82,80,122,80); //L2
    doc.line(82,89,122,89); //L3

    doc.rect(122,62,40,36); //C8
}
function download(){
    doc.setProperties({
        title: 'PDF Title',
        subject: 'Info about PDF',
        author: 'PDFAuthor',
        keywords: 'generated, javascript, web 2.0, ajax',
        creator: 'My Company'
    });
    $('#pdfFrame').attr('src',doc.output('datauristring'));
    //doc.save("test.pdf");
    //doc.output('save','text.pdf');
}
