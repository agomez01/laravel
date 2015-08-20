var estado = false;

$(document).on('click', '#collapse-left', function(){

    if(estado){//está abierto

        $(this).children('span').removeClass('glyphicon-chevron-left');
        $(this).children('span').addClass('glyphicon-chevron-right');
        estado = false;

    }else{//está cerrado

        $(this).children('span').removeClass('glyphicon-chevron-right');
        $(this).children('span').addClass('glyphicon-chevron-left');
        estado = true;
    }

});