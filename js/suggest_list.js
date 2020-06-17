//Variable globales para identificar cual parte o lote quiere actualizar el usuario
//Se asignan al dar enter o clic en los elementos de la lista desplegable
var npart_g = null;
var nlot_g = null;
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
            if(idInput==='no-parte' || idInput==='buscar-parte' || idInput==='eliminar-parte'){
                postData = "no-parte="+input.value;
            }else if(idInput==='inspec' || idInput==='buscar-lote' || idInput==='eliminar-lote'){
                postData = "no-lote="+input.value;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/suggest_part_lot.php',
                data: postData,
                dataType: 'json',
                success: function(data){
                    if(data.status==="OK" && data.content){
                        if(idInput==='no-parte' || idInput==='buscar-parte' || idInput==='eliminar-parte'){
                            //event: agregar las sugerencias a la lista y los eventos
                            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
                            $('#sug-part').width($('#'+idInput).width());
                            //***
                            $('#sug-part').html(data.content);
                            $('#sug-part').addClass('sug-part');
                            $('ul#sug-part li').on('click',function(){
                                input.value = this.innerHTML;
                                if(list.hasChildNodes()){
                                    cleanList(idList);
                                }
                                consult_part_lote(idInput);
                            });
                            //***
                        }else if(idInput==='inspec' || idInput==='buscar-lote' || idInput==='eliminar-lote'){
                            //event: agregar las sugerencias a la lista y los eventos
                            //Asignar el ancho de la lista dinámicamente a partir del ancho del input
                            $('#sug-lote').width($('#'+idInput).width());
                            //***
                            $('#sug-lote').html(data.content);
                            $('#sug-lote').addClass('sug-lote');
                            $('ul#sug-lote li').on('click',function(){
                                input.value = this.innerHTML;
                                if(list.hasChildNodes()){
                                    cleanList(idList);
                                }
                                consult_part_lote(idInput);
                            });
                            //***
                        }
                    }else if(data.status==="ERR" && data.message){
                        alert(data.message);
                    }else{
                        window.location = "index.php";
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
//function: limpiar la lista de sugerencias
function cleanList(idList){
    var list = document.getElementById(idList);
    while(list.hasChildNodes()){
        list.removeChild(list.firstChild);
    }
    $('#'+idList).removeClass(idList);
}
//***
//function: generar botón para cambiar entre las opciones del lote (sólo aplica casos 1 y 2)
function addButton(option1,option2){
    const button = document. createElement('button');
    button.type = 'button';
    button.id="change-lot";
    document.getElementById('div-lot').appendChild(button);
    const img = document.createElement('img');
    img.src = "../styles/images/reload-2_icon-icons.com_69598.png";
    img.id = "change-lot-img";
    img.alt = "Cambiar lote";
    button.appendChild(img);
    img.onerror = function(){
        button.innerText = "Cambiar lote";
    }                    
    let flag = true;
    $('#change-lot').on("click",function(){
        if(flag){
            $('#no-lote').val(option2);
            flag = false;
        }else{
            $('#no-lote').val(option1);
            flag = true;
        }
    });
}
//***
//function: consultar los datos de la parte o el lote
function consult_part_lote(idInput){
    var input = document.getElementById(idInput);
    if(input.value !== ""){
        if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput === 'eliminar-parte' || idInput === 'inspec' || idInput === 'buscar-lote' || idInput === 'eliminar-lote'){
            var postData = "";
            switch (idInput) {
                case 'no-parte':
                    postData = "no-parte="+input.value;
                    break;
                case 'buscar-parte':
                    postData = "buscar-parte="+input.value;
                    break;
                case 'eliminar-parte':
                    postData = "eliminar-parte="+input.value;
                    break;
                case 'inspec':
                    postData = "no-lote="+input.value;
                    break;
                case 'buscar-lote':
                    postData = "buscar-lote="+input.value;
                    break;
                case 'eliminar-lote':
                    postData = "eliminar-lote="+input.value;
                    break;
                default:
                    postData = "";
                    break;
            }
            $.ajax({
                type: 'post',
                url: '../server/tasks/see_part_lot.php',
                data: postData,
                dataType: 'json',
                success: function(data){
                    if(data.status==="OK" && data.content){
                        if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput==='eliminar-parte'){
                            $('#datos-parte').html(data.content);

                            //Asignación variable global
                            npart_g = input.value.toUpperCase();
                            //***
                            
                            if(idInput==='no-parte' && $('#cantidad').length){
                                var array = data.content.split("<td>");
                                $('#cantidad').val(array[4]);
                            }

                            if(idInput === 'buscar-parte' || idInput === 'eliminar-parte'){
                                $('#btn-cancel').on("click",function(){clean_data()});
                            }
                        }else if(idInput === 'inspec' || idInput === 'buscar-lote' || idInput === 'eliminar-lote'){
                            $('#datos-lote').html(data.content);

                            //Asignación variable global
                            nlot_g = input.value.toUpperCase();
                            //***

                            if(idInput === 'buscar-lote' || idInput === 'eliminar-lote'){
                                $('#btn-cancel').on("click",function(){clean_data()});
                            }
                        }
                        if((idInput==='buscar-parte' || idInput==='buscar-lote') && $('#lblx').length){
                            $('#lblx').on('click',function(){
                                if($('.div-note').length){
                                    $('.div-note').html("");
                                    $('.div-note').removeClass('div-note');
                                }
                            });
                        }
                    }else if(data.status==="ERR" && data.message){
                        if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput==='eliminar-parte'){
                            $('#datos-parte').html(data.message);
                        }else if(idInput === 'inspec' || idInput === 'buscar-lote' || idInput === 'eliminar-lote'){
                            $('#datos-lote').html(data.message);
                        }else{
                            window.location = "error.html";
                        }    
                    }else{
                        window.location="../pages/index.php";
                    }
                },
                error: function(){
                    var msg = "No se pudieron consultar los datos. Consulte al Administrador";
                    if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput==='eliminar-parte'){
                        $('#datos-parte').html(msg);
                    }else if(idInput === 'inspec' || idInput === 'buscar-lote' || idInput === 'eliminar-lote'){
                        $('#datos-lote').html(msg);
                    }else{
                        window.location = "error.html";
                    }
                }
            });
        }
    }else{
        if(idInput === 'no-parte' || idInput === 'buscar-parte' || idInput === 'eliminar-parte' || idInput === 'eliminar-lote'){
            $('#datos-parte').html("");
        }else if(idInput === 'inspec' || idInput === 'buscar-lote'){
            $('#datos-lote').html("");
        }
    }
}
//***
