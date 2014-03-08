function socialWidgetHeight() {
    // Widget width is proportional to div and div container size. 
    // Height = width.
    var soc = $('.social a');
    soc.css('height', soc.width() + 'px'); 
}

function minHeightTest() {
    var con = $('.content-right-interior');
    con.css('min-height', $(window).height());
}

$(document).ready(
    function() {
        minHeightTest();
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        minHeightTest();
        socialWidgetHeight();
    }
);    