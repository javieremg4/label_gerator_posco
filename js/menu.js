//event: click en el boton del menú
document.getElementById('btn-menu').addEventListener('click',function(){
    document.getElementById('menu').classList.toggle('show');
});
//***
//evento: ocultar opciones del menu al cambiar el tamaño del la ventana
$(window).on('resize',function(){
    if($(window).width()>769){
        $('#menu').removeClass('show');
    }
});
//***
//function: asignar foco al primer input del primer form
function inputFocus(){
    if(document.forms.length > 0) {
        for(var i=0; i < document.forms[0].elements.length; i++) {
            var campo = document.forms[0].elements[i];
            if(campo.type != "hidden") {
                campo.focus();
                break;
            }
        }
    }
}
//***
