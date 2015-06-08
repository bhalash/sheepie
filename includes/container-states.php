<?php 
/**
 * 
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
 * Return Thumbnail Image URL
 * -----------------------------------------------------------------------------
 * Taken from: http://goo.gl/NhcEU6
 * 
 * WordPress, by default, only has a handy function to return a glob of HTML
 * -an image inside an anchor-for a post thumbnail. This wrapper extracts
 * and returns only the URL.
 * 
 * @param   int     $post_id        The ID of the post.
 * @param   int     $thumb_size     The requested size of the thumbnail.
 * @param   bool    $return_arr     Return either the entire thumbnail object or just the URL.
 * @return  string  $thumb_url[0]   URL of the thumbnail.
 * @return  array   $thumb_url      All information on the attachment.
 */

function get_post_thumbnail_url($post_id = null, $thumb_size = 'large', $return_arr = false) {

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id, $thumb_size, true);
    return ($return_arr) ? $thumb_url : $thumb_url[0];
}

/**
 * Retrive first image in content.
 * -----------------------------------------------------------------------------
 * I chose not to use the featured image feature in WordPress, because
 * I do not want to be ultimately tied to WordPress as a blogging CMS.
 * 
 * This functions extracts and returns the first found image in the post,
 * no matter what that image happens to be.
 * 
 * See: http://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post
 *
 * @param   int     $post_id        ID of candidate post.
 * @return  string                  Full URL of the first image found.
 */

function content_first_image($post_id = null) {
    global $post, $posts;
    $content = '';
    $matched = array();

    if (is_null($post_id)) { 
        $content = get_post($post_id);
        $content = $content->post_content;
    } else {
        $content = $post->post_content;
    }

    $first_image = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    $first_image = $matches[1][0];
    return (!empty($first_image)) ? $first_image : false;
}

/**
 * Determine if Post Content has an Image
 * -----------------------------------------------------------------------------
 * Because I habitually do not use post thumbnails, I need to instead determine
 * whether the post's content has an image, and thereafter I grab the first one. 
 * 
 * @param   int     $post_id        ID of candidate post.
 * @return  bool                    Post content has image true/false.
 */

function has_content_image($post_id = null) {
    global $post;
    $content = '';

    if (is_null($post_id)) { 
        $content = get_post($post_id);
        $content = $content->post_content;
    } else {
        $content = $post->post_content;
    }

    return (preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content));
}


/**
 * Get Post Image for Background
 * -----------------------------------------------------------------------------
 *  
 * @param  int    $post_id
 * @return string $header_thumb         Thumbnail image, if it exists.
 */

function get_post_image($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $post_image = false;

    if (has_post_thumbnail($post_id)) {
        $post_image = get_post_thumbnail_url($post_id, 'large'); 
    } else if (has_content_image($post_id)) {
        $post_image = content_first_image($post_id);
    }

    return $post_image;
}

/**
 * Wrap Background Image in HTML Style
 * -----------------------------------------------------------------------------
 * @param  int    $post_id
 */

function post_image_background($post_id = null) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    if (has_content_image($post_id)) {
        printf('style="background-image: url(%s);"', get_post_image($post_id));
    }
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