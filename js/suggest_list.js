//function: evaluar las teclas pulsadas en el input
function suggest_list(code,idInput,idList){
    var input = document.getElementById(idInput);
    var list = document.getElementById(idList);
    if(code === 40){ //code: abajo
        if(list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = list.firstChild;
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
        if(list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = list.lastChild;
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
                    if(idInput==='no-parte' || idInput==='buscar-parte'){
                        //code: se agregan las sugerencias a la lista y los eventos
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
                        $('#sug-lote').html(result);
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
                            document.getElementById('buscar-parte').disabled = true;
                            $('#btn-cancel').on("click",function(){clean_data()});
                        }
                    }else if(idInput === 'inspec' || idInput === 'buscar-lote'){
                            $('#datos-lote').html(result);
                        if(idInput === 'buscar-lote'){
                            document.getElementById('buscar-lote').disabled = true;
                            $('#btn-cancel').on("click",function(){clean_data()});
                        }
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
