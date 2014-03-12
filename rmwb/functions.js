function navigationPrevWidth() {
    // The left nav will always be longer than the right.
    // Because the text is longer.
    // This function equalizes them.
    var navL = $('.nav-left a');
    var navR = $('.nav-right a');

    navR.css('width', navL.outerWidth() + 'px');    
}

function rightMinHeight() {
    // Page height - article bottom-margin.
    var rCol = $('.content-right-interior');
    rCol.css('min-height', ($(window).innerHeight() - 30) + 'px');
}

$(function() {
    // Page navigation colours. Red down, blue up.
    var nla = $('.nav-left a, .nav-right a' );
    var wid = nla.outerWidth();

    nla.hover( 
        function() {
            $(this).animate({'width' : wid * 1.2}, 100);
            // $(this).stop().animate({backgroundColor: '#fff'}, 300);
        }, function() {
            $(this).animate({'width' : wid}, 100);
            // $(this).stop().animate({backgroundColor: '#000'}, 300);
    })
});

$(document).ready(
    function() {
        navigationPrevWidth();
        rightMinHeight();
    }
);

$(window).on('resize',
    function() {
        navigationPrevWidth();
        rightMinHeight();
    }
);