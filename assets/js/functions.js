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
 *
 * This file is part of Sheepie.
 *
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
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

/**
 * Article Photobox
 * -----------------------------------------------------------------------------
 * Wordpress inserts a line break if it find a wayward space or line break in 
 * the post texarea. This can cause every other item in the lightbox to be 
 * irregularly sized. I remove breaks in order to circumvent this.
 */

;(function($, window, document, undefined) {
    'use strict'; 
    $.fn.addLightbox = $.fn.addLightbox || function(args) {
        var defaults = {
            classes: {
                hasLightbox: 'has-lightbox',
                lightbox: 'rmwb-lightbox'
            },
            imgData: {
                attribute: 'id',
                separator: '-'
            },
            regex: {
                hash: /\d{1,11}-\d/,
            }
        };

        var settings = {};
        var isSinglePost = false;

        var init = function(element, args) {
            // Initialize lightbox and set up all the things.

            settings = $.extend({}, defaults, args);

            if (!$('body').hasClass(settings.classes.hasLightbox)) {
                isSinglePost = $('body').hasClass('single');
                $(element).each(setupImage);
                setupLightbox('body');

                checkUrlHash();
            }
        }

        var checkUrlHash = function() {
            /* Check URL for matching image hash. Trigger lightbox to appear
             * if it does. */

            if (window.location.hash) {
                var hash = window.location.hash.substring(1);

                if (hash.match(/(\d{1,11}-)?\d{1}\.[a-z]{3}/)) {
                    var attr = settings.imgData.attribute;
                    var image = '[data-' + attr + '="' + hash + '"]';
                    $(image).trigger('click');
                }
            }
        }

        var addRandChars = function(amount, divider) {
            // Generate stream of random chars prefixed by a dividing char.

            amount = amount || 10;
            divider = divider || '-';

            return divider + Math.random()
                .toString(36)
                .replace(/[^a-z]+/g, '')
                .substr(0, amount);
        }

        var setupLightbox = function(element) {
            // Prepend lightbox to target element.

            // Append random chars to class to avoid conflicts.
            settings.classes.lightbox += addRandChars(10, '-');

            var lightbox = $('<a>', {
                href: '#_',
                'class': settings.classes.lightbox
            }).append('<img src="" />');
            
            $(element).prepend(lightbox).addClass(settings.classes.hasLightbox);
        }

        var setupImage = function() {
            // Get image ID and change parent link to point to the lightbox.

            // I do not want the article ID to appear in single post links.
            var post = (!isSinglePost) ? $(this).attr('src') : '';

            // Reduce URL to 1.jpg, 2.png, whatever.
            var number = $(this).attr('src').replace(/^.*\//g, '');

            if (!isSinglePost) {
                // Reduce URL to numeric post ID, and remove tailing slash.
                post = post.replace(/^[^\d]*/, '').replace(/\/.*/g, '');
            } else {
                settings.imgData.separator = '';
            }

            var data = {
                attr: 'data-' + settings.imgData.attribute,
                value: post + settings.imgData.separator + number
            };

            var href = '#' + data.value;

            // Set image data attribute and click action.
            $(this).attr(data.attr, data.value).parent().attr('href', href);
            $(this).on('click', showLightbox);
        }

        var showLightbox = function(event) {
            // Set lightbox ID and it's img src attribute.

            var lightbox = {
                selector: '.' + settings.classes.lightbox,
                id: $(this).data(settings.imgData.attribute),
                src: $(this).attr('src')
            };

            $(lightbox.selector).attr('id', lightbox.id);
            $(lightbox.selector).children('img').attr('src', lightbox.src);
        }

        init(this, args);
    }
})(jQuery, window, document);

jQuery('article a img').addLightbox();

/*
 * Comments Focus
 * -----------------------------------------------------------------------------
 * The CSS style associated with this is still incomplete. Goal is to have 
 * comment 'pop out' when clicked.
 */

jQuery('.comment').click(function() { 
    jQuery('.comment').not(this).removeClass('focused-comment');
    jQuery(this).addClass('focused-comment');
    return false;
});

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
