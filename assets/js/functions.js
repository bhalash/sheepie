/**
 * Miscellaneous JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */


(function($) {
    /*
     * Initialize highligh.js
     * -------------------------------------------------------------------------
     * highlight.js operates on the <code> child or <pre> elements. This wraps the
     * content of an element with <code> before initializing highlight.js.
     */

    $('pre:not(:has(> code))').wrapInner('<code></code>');
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

    /**
     * Bigsearch Toggle 
     * -------------------------------------------------------------------------
     */

    $.fn.linkedToggle = function(target, input) {
        var $element = '';
        var $target = '';
        var $input = '';

        var init = function(element, target, input) {
            $element = $(element);
            $target = $(target);
            $input = $(input);
            $element.on('click', element, toggle);
            $target.on('keyup', linkedKeypress);
        }

        var linkedKeypress = function(event) {
            if  (event.keyCode === 27) {
                $(this).removeClass('show');
                $element.removeClass('close');
            }
        }

        var toggle = function(event) {
            $target.attr('tabindex', 2);
            $target.toggleClass('show');
            $element.toggleClass('close');
            $input.focus();
        }

        init(this, target, input);
    }

    $('.bigsearch-toggle').linkedToggle('#bigsearch', '.bigsearch-input');
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
