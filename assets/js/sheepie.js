/**
 * Sheepie JavaScript Functions
 *
 * @author Mark Grealish <mark@bhalash.com>
 * @copyright 2015 Mark Grealish
 * @license GPL-3.0
 * @version 1.0
 * @link https://github.com/bhalash/sheepie
 */

(function($, document, window) {
    /**
     * DOM Cleanup
     *
     * 1. Add <code> tag necessary for Highlight.js.
     * 2. Remove WordPress-inserted elements which break layout in <figure>.
     */

    $('pre').wrapInner('<code/>');
    $('figure br').add('p:empty').remove();
    /**
     * Show lightbox when action click detected.
     *
     * @param {object} event - DOM event.
     * @param {object} data - Binding event data.
     * @param {object} element - Event triggering element.
     */

    $.subscribe('modal:show:lightbox', function(event, data, element) {
        data = {
            src: $(element).data('src') || $(element).attr('src'),
            alt: $(element).data('alt') || $(element).attr('alt')
        };

        $('.lightbox__image').attr(data);
    });

    /**
     * Focus modal search input on click.
     */

    $.subscribe('modal:show:search', function() {
        $('.modal-search__input').focus();
    });
})(jQuery, document, window);
