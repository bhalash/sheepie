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
 */

jQuery('pre').each(function() {
    if (jQuery(this).find('code').length === 0) {
        jQuery(this).wrapInner('<code></code>');
    }
});

hljs.initHighlightingOnLoad();

/**
 * Article Photobox
 * -----------------------------------------------------------------------------
 * Wordpress inserts a line break if it find a wayward space or line break in 
 * the post texarea. This can cause every other item in the photobox to be 
 * irregularly sized. I remove breaks in order to circumvent this.
 */

jQuery('.article-photobox br').remove();

/*
 * Comments Focus
 * -----------------------------------------------------------------------------
 */

jQuery('.comment').click(function() { 
    jQuery('.comment').not(this).removeClass('focused-comment');
    jQuery(this).addClass('focused-comment');
});

// jQuery(function($) {
//     'use strict';
//     /*
//      * Cover Scroll Prompt
//      * -------------------
//      */

//     $('#header .prompt').click(function() {
//         $('html, body').animate({ 
//             scrollTop: $('#content').offset().top
//         }, 500);

//         return false;
//     });

//     /*
//      * Search Form Focusing
//      * --------------------
//      */

//     var search = {
//         form: '.search',
//         input: '.search-text',
//         results: '.page-search',
//         url: window.location.host + '/search/',
//         nav: {
//             toggle: 'a[title=Search]',
//             body: '.nav-search',
//             open: false
//         }
//     };

//     if (search.results.length > 0) {
//         $(search.results).find(search.input).focus();
//     }

//     $(search.nav.toggle).click(function() {
//         $(search.nav.body).slideDown(200, function() {
//             $(search.nav.body).find(search.input).focus();
//         });

//         if (!search.nav.open) {
//             search.nav.open = true;
//             return false;
//         }
//     });

//     $(search.form).submit(function(click) {
//         if ($(search.input).val() === '') {
//             click.preventDefault();
//             window.location.href = search.url;
//         }
//     });
// });