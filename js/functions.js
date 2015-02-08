jQuery(function($) {
    // For google-code-prettify
    $('pre').each(function() {
        $(this).addClass('prettyprint');
    });    

    $('#search').submit(function() {
        $(':submit').attr('disabled', true);
    })

    var devUrl = 'http://www.bhalash.com/archives/13544803444';
    var devWarning = '<p><strong>Feb 2015:</strong> Some parts of the site may be broken, as it is under active redevelopment. See <a href="' + devUrl + '">this</a> post for more information.';

    // Warning for users while I work on the site.
    $('.dev-warning').html(devWarning);
});