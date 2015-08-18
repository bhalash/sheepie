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

define('THEME_VERSION', 2.0);

/**
 * Theme File Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

/**
 * Theme Asset Paths
 * -----------------------------------------------------------------------------
 */

define('ASSETS_PATH', THEME_PATH . '/assets/');
define('ASSETS_URL', THEME_URL . '/assets/');

/**
 * Theme Includes and Partials Paths
 * -----------------------------------------------------------------------------
 * File paths are inconsistent between get_template_part() and include() or
 * require(). 
 * 
 * 1. With include(), / is the ultimate root on the filesystem, as provided by 
 *    get_template_directory();
 * 2. With get_template_parth(), / is the WordPress theme folder. 
 * 
 * Included files are entire standalone scripts, and partials are partials 
 * templates.
 */

define('THEME_INCLUDES',  THEME_PATH . '/includes/');
define('THEME_PARTIALS',  '/partials/');

/**
 * Theme Partial Templates
 * -----------------------------------------------------------------------------
 */

define('PARTIAL_ARTICLES', THEME_PARTIALS . 'articles/article');
define('PARTIAL_ARCHIVES', THEME_PARTIALS . 'archives/archive');
define('PARTIAL_PAGES',    THEME_PARTIALS . 'pages/');

/**
 * Image, CSS and JavaScript Assets
 * -----------------------------------------------------------------------------
 */

define('THEME_JS', ASSETS_URL . 'js/');
define('THEME_IMAGES', ASSETS_URL . 'images/');
define('THEME_CSS', ASSETS_URL . 'css/');

/**
 * Theme Text Domain
 * -----------------------------------------------------------------------------
 */

define('TTD', 'sheepie');

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

$theme_includes = array(
    'theme-css.php',
    'theme-js.php',
    'blog-archives.php',
    'social-meta/social-meta.php',
    'reading-times.php',
    'related.php',
    'avatars.php'
);

foreach ($theme_includes as $include) {
    include_once(THEME_INCLUDES . $include);
}

/**
 * Misc Variables
 * -----------------------------------------------------------------------------
 */

$sheepie_social = new Social_Meta(array(
    // Facebook and Twitter social media information.
    'facebook' => 'bhalash',
    'twitter' => '@bhalash'
));

// Media prefetch domain: If null or empty, defaults to site domain.
$prefetch_domains = array(
    'ix.bhalash.com', preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
);

// Path to favicon.
$favicon_path = THEME_IMAGES . 'favicon.png';

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

    return (has_post_thumbnail($post_id) || has_post_image($post_id)) ? 'has-image' : 'no-image';
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
        $title = "$title $sep " . sprintf( __( 'Page %s', TTD), max( $paged, $page ) );
    }

    return $title;
}

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function dns_prefetch() {
    global $prefetch_domains;

    foreach ($prefetch_domains as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
}

/**
 * Search Result Count
 * -----------------------------------------------------------------------------
 * Return a count of results for the search in the format 
 * 'Results 1 to 10 of 200'
 * 
 * @param   int     $page_num       Current page nunber.
 * @param   int     $total_results  Total number of search results.
 * @return  string                  Count of results.
 */

function search_results_count($page_num, $total_results) {
    $page_num = ($page_num === 0) ? 1 : $page_num;
    $posts_per_page = get_option('posts_per_page');
    $count_high = $page_num * $posts_per_page;
    $count_low  = ($count_high - $posts_per_page) + 1;
    $count_high = ($count_high > $total_results) ? $total_results : $count_high;
    return 'Results ' . $count_low . ' to ' . $count_high . ' of ' . $total_results;
}

/**
 * Rewrite Search URL Cleanly
 * -----------------------------------------------------------------------------
 * Cleanly rewrite search URL from ?s=topic to /search/topic
 *
 * @link    http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 */

function clean_search_url() {
    if (is_search() && ! empty($_GET['s'])) {
        wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
        exit();
    }
}

/**
 * Pagination Post Counter
 * -----------------------------------------------------------------------------
 * Fetch and display total post count in format of 'Page 1 of 10'.
 * This only counts published, public posts; drafts, pages, custom
 * post types and private posts are all excluded unless you specify
 * inclusion.
 * 
 * @param   int     $page_num       Current page in pagination.
 * @param   int     $total_results  Total results, for pagination.
 * @return  string                  The post counter.
 */

function archive_page_count($echo = false, $page_num = null, $total_results = null) {
    global $wp_query;

    if (is_null($total_results)) {
        $total_results = $wp_query->found_posts;
    }

    if (is_null($page_num)) {
        $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    $posts_per_page = get_option('posts_per_page');
    $total_pages = ceil($total_results / $posts_per_page);
    $page_count = sprintf(__('Page %s of %s', TTD), $page_num, $total_pages);

    if (!$echo) {
        return $page_count;
    }

    printf($page_count);
}

/**
 * Register Theme Widget Areas
 * -----------------------------------------------------------------------------
 */

function theme_widgets() {
    register_sidebar(array(
        'name' => 'Dynamic sidebar.',
        'id' => 'dynamicsidebar',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="sidebar-title">',
        'after_title' => '</h6>',
    ));
}

/**
 * Register Theme Navigation Menus
 * -----------------------------------------------------------------------------
 */

function theme_navigation() {
    register_nav_menus(array(
        'top-menu' => __('Header Menu', TTD),
        'top-social' => __('Header Social Links', TTD)
    ));
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

if (!isset($content_width)) {
    $content_width = 600;
}

add_action('init', 'theme_navigation');
add_action('widgets_init', 'theme_widgets');

// Set site favicon.
add_action('wp_head', 'set_favicon');
// Set prefetch domain for media.
add_action('wp_head', 'dns_prefetch');


// Clean search URL rewrite.
add_action('template_redirect', 'clean_search_url');
remove_action('wp_head', 'wp_generator');

/**
  * Filters 
  * ----------------------------------------------------------------------------
  */

// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Title function.
add_filter('wp_title', 'sheepie_title', 10, 2);

/**
 * Theme Support
 * -----------------------------------------------------------------------------
 */

// HTML5 support in theme.
current_theme_supports('html5');
current_theme_supports('menus');

add_theme_support('post-thumbnails');

add_theme_support('html5', array(
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
));        

?>
