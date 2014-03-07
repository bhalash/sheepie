widthBreak = 830;

function containerSizes() {
    var a = $('.content-left-exterior');
    var b = $('.content-right-exterior');

    if ($(window).width < widthBreak) {
        a.css('width', '100%');
        b.css('width', '100%');
    } else {
        a.css('width', '250px');
        b.css('width', $(window).width() - a.width());
    }

    // a.css('min-height', $(window).height() + 'px');
    b.css('width', ($(window).width() - a.width()) + 'px');

}

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

function clearSearch(obj) {
    // Clears and restores the default value from the search input.
    var str = 'Search RMWB';

    if (obj.value == str) {
        obj.value = '';
    } else if (obj.value == '') {
        obj.value = str;
    }
}

$(document).ready(
    function() {
        // commentTextarea();
        containerSizes();
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        // commentTextarea();
        containerSizes();
        socialWidgetHeight();
    }
);    