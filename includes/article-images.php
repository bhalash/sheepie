<?php

/**
 * Article Image Functions
 * -----------------------------------------------------------------------------
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
 * @return  bool                    Return false if no image found.
 */

function content_first_image($post_id = null) {
    $content = '';
    $matches = array();

    if (is_null($post_id)) { 
        global $post;
        $content = $post->post_content;
    } else {
        $content = get_post($post_id)->post_content;
    }

    preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    return (!empty($matches[1])) ? $matches[1] : false;
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

function content_has_image($post_id = null) {
    if (is_null($post_id)) { 
        global $post;
        $content = $post->post_content;
    } else {
        $content = get_post($post_id)->post_content;
    }

    return (strpos($content, '<img src') !== false);
}

/**
 * Get Post Image for Background
 * -----------------------------------------------------------------------------
 * Get either the thumbnail image, if it exists, or alternatively the first 
 * image found in the post's content.
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
    } else if (content_has_image($post_id)) {
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

    if (content_has_image($post_id)) {
        printf('style="background-image: url(%s);"', get_post_image($post_id));
    }
}

?>