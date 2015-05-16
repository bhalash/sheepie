<?php 
/**
 * Container State Text and Class Determinations
 * -----------------------------------------------------------------------------
 * Functions to determine and set site state. 
 *
 * @category   PHP Script
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

/**
 * Get Lead Image for Header
 * -----------------------------------------------------------------------------
 * @param  int    $post_id
 * @return string $header_thumb         Thumbnail image, if it exists.
 */

function get_header_background($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $header_thumb = false;

    if (has_post_thumbnail($post_id)) {
        $header_thumb = get_post_thumbnail_url($post_id, 'large'); 
    } else if (has_content_image($post_id)) {
        $header_thumb = content_first_image($post_id);
    }

    return $header_thumb;
}

/**
 * Wrap Background Image in HTML Style
 * -----------------------------------------------------------------------------
 * @param  int    $post_id
 */

function header_background($post_id = null) {
    printf('style="background-image: url(%s);"', get_header_background($post_id));
}

/**
 * Set Header Class
 * -----------------------------------------------------------------------------
 * Set class if header has any available background image.
 *
 * @param   int    $post_id
 * @return  string                       Class for background iamge.
 */

function get_header_class($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    return (has_post_thumbnail($post_id) || has_content_image($post_id)) ? 'has-image' : 'no-image';
}

/**
 * Echo Header Class
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 */

function header_class($post_id = null) {
    printf(get_header_class($post_id));
}

/**
 * Set Title Based on Page Type
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 * @return  string  $page_title         Title of page.
 */

function get_page_title($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $page_title = '';

    if (!is_single() && !is_search()) {
        $page_title = sprintf('<a title="%s" href="%s">%s</a>',
            __('Go home'), get_bloginfo('url'),
            get_bloginfo('name')
        ); 
    } else if (is_search()) {
        $page_title = sprintf('%s \'%s\'',
            __('Results for'),
            get_search_query()
        ); 
    } else {
        // If single article or page.
        $page_title = sprintf('<a href="%s" rel="bookmark" title="%s %s">%s</a>', 
            get_the_permalink(),
            __('Permanent link to'), 
            get_the_title($post_id), 
            get_the_title($post_id)
        );
    }

    return $page_title;
}

/**
 * Echo Page Title Based on Page Type
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 */

function page_title($post_id = null) {
    printf(get_page_title($post_id));
}

?>