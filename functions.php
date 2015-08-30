<?php

/**
 * Main PHP Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

$GLOBALS['sheepie_version'] = 2.1;

/**
 * Sheepie Setup
 * -----------------------------------------------------------------------------
 */

function sheepie_setup() {
    // All theme PHP.
    sheepie_includes(); 

    // Header tag DNS prefetch.
    sheepie_dns_prefetch();

    add_action('init', 'sheepie_theme_navigation');
    add_action('widgets_init', 'sheepie_theme_widgets');
    add_action('wp_head', 'sheepie_dns_prefetch');
    remove_action('wp_head', 'wp_generator');

    $GLOBALS['content_width'] = 880;

    add_filter('wp_title', 'sheepie_title', 10, 2);
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
    ));

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
        'sheepie-archives.php',
        'sheepie-comments.php',
        'sheepie-related-posts.php',
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
 * Blog Title
 * -----------------------------------------------------------------------------
 * Stolen from Twenty Twelve. 
 * 
 * @param   string      $title          Title of whatever.
 * @param   string      $sep            Title separator.
 * @return  string      $title          Modded title.
 */

function sheepie_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    $title .= get_bloginfo('name');
    $site_description = get_bloginfo('description', 'display');

    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'sheepie'), max($paged, $page));
    }

    return $title;
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

/**
 * Generate Ascending and Descending Search Link
 * -----------------------------------------------------------------------------
 * @param   string      $order          'asc' or 'desc'
 * @param   bool        $echo           Echo it, true/false.
 * @return  string      $url            Generated URL.
 */

function sheepie_search_url($order = null, $echo = true) {
    if (!$order) {
        $order = 'asc';
    }

    $query = get_search_query();
    $url = array();

    $url[] = esc_url(home_url('/')); 
    $url[] = '?s=';
    $url[] = esc_attr($query);
    $url[] = '&sort=date';
    $url[] = '&order=';
    $url[] = $order;

    $url = implode('', $url);

    if (!$echo) {
        return $url;
    }

    printf($url);
}

/**
 * Register Theme Widget Areas
 * -----------------------------------------------------------------------------
 */

function sheepie_theme_widgets() {
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

/**
 * Register Theme Navigation Menus
 * -----------------------------------------------------------------------------
 */

function sheepie_theme_navigation() {
    register_nav_menus(array(
        'top-menu' => __('Header Menu', 'sheepie'),
        'top-social' => __('Header Social Links', 'sheepie')
    ));
}

?>
