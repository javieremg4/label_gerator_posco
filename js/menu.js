document.getElementById('btn-menu').addEventListener('click',function(){
    document.getElementById('menu').classList.toggle('show');
});
$(window).on('resize',function(){
    if($(window).width()>769){
        $('#menu').removeClass('show');
    }
});
