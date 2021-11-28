function preloaderOn(){
    var Body = $('body');
    Body.addClass('preloader-site');
    $('.preloader-wrapper').css({ 'display' : 'unset'});
}

function preloaderOff(){
    $('.preloader-wrapper').fadeOut();
    $('body').removeClass('preloader-site');
    console.log('findou')
}