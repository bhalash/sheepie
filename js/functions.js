jQuery(function($) {
    /*
     * Search Form Focusing
     * --------------------
     */

    var search = {
        form: '.search',
        input: '.search-text',
        results: '.page-search',
        url: window.location.host + '/search/',
        nav: {
            toggle: '#nav-search-toggle',
            body: '.nav-search',
            open: false
        }
    };

    if (search.results.length > 0) {
        $(search.results).find(search.input).focus();
    }

    $(search.nav.toggle).click(function() {
        $(search.nav.body).slideDown(200, function() {
            $(search.nav.body).find(search.input).focus();
        });

        if (!search.nav.open) {
            search.nav.open = true;
            return false;
        }
    });

    $(search.form).submit(function(click) {
        if ($(search.input).val() === '') {
            click.preventDefault();
            window.location.href = search.url;
        }
    });

    /*
     * User Warning
     * ------------
     * Warning for users while I work on the site.
     */

    var dev = {
        parent: '#content .interior',
        div: '.dev-warning',
        url: 'http://www.bhalash.com/archives/13544803444',
        text: function() {
            return '<p><strong>Feb 2015:</strong> Some parts of the site may be broken, as it is under active redevelopment. See <a href="' + this.url + '">this</a> post for more information.';
        }
    }

    // $(dev.parent).prepend('<div class="' + dev.div.substr(1) + '">');
    // $(dev.div).html(dev.text());

    /*
     * Commentform Toggle
     * ------------------
     * I've decided to hide the commentform unless the user chooses to use it.
     */

    $('#textarea textarea').focus(function() {
        $(this).css('height', 150);

        $('#commentform > *').slideDown(200, function() {
            $(window).scrollTop($('#commentform').offset().top);
        });
    });

    /*
     * Google Code Prettify
     * --------------------
     * Add a suitable class to each pre block for Google Code Prettifier.
     */

    $('pre').each(function() {
        $(this).addClass('prettyprint');
    });    
});