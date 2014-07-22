function contentHeight() {
    // Page height - article bottom-margin.
    $('.content-right').css('min-height', $(window).height() + 'px');
}

function socialSize() {
    $('.social').css('width', $('.social').parent().css('width'));

    $('.social li').each(function() {
        $(this).css('width', Math.floor($('.social').width() / 4 + 'px'));
        $(this).css('height', $(this).width() + 'px');
    });
}

$(function() {
    contentHeight();
    socialSize();

    // Remove underline from hyperlink images. 
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
    socialSize();
});
