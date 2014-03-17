var currentBGPos = 0;

function dogeScroll() {
    currentBGPos--;
    $('input[class=search-input]').css('background-position', '0 ' + currentBGPos + 'px');
}

function navigationPrevWidth() {
    // The left nav will always be longer than the right.
    // Because the text is longer.
    // This function equalizes them.
    var left = $('.nav-left a');
    var right = $('.nav-right a');

    right.css('width', left.outerWidth() + 'px');    
}

function rightMinHeight() {
    // Page height - article bottom-margin.
    var leftCon = $('.content-left').height();
    var rightCon = $('.content-right');

    rightCon.css('min-height', leftCon + 'px');
}

$(function() {
    // Animates button colours.
    var button = $('.nav-left a, .nav-right a, .search-submit, #submit');

    button.hover( 
        function() {
            $(this).stop().animate({backgroundColor: '#ba3434'}, 300);
        }, function() {
            $(this).stop().animate({backgroundColor: '#4284fd'}, 300);
    })
});

$(document).ready(
    function() {
        navigationPrevWidth();
        rightMinHeight();
        setInterval('dogeScroll()', 80);
    }
);

$(window).on('resize',
    function() {
        navigationPrevWidth();
        rightMinHeight();
    }
);