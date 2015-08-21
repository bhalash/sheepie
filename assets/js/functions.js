/**
 * Miscellaneous JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

/*
 * Initialize highligh.js
 * -----------------------------------------------------------------------------
 * highlight.js operates on the <code> child or <pre> elements. This wraps the
 * content of an element with <code> before initializing highlight.js.
 */

jQuery('pre:not(:has(> code))').wrapInner('<code></code>');
hljs.initHighlightingOnLoad();

/**
 * Remove Photobox Breaks
 * -----------------------------------------------------------------------------
 * WordPress can insert <br> tags between elements if it detects either a space
 * or a line break. This can break the formatting of the lightbox.
 */

jQuery('.article-photobox br').remove();

/*
 * Initialize Lightbox
 * -----------------------------------------------------------------------------
 */

jQuery('article a img').addLightbox();

/*
 * Placeholder Fallback IE9
 * -----------------------------------------------------------------------------
 * @link https://gist.github.com/AlexCuse/3084976
 */

(function () {
    jQuery.support.placeholder = false;
    var test = document.createElement('input');
    if ('placeholder' in test) {
        jQuery.support.placeholder = true;
        return function () { }
    } else {
        return function () {
            jQuery(function () {
                var active = document.activeElement;
                $('form').delegate(':text', 'focus', function () {
                    var _placeholder = $(this).attr('placeholder'),
                    _val = $(this).val();
                    if (_placeholder !== undefined && _val == _placeholder) {
                        $(this).val('').removeClass('hasPlaceholder');
                    }
                }).delegate(':text', 'blur', function () {
                    var _placeholder = $(this).attr('placeholder'),
                    _val = $(this).val();
                    if (_placeholder !== undefined && (_val == '' || _val == _placeholder)) {
                        $(this).val(_placeholder).addClass('hasPlaceholder');
                    }
                }).submit(function () {
                    $(this).find('.hasPlaceholder').each(function () { $(this).val(''); });
                });
                $(':text').blur();
                $(active).focus();
            });
        }
    }
})()();
