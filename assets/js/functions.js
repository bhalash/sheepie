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

;(function($) {
    /*
     * Initialize highlight.js
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

    var linkElements = [];

    $.fn.link = function(args) {
        var defaults = {
            child: '',
            childClass: '',
            target: '',
            targetClass: '',
            linkedClass: '.linked-class-toggle',
            isTargetInput: false,
            toggled: false
        };

        var opts = {};

        function clickToggle(event, override) {
            if (typeof override !== 'boolean' && !opts.toggled) {
                // Hide all other linked elements.
                $(opts.linkedClass).not(this).trigger('click', false);
            }

            opts.toggled = (typeof override === 'boolean') ? override : !opts.toggled;

            $(opts.child).toggleClass(opts.childClass, opts.toggled);
            $(opts.target).toggleClass(opts.targetClass, opts.toggled);

            if (opts.toggled && opts.isTargetInput) {
                $(opts.target).find('input').focus();
            }

            return;
        } 

        function closeOnEscape(event) {
            if (event.keyCode === 27) {
                $(opts.button).trigger('click', false);
            }
        }

        opts = $.extend({}, defaults, args);
        opts.button = this;

        if (!$(opts.linkedClass).length) {
            $(window).on('keyup', closeOnEscape);
        }

        this.addClass(opts.linkedClass.substring(1))
            .on('click', clickToggle);

        return this;
    }

    $('.bigsearch-toggle').link({
        child: '.toggle-icon',
        childClass: 'close',
        target: '#bigsearch',
        targetClass: 'show',
        isTargetInput: true
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
