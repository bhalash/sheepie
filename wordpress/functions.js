function navigationWidth() {
    // The left nav will always be longer than the right.
    // Because the text is longer.
    // This function equalizes them.
    var left = $('.nav-left a');
    var right = $('.nav-right a');

    right.css('width', left.outerWidth() + 'px');    
}

function contentHeight() {
    // Page height - article bottom-margin.
    var left   = $('.content-left');
    var right  = $('.content-right');

    if (left.height() > right.height()) {
        right.css('min-height', left.height() + 'px');
    } else {
        right.css('min-height', $(window).height() + 'px');
    }
}

$(function() {
    // Widget width is dynamic and proportional to the div container size. 
    // Height = width.
    var soc = $('.social a');
    soc.css('height', soc.width() + 'px'); 
});

// var currentBGPos = 0;
// setInterval(function() {
//     // Scrolling background in search input.
//     currentBGPos--;
//     $('input[class=search-input]').css('background-position', '0 ' + currentBGPos + 'px');
// }, 80);

$(function() {
    contentHeight();
    navigationWidth();
});

$(window).resize(function() {
    contentHeight();
    navigationWidth();
});