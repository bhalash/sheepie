/**
 * Miscellaneous JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

;(function($) {
    /*
     * Wrap Pre Elements
     * -------------------------------------------------------------------------
     * highlight.js operates on the <code> child or <pre> elements. This wraps the
     * content of an element with <code> before initializing highlight.js.
     *
     * TODO: replace with vanilla JS.
     */

    if ($('pre').length) {
        $('pre:not(:has(> code))').wrapInner('<code></code>');
    }

    /**
     * Remove Photobox Breaks
     * -------------------------------------------------------------------------
     * WordPress can insert <br> tags between elements if it detects either a
     * space or a line break. This can break the formatting. Runs once.
     */

    var pb = document.querySelectorAll('[class^=article-photobox] br');

    if (pb.length) {
        [].forEach.call(pb, function(e) {
            e.parentNode.removeChild(e);
        });
    }

})(jQuery, window, document, undefined);

;(function() {
    /*
     * Lightbox and Search Controller
     * -------------------------------------------------------------------------
     *  Built around Knockout.js, this controller manages the search and
     *  lightbox display on the site, in conjunction with a tiny PHP function
     *  to add the click directive to article images.
     */

    var sheepieController = function() {
        var self = this;

        /*
         * View States
         * ---------------------------------------------------------------------
         *  Add whatever extra states here.
         */

        self.display = {
            search: ko.observable(false),
            lightbox: ko.observable(false)
        };

        /*
         * Lightbox Attributes
         * ---------------------------------------------------------------------
         * Pulled from the bound image. Link isn't used, although it is useful
         * for future use.
         */

        self.lightbox = {
            text: ko.observable(null),
            image: ko.observable(null),
            link: ko.observable(null)
        };

        /*
         * Change State
         * ---------------------------------------------------------------------
         *  1. Hide all the eiements, except name.
         *  2. If name exists, invert its state.
         *
         * @param   string      name        State to toggle true.
         */

        self.show = function(name) {
            for (var i in self.display) {
                if (name && name in self.display && self.display[i]() === self.display[name]()) {
                    continue;
                }

                self.display[i](false);
            }

            if (name && name in self.display) {
                self.display[name](!self.display[name]());
            }
        };

        /*
         * Set State to: Whatever
         * ---------------------------------------------------------------------
         */

        self.toggleLightbox = function() {
            self.show('lightbox');
        };

        self.toggleSearch = function() {
            self.show('search');
        };

        /*
         * Close Lightbox/Search/Whatever on Escape
         * ---------------------------------------------------------------------
         */

        self.closeOnEscape = function(data, event) {
            if (event.keyCode === 27) {
                self.show(null);
            }
        };

        /*
         * Set Lightbox Data and Open Lightbox
         * ---------------------------------------------------------------------
         */

        self.showLightbox = function(data, event) {
            self.lightbox.text(event.target.attributes.alt.value);
            self.lightbox.image(event.target.attributes.src.value);
            self.lightbox.link(event.target.parentNode.attributes.href.value);

            self.show('lightbox');
        };
    };

    ko.applyBindings(new sheepieController());
})();

/**
 * Google Analytics
 * -----------------------------------------------------------------------------
 */

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-2156640-5']);
_gaq.push(['_setDomainName', 'bhalash.com']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
