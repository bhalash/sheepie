function socialWidgetHeight() {
    // Widget width is proportional to div and div container size. 
    // Height = width.
    var soc = $('.social a');
    soc.css('height', soc.width() + 'px'); 
}

$(document).ready(
    function() {
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        socialWidgetHeight();
    }
);    