function commentTextarea() {
    // Sets the sizes for search form elements.
    var mainCol = $('#content');
    var tx = $('#comment-entry textarea');
    tx.css('width', $(mainCol).width() - 8);
    tx.attr('rows', 10);
}

function socialWidgetHeight() {
    // Widget width is proportional to div and div container size. 
    // Height = width.
    var soc = $('.social a');
    soc.css('height', soc.width() + 'px'); 
}

$(document).ready(
    function() {
        // commentTextarea();
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        // commentTextarea();
        socialWidgetHeight();
    }
);    