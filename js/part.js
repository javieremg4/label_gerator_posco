function part_review(){
    var no_parte = document.getElementById('no-parte').value;
    if(!white_review(no_parte,"No. parte: obligatorio")){ return false; }
    if(!char_limit(no_parte,13,"No. parte: Max. 13 caracteres")){ return false; }
    var desc = document.getElementById('desc').value;
    if(!white_review(desc,"Descripción: obligatorio")){ return false; }
    if(!char_limit(desc,50,"Descripción: Max. 50 caracteres")){ return false; }
    var esp = document.getElementById('esp').value;
    if(!white_review(esp,"Especificación: obligatorio")){ return false; }
    if(!char_limit(esp,15,"Especificación: Max. 15 caracteres")){ return false; }
    var kgpc = document.getElementById('kgpc').value;
    if(!white_review(kgpc,"Kg./Pc: obligatorio")){ return false; }
    if(parseFloat(kgpc)===0){
        alert("Kg./Pc: obligatorio");
        return false;
    }
    var expDecimal = /^(\d+|\d*.\d+)$/
    if(kgpc.search(expDecimal)){
        alert("Kg./Pc: valor inválido");
        return false;
    }
    return "no-parte="+no_parte+"&desc="+desc+"&esp="+esp+"&kgpc="+kgpc;
}
function char_limit(variable,limit,msg){
    if(variable.length>limit){
        alert(msg);
        return false;
    }
    return true;
}
function white_review(variable,msg){
    var whiteExp = /^\s+$/;
    if(variable==="" || variable===null || variable.length===0 || !variable.search(whiteExp)){
        alert(msg);
        return false;
    }
    return true;
}
$('#form_part').on('submit',function(e){
    e.preventDefault();
    var postData = part_review();
    if(postData !== false){
        $.ajax({
            type: 'post',
            url: '../server/tasks/set_part.php',
            data: postData,
            success: function(result){
                $('#res-part').html(result);
            }
        });
    }
});
