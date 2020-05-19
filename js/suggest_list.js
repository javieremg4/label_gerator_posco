//Variable globales para identificar cual parte o lote quiere actualizar el usuario
//Se asignan al dar enter o clic en los elementos de la lista desplegable
var npart_g = "soy una variable global";
var nlot_g = "soy una variable global";
//***
//function: evaluar las teclas pulsadas en el input
function suggest_list(code,idInput,idList){
    var input = document.getElementById(idInput);
    var list = document.getElementById(idList);
    if(code === 40){ //code: abajo
        var part = list.firstChild;
        if(part!==null && part.nodeType === 1){
            var color = "rgb(204,204,204)";
            var bool = true;
            while(bool && part !== list.lastChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.nextSibling;
                } 
            }
            if(part === list.lastChild){
                if(part.style.background === ""){
                    list.firstChild.style.background = color;
                    input.value = list.firstChild.innerHTML;
                }else{
                    part.style.background = "";
                    list.firstChild.style.background = color;
                    input.value = list.firstChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.nextSibling.style.background = color;
                input.value = part.nextSibling.innerHTML;
            }
        }
    }else if(code === 38){ //code: arriba
        var part = list.lastChild;
        if(part!==null && part.nodeType === 1){
            var color = "rgb(204,204,204)";
            var bool = true;
            while(bool && part !== list.firstChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.previousSibling;
                } 
            }
            if(part === list.firstChild){
                if(part.style.background === ""){
                    list.lastChild.style.background = color;
                    input.value = list.lastChild.innerHTML;
                }else{
                    part.style.background = "";
                    list.lastChild.style.background = color;
                    input.value = list.lastChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.previousSibling.style.background = color;
                input.value = part.previousSibling.innerHTML;
            }
        }
    }else if(code === 13){ //code: enter
        if(list.hasChildNodes()){
            cleanList(idList);
        }
        consult_part_lote(idInput); 
    }else{
        if(input.value !== ""){
            var postData = "";
            if(idInput==='no-parte' || idInput==='buscar-parte'){
                postData = "no-parte="+input.value;
            }else if(idInput==='inspec' || idInput==='buscar-lote'){
                postData = "no-lote="+input.value;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/suggest_part_lote.php',
                data: postData,
                success: function(result){
                    if(result.indexOf("Error:")===-1 && result.indexOf("Falló")===-1){
                        if(idInput==='no-parte' || idInput==='buscar-parte'){
                            //code: se agregan las sugerencias a la lista y los eventos
                            
                            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
                            $('#sug-part').width($('#'+idInput).width());
                            //***
                            
                            $('#sug-part').html(result);
                            $('#sug-part').addClass('sug-part');
                            $('ul#sug-part li').on('click',function(){
                                input.value = this.innerHTML;
                                if(list.hasChildNodes()){
                                    cleanList(idList);
                                }
                                consult_part_lote(idInput);
                            });
                            //***
                        }else if(idInput==='inspec' || idInput==='buscar-lote'){
                            //code: se agregan las sugerencias a la lista y los eventos
                            
                            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
                            $('#sug-lote').width($('#'+idInput).width());
                            //***

                            $('#sug-lote').html(result);
                            $('#sug-lote').addClass('sug-lote');
                            $('ul#sug-lote li').on('click',function(event){
                                console.log("evento click en lista")
                                event.stopPropagation();
                                input.value = this.innerHTML;
                                if(list.hasChildNodes()){
                                    cleanList(idList);
                                }
                                consult_part_lote(idInput);
                            })
                            //***
                        }
                    }else{
                        alert("La lista de sugerencias no esta disponible. Consulte al Administrador");
                    }
                },
                error: function(){
                    alert("La lista de sugerencias no esta disponible. Consulte al Administrador");
                }
            });
        }else{
            cleanList(idList);
        }
    }
}
//***
//function: limpia la lista de sugerencias
function cleanList(idList){
    var list = document.getElementById(idList);
    while(list.hasChildNodes()){
        list.removeChild(list.firstChild);
    }
    $('#'+idList).removeClass(idList);
}
//***
//function: consulta los datos de la parte o el lote
function consult_part_lote(idInput){
    var input = document.getElementById(idInput);
    if(input.value !== ""){
        if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput === 'inspec' || idInput === 'buscar-lote'){
            var postData = "";
            switch (idInput) {
                case 'no-parte':
                    postData = "no-parte="+input.value;
                    break;
                case 'buscar-parte':
                    postData = "buscar-parte="+input.value;
                    break;
                case 'inspec':
                    postData = "no-lote="+input.value;
                    break;
                case 'buscar-lote':
                    postData = "buscar-lote="+input.value;
                    break;
                default:
                    postData = "";
                    break;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/see_part_lote.php',
                data: postData,
                success: function(result){
                    if(idInput === 'no-parte' || idInput === 'buscar-parte'){
                        $('#datos-parte').html(result);
                        if(idInput === 'buscar-parte'){

                            //Asignación variable global
                            npart_g = input.value;
                            //***

                            $('#btn-cancel').on("click",function(){clean_data()});
                        }
                    }else if(idInput === 'inspec' || idInput === 'buscar-lote'){
                            $('#datos-lote').html(result);
                        if(idInput === 'buscar-lote'){

                            //Asignación variable global
                            nlot_g = input.value;
                            //***

                            $('#btn-cancel').on("click",function(){clean_data()});
                        }
                    }
                },
                error: function(){
                    var msg = "No se pudieron consultar los datos. Consulte al Administrador";
                    if(idInput === 'no-parte' || idInput === 'buscar-parte'){
                        $('#datos-parte').html(msg);
                    }else if(idInput === 'inspec' || idInput === 'buscar-lote'){
                        $('#datos-lote').html(msg);
                    }else{
                        console.log(msg);
                        window.location = "error.html";
                    }
                }
            });
        }
    }else{
        if(idInput === 'no-parte' || idInput === 'buscar-parte'){
            $('#datos-parte').html("");
        }else if(idInput === 'inspec' || idInput === 'buscar-lote'){
            $('#datos-lote').html("");
        }
    }
}
//***
