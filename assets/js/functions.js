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
     * Initialize highlight.js
     * -------------------------------------------------------------------------
     * highlight.js operates on the <code> child or <pre> elements. This wraps the
     * content of an element with <code> before initializing highlight.js.
     */

    if ($('pre').length) {
        $('pre:not(:has(> code))').wrapInner('<code></code>');
    }

    hljs.initHighlightingOnLoad();

    /**
     * Remove Photobox Breaks
     * -------------------------------------------------------------------------
     * WordPress can insert <br> tags between elements if it detects either a
     * space or a line break. This can break the formatting of the lightbox.
     */

    $('.article-photobox br').remove();

    /*
     * Initialize Lightbox
     * -------------------------------------------------------------------------
     */

    $('article a img').addLightbox();

    /*
     * Linked Class Toggles
     * -------------------------------------------------------------------------
     */

    $('.bigsearch-toggle').link({
        child: '.toggle-icon',
        childClass: 'close',
        target: '#bigsearch',
        targetClass: 'show',
        isTargetInput: true,
    });
})(jQuery, window, document, undefined);

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
