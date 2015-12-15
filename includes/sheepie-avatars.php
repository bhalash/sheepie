<?php

/**
 * Avatar Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
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

function sheepie_get_avatar_url($avatar, $id_or_email, $size, $default, $alt) {
   if (!is_admin()) {
        $avatar = preg_replace('/(^.*src=("|\')|("|\')\ssrcset.*$)/', '', $avatar);
   }

   return $avatar;
}

add_filter('get_avatar', 'sheepie_get_avatar_url', 10, 5);

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

function sheepie_avatar_background_html($id_or_email, $size = 'large', $classes = null, $echo = true) {
    $avatar = get_avatar($id_or_email, $size);
    $background = sprintf('background-image: url(%s);', $avatar);

    if ($classes) {
        if (is_array($classes)) {
            $classes = implode(' ', $classes);
        }

        $classes = sprintf(' class="%s"', $classes);
    }

    $html = sprintf('<div%s style="%s"></div>',
        $classes,
        $background
    );

    if (!$echo) {
        return $html;
    }

    printf($html);
}

?>
