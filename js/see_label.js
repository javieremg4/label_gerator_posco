window.onload = function(){
    if($('#qr_img').length && $('#pdf').length){
        generate_bar_codes();
        $('#pdf').click(function(){
            //Validación para que no se pueda generar el pdf en pantallas < 650px
            if($(window).width()>632){
                //Asignar el src de la imagen del qr
                var qr_b64 = $('#qr_img').attr('src');
                /*//Generar el canvas del qr con html2canvas
                html2canvas($('#thisQR')[0],{ dpi: 360, scrollY: -window.scrollY }).then(function(canvas){
                    qr = canvas.toDataURL("image/png");
                });*/
                //Generar el canvas de toda la etiqueta
                html2canvas($('#to-pdf')[0],{ dpi: 360, scrollX: 0, scrollY: -window.scrollY }).then(function(canvas){
                    var label = canvas.toDataURL("image/png");
                    //Crear el pdf
                    var doc = new jsPDF('p', 'pt', 'letter');
                    //Poner la imagen de la etiqueta en el pdf
                    doc.addImage(label, 'PNG', -6 ,10);
                    //Poner la imagen del qr arriba de la otra imagen
                    if(qr_b64 !== ''){
                        doc.addImage(qr_b64, 'PNG', 367, 12);
                    }
                    //Guardar el pdf
                    doc.save('test.pdf');
                });
            }else{
                alert("No se puede generar el pdf en esta resolución y/o dispositivo");
            }
        });
    }
}
/*const $boton = document.querySelector("#pdf"), // El botón que desencadena
  $objetivo = document.querySelector("#to-pdf"), // A qué le tomamos la foto
  $contenedorCanvas = document.querySelector("#contenedorCanvas"); // En dónde ponemos el elemento canvas

// Agregar el listener al botón
$boton.addEventListener("click", () => {
  html2canvas($objetivo,{ dpi: 360, scrollX: 0, scrollY: -window.scrollY }) // Llamar a html2canvas y pasarle el elemento
    .then(canvas => {
      // Cuando se resuelva la promesa traerá el canvas
      $contenedorCanvas.appendChild(canvas); // Lo agregamos como hijo del div
    });
});*/
//function: genera el codigo de barras con js
function generate_bar_codes(){
    var bar_fail = "";
    if($('#part').length && $('#part').attr('alt') !== undefined){
        var text = 'P'+$('#part').attr('alt');
        JsBarcode('#part',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: false,
            margin: 2
        });
    }else{
        bar_fail += "\nparte";
    }
    if($('#quantity').length && $('#quantity').attr('alt') !== undefined){
        var msg = $('#quantity').attr('alt');
        text = 'Q'+msg;
        JsBarcode('#quantity',text,{
            format: "CODE128",// El formato
            width: 2, // La anchura de cada barra
            height: 30, // La altura del código
            displayValue: true, // ¿Mostrar el valor (como texto) del código de barras?
            text: msg, // Texto (no código) que acompaña al barcode
            fontOptions: "bold", // Opciones de la fuente del texto del barcode
            textAlign: "center", // En dónde poner el texto. center, left o right
            textPosition: "top", // Poner el texto arriba (top) o abajo (bottom)
            textMargin: 2, // Margen entre el texto y el código de barras
            fontSize: 20, // Tamaño de la fuente
            margin: 1 // Tamaño de los margenes, se puede especificar el valor de cada margen. marginTop, marginRight, marginBottom, marginLeft
        });
    }else{
        bar_fail += "\ncantidad";
    }
    if($('#ran').length && $('#ran').attr('alt') !== undefined){
        text = '15K'+$('#ran').attr('alt');
        JsBarcode('#ran',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: false,
            margin: 2
        });
    }else{
        bar_fail += "\nran";
    }
    if($('#origin').length && $('#origin').attr('alt') !== undefined){
        msg = $('#origin').attr('alt');
        text = 'V'+msg;
        JsBarcode('#origin',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: true,
            text: msg,
            fontOptions: "bold",
            textAlign: "center",
            textPosition: "top",
            textMargin: 2,
            fontSize: 20,
            margin: 2
        });
    }else{
        bar_fail += "\norigen";
    }
    if($('#serial').length && $('#serial').attr('alt') !== undefined){
        msg = $('#serial').attr('alt');
        text = '4S'+msg;
        JsBarcode('#serial',text,{
            format: "CODE128",
            width: 2,
            height: 30,
            displayValue: true,
            text: msg,
            fontOptions: "bold",
            textAlign: "center",
            textPosition: "top",
            textMargin: 2,
            fontSize: 20,
            margin: 2
        });
    }else{
        bar_fail += "\nserial";
    }
    if(bar_fail!==""){
        alert("No se pudieron generar los códigos de barras de:"+bar_fail+"\nConsulte al Administrador");
    }
}
