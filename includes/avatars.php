<?php

/**
 * Avatar Functions
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
 * Get Avatar URL
 * -----------------------------------------------------------------------------
 * Wrapper for get_avatar that only returns the URL. Yes, WordPress added a
 * get_avatar_url() function in version 4.2. The Tuairisc site, however, uses
 * a plugin named WP User Avatar (https://wordpress.org/plugins/wp-user-avatar/)
 * to upload and serve avatars from a local source.
 *
 * 1. WP User Avatar hooks into get_avatar()
 * 2. As of April 29 2015 the plugin does not support the new get_avatar_data()
 *    and get_avatar_url() functions.
 *
 * That is to say both new functions will stil only serve from Gravatar without
 * consideration of locally-uploaded avatars.
 *
 * @param   string  $id_or_email    Either user ID or email address.
 * @param   int     $size           Avatar size.
 * @param   string  $default        URL for fallback avatar.
 * @param   string  $alt            Alt text for image.
 * @return  string                  The avatar's URL.
 */

function get_avatar_url_only($avatar, $id_or_email, $size, $default, $alt) {
    if (!is_admin()) {
        $avatar = preg_replace('/(^.*src="|"\s.*$)/', '', $avatar);
   }

   return $avatar;
}

/**
 * Avatar as Background Image
 * -----------------------------------------------------------------------------
 * Not a filter for get_avatar. Return avatar as a background image wrapped with
 * some useful HTML.
 * 
 * @param   string  $id_or_email    Either user ID or email address.
 * @param   int     $size           Avatar size.
 * @param   arr     $classes        Classes to add to element.
 * @return  string  $html           Avatar HTML.
 */

function get_avatar_background($id_or_email, $size = 'large', $classes = null) {
    if (!($author = get_user_by('id', $id_or_email))) {
        return false;
    }

    $avatar = get_avatar($id_or_email, $size);
    $background = sprintf('background-image: url(%s);', $avatar);

    if ($classes) {
        if (is_array($classes)) {
            $classes = implode(' ', $classes); 
        }

        $classes = sprintf(' class="%s"', $classes);
    }

    $html = sprintf('<div%s style="%s"><a title="%s" href="%s"></a></div>',
        $classes,
        $background,
        $author->display_name,
        get_author_posts_url($author->ID)
    );

    return $html;
}

/**
 * Print Avatar Background Image
 * -----------------------------------------------------------------------------
 * Not a filter for get_avatar. Return avatar as a background image wrapped with
 * some useful HTML.
 * 
 * @param   string  $id_or_email    Either user ID or email address.
 * @param   int     $size           Avatar size.
 * @param   arr     $classes        Classes to add to element.
 */

function avatar_background($id, $size = 'large', $classes = null) {
    echo get_avatar_background($id, $size, $classes);
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

add_filter('get_avatar', 'get_avatar_url_only', 10, 5);

?>
