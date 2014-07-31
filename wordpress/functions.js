function contentHeight() {
    // Page height - article bottom-margin.
    $('.right-wrap').css('min-height', $(window).height() + 'px');
}

$(function() {
    // For google-code-prettify
    $('pre').each(function() {
        $(this).addClass('prettyprint');
    });    

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
