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

(function(lightbox, $) {
    lightbox.box = 'rmwb-lightbox';
    lightbox.target = 'article a img';
    lightbox.data = 'id';

    String.prototype.addRand = function(spacer, number) {
        var rand = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, number);
        return this + spacer + rand;
    }

    lightbox.checkHash = function() {
        var hash = window.location.hash.substring(1);

        if (!!hash && hash.match(/\d{1,11}-\d/)) {
            $('[data-' + lightbox.data + '=' + hash + ']').trigger('click');
        }
    }

    lightbox.setup = function() {
        $('body').addLightbox();
        $(lightbox.target).each(lightbox.addData);
        $('article').on('click', 'img', lightbox.show);
        lightbox.checkHash();
    }

    lightbox.show = function(event) {
        var box = '.' + lightbox.box;
        var id = $(this).data(lightbox.data);
        var src = $(this).attr('src');

        $(box).attr(lightbox.data, id);
        $(box + ' img').attr('src', src);
    }

    lightbox.addData = function() {
        var post = $(this).attr('src').replace(/^[^\d]*/, '').replace(/\/.*/g, '');
        var number = $(this).attr('src').replace(/^.*\//g, '').replace(/\..*/, '');
        var id = post + '-' + number;
        $(this).attr('data-' + lightbox.data, id).parent().attr('href', '#' + id);
    }

    $.fn.addLightbox = function(type) {
        type = type || lightbox.box;
        lightbox.box = type.addRand('-', 5);
        this.prepend('<a href="#_" class="' + lightbox.box+ '"><img src="" /></a>');
        return this;
    }

    lightbox.setup();
})(window.lightbox = window.lightbox || {}, jQuery);

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
