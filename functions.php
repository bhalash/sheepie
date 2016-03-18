<?php

/**
 * Main PHP Functions
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
 */

add_action('after_setup_theme', function() {
    // All theme PHP.
    sheepie_includes();

    // Remove WordPress version from site header.
    remove_action('wp_head', 'wp_generator');

    // Remove the fuck out of emoji and emoticons.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Tell WordPress to manage the site title itself.
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

    // Content width.
    $GLOBALS['content_width'] = 880;

    $sheepie_social = new Social_Meta([
        // Facebook and Twitter social media information.
        'facebook' => 'bhalash',
        'twitter' => '@bhalash'
    ]);
});

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

function sheepie_includes() {
    $theme_includes = [
        'sheepie-scripts.php',
        'sheepie-avatars.php',
        'sheepie-comments.php',
        'related-posts/related-posts.php',
        'archive-functions/archive-functions.php',
        'social-meta/social-meta.php'
    ];

    foreach ($theme_includes as $include) {
        include_once(get_template_directory() . '/includes/' . $include);
    }
}

/**
 * Partial Wrapper
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

add_action('wp_head', function() {
    // Media prefetch domain: If null or empty, defaults to site domain.
    $prefetch = [
        'ix.bhalash.com', preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
    ];

    foreach ($prefetch as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
});

/**
 * Register Theme Widget Areas
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
 */

add_action('init', function() {
    register_nav_menus([
        'top-menu' => __('Header Menu', 'sheepie'),
        'top-social' => __('Header Social Links', 'sheepie')
    ]);
});

/**
 * Post Meta Information
 * -----------------------------------------------------------------------------
 * Output post header information (category and date).
 */

function sheepie_postmeta() {
    printf('<a href="%s"><time datetime="%s">%s</time></a>',
        get_month_link(get_the_time('Y'), get_the_time('n')),
        get_the_time('Y-m-d H:i'),
        get_the_time(get_option('date_format'))
    );

    _e(' in ', 'sheepie');
    the_category(', ');
    edit_post_link(__('edit post', 'sheepie'), ' / ', '');
}

/**
 * Add Knockout.js Lightbox Data Binding
 * -----------------------------------------------------------------------------
 * Output post header information (category and date).
 *
 * @param   string      $content        The post content.
 * @return  string      $content        Post content with added directives.
 */

add_filter('the_content', function($content) {
    return str_replace('<img', '<img data-bind="click: showLightbox"', $content);
});

/**
 * Add Social CSS Class to Menu Items
 * -----------------------------------------------------------------------------
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

?>
