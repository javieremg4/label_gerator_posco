$.ajax({
    type: 'get',
    data: null,
    url: '../server/tasks/link_menu.php',
    success: function(result){
        if(result==="back-error"){
            window.location = "error.html";
        }else{
            var link = document.createElement('a');
            link.setAttribute('href',result);
            link.innerHTML = "Menú";
            document.getElementsByTagName('nav')[0].insertBefore(link,document.getElementsByTagName('nav')[0].firstChild);
        }
    },
    error: function(){
        alert("Disculpe, ocurrió un problema. Consulte al Administrador");
        window.location = "../pages/error.html";
    }
});
