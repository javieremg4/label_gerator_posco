//jQuery: detectar «click» fuera de un elemento
$('html').on('click',function(){
    if(document.getElementById('sug-part').hasChildNodes()){
        cleanList();
    }
});
$('#sug-part').click(function(event){
    event.stopPropagation();
});
//***
//jQuery: evitar el evento por default del elemento
$('#form_label').on('submit',function(event){
    event.preventDefault();
});
//***
//code: evaluar las teclas pulsadas en el input
$('#no-parte').on('keyup',function(event){
    var code = event.which || event.keyCode;
    var partInput = document.getElementById('no-parte');
    var part_list = document.getElementById('sug-part');
    if(code === 40){ //code: abajo
        if(part_list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = part_list.firstChild;
            var bool = true;
            while(bool && part !== part_list.lastChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.nextSibling;
                } 
            }
            if(part === part_list.lastChild){
                if(part.style.background === ""){
                    part_list.firstChild.style.background = color;
                    partInput.value = part_list.firstChild.innerHTML;
                }else{
                    part.style.background = "";
                    part_list.firstChild.style.background = color;
                    partInput.value = part_list.firstChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.nextSibling.style.background = color;
                partInput.value = part.nextSibling.innerHTML;
            }
        }
    }else if(code === 38){ //code: arriba
        if(part_list.hasChildNodes()){
            var color = "rgb(204,204,204)";
            var part = part_list.lastChild;
            var bool = true;
            while(bool && part !== part_list.firstChild){
                if(part.style.background !== ""){
                    bool = false;
                }else{
                    part = part.previousSibling;
                } 
            }
            if(part === part_list.firstChild){
                if(part.style.background === ""){
                    part_list.lastChild.style.background = color;
                    partInput.value = part_list.lastChild.innerHTML;
                }else{
                    part.style.background = "";
                    part_list.lastChild.style.background = color;
                    partInput.value = part_list.lastChild.innerHTML;
                }
            }else{
                part.style.background = "";
                part.previousSibling.style.background = color;
                partInput.value = part.previousSibling.innerHTML;
            }
        }
    }else if(code === 13){ //code: enter
        if(part_list.hasChildNodes()){
            cleanList();
        }
    }else{
        if(partInput.value !== ""){
            var noparte = "no-parte="+partInput.value;
            $.ajax({
                type: 'post',
                url: '../server/tasks/suggest_part.php',
                data: noparte,
                success: function(result){
                    //code: se agregan las sugerencias a la lista y los eventos
                    $('#sug-part').html(result);
                    $('#sug-part').addClass('sug-part');
                    $('ul#sug-part li').on('click',function(){
                        partInput.value = this.innerHTML;
                        if(part_list.hasChildNodes()){
                            cleanList();
                        }
                    });
                    //***
                }
            });
        }else{
            cleanList();
        }
    }
});
//***
//function: limpia la lista de sugerencias
function cleanList(){
    var part_list = document.getElementById('sug-part');
    while(part_list.hasChildNodes()){
        part_list.removeChild(part_list.firstChild);
    }
    $('#sug-part').removeClass('sug-part');
}
//***
$('#con-parte').on('click',function(){
    var partInput = document.getElementById('no-parte');
    if(partInput.value !== ""){
        var noparte = "no-parte="+partInput.value;
        $.ajax({
            type: 'post',
            url: '../server/tasks/see_part.php',
            data: noparte,
            success: function(result){
                document.getElementById('datos-parte').innerHTML = result;
            }
        });
    }
});
