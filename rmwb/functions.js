function navigationPrevWidth() {
    // The left nav will always be longer than the right.
    // Because the text is longer.
    // This function equalizes them.
    var navL = $('.nav-left a');
    var navR = $('.nav-right a');

    navR.css('width', navL.outerWidth() + 'px');    
}

$(document).ready(
    function() {
        navigationPrevWidth();
    }
);

$(window).on('resize',
    function() {
        navigationPrevWidth();
    }
);