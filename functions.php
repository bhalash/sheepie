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

function sheepie_setup() {
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

    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
    ));

    // Content width.
    $GLOBALS['content_width'] = 880;

    $sheepie_social = new Social_Meta(array(
        // Facebook and Twitter social media information.
        'facebook' => 'bhalash',
        'twitter' => '@bhalash'
    ));
}

add_action('after_setup_theme', 'sheepie_setup');

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

function sheepie_includes() {
    $theme_includes = array(
        'sheepie-scripts.php',
        'sheepie-avatars.php',
        'sheepie-comments.php',
        'related-posts/related-posts.php',
        'archive-functions/archive-functions.php',
        'social-meta/social-meta.php'
    );

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
 * @param   strgin      $slug           Partial slug.
 */

function sheepie_partial($name, $slug = '') {
    get_template_part('/partials/' . $name, $slug);
}

/**
 * Set Title Based on Page Type
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 * @return  string  $page_title         Title of page.
 */

function sheepie_page_title($post_id = null, $echo = false) {
    if (is_null($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $page_title = '';

    if (!is_single() && !is_search()) {
        $page_title = sprintf('<a title="%s" href="%s">%s</a>',
            __('Go home', 'sheepie'), esc_url(home_url()),
            get_bloginfo('name')
        ); 
    } else if (is_search()) {
        $page_title = sprintf('%s \'%s\'',
            __('Results for', 'sheepie'),
            get_search_query()
        ); 
    } else {
        // If single article or page.
        $page_title = sprintf('<a href="%s" rel="bookmark" title="%s %s">%s</a>', 
            get_the_permalink(),
            __('Permanent link to', 'sheepie'), 
            get_the_title($post_id), 
            get_the_title($post_id)
        );
    }

    if (!$echo) {
        return $page_title;
    }

    printf($page_title);
}

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function sheepie_dns_prefetch() {
    // Media prefetch domain: If null or empty, defaults to site domain.
    $prefetch = array(
        'ix.bhalash.com', preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
    );

    foreach ($prefetch as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
}

add_action('wp_head', 'sheepie_dns_prefetch');

/**
 * Register Theme Widget Areas
 * -----------------------------------------------------------------------------
 */

function sheepie_widgets() {
    register_sidebar(array(
        'id' => 'theme-widgets',
        'name' => __('Sheepie Footer Widgets', 'sheepie'),
        'description' => __('Sheepie\'s widgets will display in the mail column, below all other content.', 'sheepie'),
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

// Them widget areas.
add_action('widgets_init', 'sheepie_widgets');

/**
 * Register Theme Navigation Menus
 * -----------------------------------------------------------------------------
 */

function sheepie_menus() {
    register_nav_menus(array(
        'top-menu' => __('Header Menu', 'sheepie'),
        'top-social' => __('Header Social Links', 'sheepie')
    ));
}

// Theme menus.
add_action('init', 'sheepie_menus');

/**
 * Post Meta Information
 * -----------------------------------------------------------------------------
 * Output post header information (category and date).
 */

function kaitain_postmeta() {

    printf('<time datetime="%s">%s</time>',
        get_the_time('Y-m-d H:i'),
        get_the_time(get_option('date_format'))
    );

    _e(' in ', 'sheepie');
    the_category(', ');
    edit_post_link(__('edit post', 'sheepie'), ' / ', ''); 
}

?>
