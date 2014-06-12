function navigationWidth() {
    // The left nav will always be longer than the right.
    $('.nav-right a').css('width', $('.nav-left a').outerWidth() + 'px');    
}

function contentHeight() {
    // Page height - article bottom-margin.
    $('.content-right').css('min-height', $(window).height() + 'px');
}

function widgetHeight() {
    // Widget width is dynamic and proportional to the div container size. 
    $('.social a').css('height', $('.social a').width() + 'px'); 
}

$(function() {
    contentHeight();
    navigationWidth();
    widgetHeight();

    $('p > a').each(function() {
        if ($(this).children('img').length > 0) {
            $(this).hover(function() {
                $(this).css('border-style', 'none');
            });
        }
    });
});

$(window).resize(function() {
    contentHeight();
    navigationWidth();
    widgetHeight();
});