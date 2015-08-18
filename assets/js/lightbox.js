/**
 * Simple JavaScript Lightbox
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
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
            }
        };

        var settings = {};
        var isSinglePost = false;

        var init = function(element, args) {
            // Initialize lightbox and set up all the things.

            settings = $.extend({}, defaults, args);

            if (!$('body').hasClass(settings.classes.hasLightbox)) {
                /* 1. Check body class.
                 * 2. Set up each target image.
                 * 3. Prepend lightbox to body.
                 * 4. Once everything is ready, check URL for image hash. */
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
                var attr = settings.imgData.attribute;
                $('[data-' + attr + '="' + hash + '"]').trigger('click');
            }
        }

        var randChars = function(amount, divider) {
            // Generate stream of random chars prefixed by a dividing char.
            amount = amount || 10;
            divider = divider || '';

            return divider + Math.random()
                .toString(36)
                .replace(/[^a-z]+/g, '')
                .substr(0, amount);
        }

        var setupLightbox = function(element) {
            // Prepend lightbox to target element.

            // Append random chars to class to avoid conflicts.
            settings.classes.lightbox += randChars(10, '-');

            var lightbox = $('<a>', {
                href: '#_',
                'class': settings.classes.lightbox
            }).append('<img src="" />');
            
            $(element).prepend(lightbox).addClass(settings.classes.hasLightbox);
        }

        var setupImage = function() {
            // Get image ID and change parent link to point to the lightbox.

            // I do not want the article ID to appear in single post links.
            var hash = (!isSinglePost) ? randChars(4) : '';

            // Reduce URL to 1.jpg, 2.png, whatever.
            var number = $(this).attr('src').replace(/^.*\//g, '');

            if (isSinglePost) {
                settings.imgData.separator = '';
            }

            var data = {
                attr: 'data-' + settings.imgData.attribute,
                value: hash + settings.imgData.separator + number
            };

            var href = '#' + data.value;

            if (!$(this).parent().is('a')) {
                $(this).wrap('<a></a>');
            }

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
