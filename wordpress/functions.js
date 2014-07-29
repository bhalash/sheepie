function contentHeight() {
    // Page height - article bottom-margin.
    $('.content-right').css('min-height', $(window).height() + 'px');
}

$(function() {
    $('.current-menu-item').prev().css('margin-bottom', '10px');
    $('.current-menu-item').next().css('margin-top', '10px');

    contentHeight();
    
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
});
