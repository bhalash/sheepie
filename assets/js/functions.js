jQuery(function($) {
    'use strict';
    /*
     * Cover Scroll Prompt
     * -------------------
     */

    // $(document).ready(function() {
    //     $('pre code').each(function(i, block) {
    //         hljs.highlightBlock(block);
    //     });
    // });

    $('#header .prompt').click(function() {
        $('html, body').animate({ 
            scrollTop: $('#content').offset().top
        }, 500);

        return false;
    });

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
            toggle: 'a[title=Search]',
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
     * Nav Box Shadow.
     * ---------------
     */

    var nav = {
        id: 'nav#top-menu',
        anchor: 'nav#top-menu li',
        content: '#content',
        shadow: 'nav-box-shadow',
        boxShadow: function() {
            // Set box shadow at bottom of nav menu on window scroll.
            if ($(window).scrollTop() === 0) {
                $(nav.id).removeClass(nav.shadow);
            } else {
                $(nav.id).addClass(nav.shadow);
            }
        },
        scrollOpacity: function() {
            // Change the opacity of the top nav menu on window scroll.
            var a = parseInt($(nav.content).css('padding-top')),
                b = $(window).scrollTop(),
                c = b / a;

            // Constrain opacity between 0 and 1.
            c = (c < 0) ? 0 : c;
            c = (c > 1) ? 1 : c;

            $(nav.id).css('background-color', 'rgba(255,255,255,' + c + ')');
        },
        invertTextColour: function() {
            /* Graduallly invert the colour of the anchor element as the page
             * scrolls, using RGB values. */

            var limits = {
                /* The dark grey colour is 88,88,88, and white is 255,255,255
                 * The output RGB colour should be constrained between these. */ 
                upper: 255,
                lower: 88
            };

                // Initial colour.
            var color = limits.upper, 
                difference = limits.upper - limits.lower,
                contentTop = parseInt($(nav.content).css('padding-top')),
                windowPos = $(window).scrollTop(),
                percentage = windowPos / contentTop;

            percentage = (percentage < 0) ? 0 : percentage;
            percentage = (percentage > 1) ? 1 : percentage;

            /* For example: 
             * color = 255(, 255, 2555)
             * difference = 255 - 80 = 167
             * percentange = (randomly) 0.46
             * 
             * color = 255 - (167 * 0.46) = 178 (rounded)
             */

            color = Math.floor(limits.upper - (difference * percentage));
            color = (color > limits.upper) ? limits.upper : color;
            color = (color < limits.lower) ? limits.lower : color;

            $(nav.anchor).css('color', 'rgba(' + color + ',' + color + ',' + color + ', 1)');
        }
    };

    $(window).on('scroll', nav.boxShadow);
    $(window).on('scroll', nav.invertTextColour);
    $(window).on('scroll', nav.scrollOpacity);

    /*
     * Header Size
     * -----------
     */

    if ($('body').hasClass('admin-bar')) {
        /* Push down the header to an appropriate degree if the WordPress admin
         * is displayed. */ 
        var a = $('#wpadminbar').height();
        $('nav#top-menu').css('top', a);
        $('#header').css('top', a);
    }

    /*
     * Comments Focus
     * --------------
     */

    $('.comment').click(function() { 
        $('.comment').not(this).removeClass('focused-comment');
        $(this).addClass('focused-comment');
    });
});