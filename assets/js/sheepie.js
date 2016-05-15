/**
 * Sheepie functions.
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

    $('pre:not(:has(>code))').wrapInner('<code/>');
    $('figure br').add('p:empty').remove();
})(jQuery, document, window);
