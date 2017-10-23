<?php

/**
 * Main PHP Functions
 *
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$GLOBALS['sheepie_version'] = '1.1.3';

/**
 * Sheepie Setup
 */

add_action('after_setup_theme', function() {
    sheepie_includes();

    remove_action('wp_head', 'wp_generator');

    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    add_theme_support('title-tag');

    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');

    add_theme_support('html5', [
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
    ]);

    $GLOBALS['content_width'] = 880;

    $sheepie_social = new Social_Meta([
        'facebook' => 'bhalash',
        'twitter' => '@bhalash'
    ]);
});

/**
 * Theme Includes
 */

function sheepie_includes() {
    $theme_includes = [
        'includes/sheepie-assets.php',
        'includes/sheepie-comments.php',
        'lib/related-posts.php',
        'lib/archive-functions.php',
        'lib/article-images.php',
        'lib/social-meta.php'
    ];

    foreach ($theme_includes as $include) {
        require(get_template_directory() . '/' . $include);
    }
}

/**
 * Partial Wrapper
 *
 * Shorthand wrapper for get_template_part to reduce the verbosity of calls.
 *
 * @param   string      $name           Partial name.
 * @param   string      $slug           Partial slug.
 */

function sheepie_partial($name, $slug = '') {
    get_template_part('/partials/' . $name, $slug);
}

/**
 * Media Prefetch
 *
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 * Media prefetch domain: If null or empty, defaults to site domain.
 */

add_action('wp_head', function() {
    $prefetch = [
        'ix.bhalash.com', preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
    ];

    foreach ($prefetch as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
});

/**
 * Register Theme Widget Areas
 */

add_action('widgets_init', function() {
    register_sidebar([
        'id' => 'theme-widgets',
        'name' => __('Sheepie Footer Widgets', 'sheepie'),
        'description' => __('Sheepie\'s widgets will display in the mail column, below all other content.', 'sheepie'),
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ]);
});

/**
 * Register Theme Navigation Menus
 */

add_action('init', function() {
    register_nav_menus([
        'top-menu' => __('Header Menu', 'sheepie'),
        'top-social' => __('Header Social Links', 'sheepie')
    ]);
});

/**
 * Custom Search Link Icon
 *
 @return string         $wrap       Nav menu wrapped in string.
 */

function sheepie_nav_menu_search() {
    $search = sprintf(
        '<li class="%s"><a class="toggle" data-click="modal:show:search" href=""><span class="%s">%s</span></a></li>',
        'search menu-item menu-item-type-custom menu-item-object-custom social',
        'social__icon',
        __('Search', 'sheepie')
    );

    $wrap  = '<ul id="%1$s" class="%2$s">';
    $wrap .= '%3$s';
    $wrap .= $search;
    $wrap .= '</ul>';

    return $wrap;
}

/**
 * Add Social CSS Class to Menu Items
 *
 * Used to set social icon style.
 *
 * @param   array       $classes        Menu item classes.
 * @param   object      $item           Menu object.
 * @return  array       $classes        Menu item classes.
 */

add_filter('nav_menu_css_class', function($classes, $item) {
    $classes[] = 'social';
    return $classes;
}, 10, 2);

/**
 * Get Avatar URL
 *
 * @param   string  $id_or_email    Either user ID or email address.
 * @param   string  $classes        CSS classes to apply.
 * @param   string  $alt            Alt text to attach to the avatar.
 * @return  string                  The avatar's URL.
 */

function sheepie_avatar($id_or_email, $alt = '', $classes = '', $args = null) {
    $avatar = get_avatar_url($id_or_email, $args);
    return sprintf('<img class="%s" src="%s" alt="%s" />', $classes, $avatar, $alt);
}

/**
 * Post Meta Information
 *
 * Output post header information (category and date).
 */

function sheepie_postmeta() {
    printf('<a href="%s"><time rel="date" datetime="%s">%s</time></a>',
        get_month_link(get_the_time('Y'), get_the_time('n')),
        get_the_time('Y-m-d H:i'),
        get_the_time(get_option('date_format'))
    );

    _e(' in ', 'sheepie');
    the_category(', ');
    edit_post_link(__('edit post', 'sheepie'), ' / ', '');
}

/**
 * Remove empty paragraphs created by wpautop()
 *
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 * @param   string      $content
 * @return  string      $content
 */

add_filter('the_content', function($content) {
    $content = force_balance_tags($content);
    $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
    return $content;
}, 20, 1);

/**
 * Map ix.bhalash.com => d14688ez193dsv.cloudfront.net
 *
 * Test rewrite for purpose of identifying CDN failiures.
 *
 * @param string $content
 * @return string $content
 */

add_filter('the_content', function($content) {
    return preg_replace('/ix\.bhalash\.com/', 'd14688ez193dsv.cloudfront.net', $content);
}, 20, 1);

?>
