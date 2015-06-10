<?php

/**
 * Main PHP Functions
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

define('THEME_VERSION', 2.0);

/**
 * Theme File Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_ROOT', get_template_directory_uri());

/**
 * Theme Includes and Partials Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_INCLUDES', get_template_directory() . '/includes/');
define('THEME_PARTIALS', '/partials/');
define('THEME_ARTICLES', THEME_PARTIALS . '/articles/article');
define('THEME_ARCHIVES', THEME_PARTIALS . '/archives/archive');
define('THEME_PAGES', THEME_PARTIALS . '/pages/');

/**
 * Theme Asset Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_ASSETS', THEME_ROOT . '/assets/');
define('THEME_JS', THEME_ASSETS . 'js/');
define('THEME_IMAGES', THEME_ASSETS . 'images/');
define('THEME_CSS', THEME_ASSETS . 'css/');

/**
 * Template Default/Fallback Image
 * -----------------------------------------------------------------------------
 */

define('FALLBACK_IMAGE', THEME_IMAGES . 'fallback.jpg');

/**
 * Theme Text Domain
 * -----------------------------------------------------------------------------
 */

define('TTD', 'sheepie');

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

include(THEME_INCLUDES . 'reading-times.php');
include(THEME_INCLUDES . 'social-meta.php');
include(THEME_INCLUDES . 'article-images.php');

/**
 * Other Variables
 * -----------------------------------------------------------------------------
 */

// Media prefetch domain: If null or empty, defaults to site domain.
$prefetch_domains = array(
    'ix.bhalash.com', preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
);

// Path to favicon.
$favicon_path = THEME_IMAGES . 'favicon.png';

/**
 * Enqueue Styles and Scripts
 * -----------------------------------------------------------------------------
 */

$google_fonts = array(
    // All Google Fonts to be loaded.
    'Open Sans:300,400,700,800',
    'Source Code Pro:300,400',
);

$theme_javascript = array(
    'browser-detect' => THEME_JS . 'browser_detect.min.js',
    /* ¡Important! highlight.js /must/ be loaded before functions.js or it will
     * not initialize correctly! The initializing function is called at the top
     * functions.js */ 
    'highlight-js' => THEME_JS . 'highlight.js',
    'google-analytics' => THEME_JS . 'analytics.js',
    'functions' => THEME_JS . 'functions.min.js'
);

$theme_styles = array(
    // Compressed, compiled theme CSS.
    'main-style' => THEME_CSS . 'main.css',
    // WordPress style.css. Not really used.
    'wordpress-style' => THEME_ROOT . '/style.css',
);

/**
 * Social Meta Defaults
 * -----------------------------------------------------------------------------
 */

$social_fallback = array(
    // Social fallback is called in cases where the post is missing n info.
    'publisher' => 'http://www.bhalash.com',
    'image' => FALLBACK_IMAGE,
    'description' => get_bloginfo('description'),
    'twitter' => '@bhalash'
);

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function google_font_url($fonts) {
    global $google_fonts;
    $google_url = array('//fonts.googleapis.com/css?family=');

    foreach ($fonts as $key => $value) {
        $google_url[] = str_replace(' ', '+', $value);

        if ($key < sizeof($google_fonts) - 1) {
            $google_url[] = '|';
        }
    }

    return implode('', $google_url);
}

/** 
 * Load Theme JavaScript
 * -----------------------------------------------------------------------------
 * Load all theme JavaScript.
 */

function load_theme_scripts() {
    global $theme_javascript;

    if (!is_admin()) {
        /* Load jQuery into the footer instead of the header.
         * See: http://biostall.com/how-to-load-jquery-in-the-footer-of-a-wordpress-website */
        wp_deregister_script('jquery');
        wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.11.1', true);
        wp_enqueue_script('jquery');
    }

    foreach ($theme_javascript as $name => $script) {
        if (WP_DEBUG) {
            // Load unminified versions while debugging.
            $script = str_replace('.min', '', $script);
        }

        wp_enqueue_script($name, $script, array('jquery'), THEME_VERSION, true);
    }
}

/**
 * Load Theme Custom Styles
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function load_theme_styles() {
    global $theme_styles, $google_fonts;

    foreach ($theme_styles as $name => $style) {
        wp_enqueue_style($name, $style, array(), THEME_VERSION);
    }

    if (!empty($google_fonts)) {
        wp_register_style('google-fonts', google_font_url($google_fonts));
        wp_enqueue_style('google-fonts');
    }
}

/**
 * Get the Blog's Age
 * -----------------------------------------------------------------------------
 * Return the age of the blog in $format. Defaults to days.
 * 
 * See: https://php.net/manual/en/datetime.diff.php
 * See: https://php.net/manual/en/class.dateinterval.php 
 * 
 * @param   string      $format         DateInterval format.
 * @param   string      $blog_age       Age of the blog in $format.
 */

function blog_age($format = '%a') {
    $first_post_date = new DateTime(get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    $last_post_date = new DateTime(get_posts(array(
        'posts_per_page' => 1
    ))[0]->post_date);

    return $first_post_date->diff($last_post_date)->format($format);
}

/**
 * Convert Number to Month
 * -----------------------------------------------------------------------------
 * See: https://stackoverflow.com/questions/18467669/convert-number-to-month-name-in-php
 * 
 * @param  int          $number             The month of the year as a number.
 * @param  string                           The month as a word.
 */

function get_month_from_number($number) {
    return date_create_from_format('!m', $number % 12)->format('F');
}

/**
 * Generate Dated Archive Post Count
 * -----------------------------------------------------------------------------
 * Generate the initial count of posts by year and month, and save it under the
 * given options key. Generating this can be resource intensive, so it makes 
 * sense to store this as a variable.
 * 
 * See: https://wordpress.stackexchange.com/questions/60859/post-count-per-day-month-year-since-blog-began
 * 
 * @param   string      $option_name        Options key for the post count.
 * @return  array       $counts             Returned counts for the 
 */

function timed_archives_count() {
    global $wpdb;

    /* Get the year of the first post: 
     * -------------------------------------------------------------------------
     * 1. Get 1 post in ascending order. This is the first post on the blog.
     * 2. Extract the date of the post.
     * 3. Parse that down to the year alone. */
    $from_date = preg_replace('/-.*/', '', get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    for ($i = date('Y'); $i >= $from_date; $i--) {
        $counts[$i] = array();

        $month = $wpdb->get_results($wpdb->prepare(
            "SELECT MONTH(post_date) AS post_month, count(ID) AS post_count from " .
            "{$wpdb->posts} WHERE post_status = 'publish' AND YEAR(post_date) = %d " .
            "GROUP BY post_month;", $i
        ), OBJECT_K);

        foreach ($month as $m) {
            $counts[$i][$m->post_month] = $m->post_count;
        }
    }

    return $counts;
}

/**
 * Generate Category Archive Post Count
 * -----------------------------------------------------------------------------
 * Generate the initial count of posts by year and month, and save it under the
 * given options key. Generating this can be resource intensive, so it makes 
 * sense to store this as a variable.
 * 
 * See: https://wordpress.stackexchange.com/questions/60859/post-count-per-day-month-year-since-blog-began
 * 
 * @param   string      $option_name        Options key for the post count.
 * @return  array       $counts             Returned counts for the 
 */

function category_archives_count() {

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
 * Post Interval Average
 * -----------------------------------------------------------------------------
 * Return the blog's posts per day, rounded to $percision.
 * 
 * @param   int     $precision          Rounding precision.
 * @return  int     $posts_per_day      Number of posts per day.
 */

function post_interval($precision = 2) {
    $blog_age_days = blog_age('%a');
    $post_count = wp_count_posts()->publish;
    return round($blog_age_days / $post_count, $precision);
}

/**
 * Print Comment Authors
 * -----------------------------------------------------------------------------
 */

function comment_authors_count() {
    printf(get_comment_author_count());
}

/*
 * Print Blog Statistics
 * -----------------------------------------------------------------------------
 * Rattle off some useful statistics about the age and amount of content on the 
 * blog.
 */

function blog_statistics() {
    printf(__('The blog <a title="%s" href="%s">%s</a> has %s posts in %s categories, that are labelled with %s tags. ', TTF),
        get_bloginfo('name'),
        home_url(),
        get_bloginfo('name'),
        wp_count_posts()->publish,
        count(get_categories()),
        count(get_tags())
    );

    printf(__('%s different visitors have left a total of %s comments. ', TTF),
        get_comment_authors_count(),
        wp_count_comments()->total_comments
    );

    printf(__('On average, a new post has been published every %s days over the last %s days.', TTF),
        post_interval(),
        blog_age()
    );
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
 * Load Favicon
 * -----------------------------------------------------------------------------
 */

function set_favicon() {
    global $favicon_path;
    printf('<link rel="icon" type="image/png" href="%s" />', $favicon_path);
}

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
 * @param   string                  The avatar's URL.
 */

function get_avatar_url_only($id_or_email, $size, $default, $alt) {
   $avatar = get_avatar($id_or_email, $size, $default, $alt); 
   return preg_replace('/(^.*src="|"\s.*$)/', '', $avatar); 
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
 * See: http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 */

function clean_search_url() {
    if (is_search() && ! empty($_GET['s'])) {
        wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
        exit();
    }
}

/**
 * Custom Theme Excerpt
 * -----------------------------------------------------------------------------
 * I forget why I did this.
 * 
 * @param   string   $excerpt
 * @return  string   $excerpt
 */

function custom_excerpt($excerpt) {
    $excerpt = get_the_content(); 
    $excerpt = strip_shortcodes($excerpt); 
    $excerpt = strip_tags($excerpt); 
    $excerpt = explode('.', $excerpt);
    $excerpt = $excerpt[0]; 
    $length = strlen(preg_replace(array('/\s/', '/\n/'), '', $excerpt)); 
    return $excerpt;
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
 * @param   string  $type           Type of post to use.
 * @return  string                  The post counter.
 */

function archive_page_count($page_num = null, $total_results = null, $type = null) {
    if (is_null($page_num)) {
        $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    if (is_null($type)) {
        $type = 'post';
    }

    if (is_null($total_results)) {
        $total_results = wp_count_posts($type, 'readable')->publish;

        if (is_user_logged_in()) {
            $total_results += wp_count_posts($type, 'readable')->private;
        }
    }

    $posts_per_page = get_option('posts_per_page');
    $total_pages = ceil($total_results / $posts_per_page);
    printf(__('Page %s of %s', TTD), $page_num, $total_pages);
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
 * Count Comment Authors
 * -----------------------------------------------------------------------------
 * WordPress doesn't appear to have a convenient way to count unique comment
 * authors. 
 * 
 * @return int      $count          count of comment authors.
 */

function get_comment_authors_count() {
    $authors = array();

    foreach (get_comments() as $comment) {
        if (!in_array($comment->comment_author_email, $authors)) {
            if (!empty($comment->comment_author_email)) {
                $authors[] = $comment->comment_author_email;
            }
        }
    }

    return count($authors);
}

/**
 * Custom Comment and Comment Form Output
 * -----------------------------------------------------------------------------
 * @param   string  $comment    The comment.
 * @param   array   $args       Array argument 
 * @param   int     $depth      Depth of the comments thread.
 */

function rmwb_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="avatar-wrapper">
            <?php echo get_avatar($comment, 75); ?>
        </div>
        <div class="comment-interior">
            <header>
                <p class="author"><?php comment_author_link(); ?></p>
                <p class="date"><small><?php printf(__('%1$s at %2$s', TTD), get_comment_date(), get_comment_time()); ?></small></p>
            </header>

            <?php if ($comment->comment_approved === '0') {
                printf('<p>%s</p>', _e('Your comment has been held for moderation.', TTD));
            } ?>

            <div class="comment-body">
                <?php comment_text(); ?>
            </div>
            <?php if (is_user_logged_in()) : ?>
                <footer>
                    <p><small>
                        <?php edit_comment_link(__('edit', TTD),'  ',''); ?>
                    </small></p>
                </footer>
            <?php endif; ?>
        </div>
    </li><?php
}

/**
 * Wrap Comment Fields in Elements
 * -----------------------------------------------------------------------------
 * See: http://goo.gl/m9kv1z
 */

function wrap_comment_fields_before() {
    printf('<div class="commentform-inputs">');
}

function wrap_comment_fields_after() {
    printf('</div>');
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
// Enqueue all scripts and stylesheets.
add_action('wp_enqueue_scripts', 'load_theme_styles');
add_action('wp_enqueue_scripts', 'load_theme_scripts');
// Set site favicon.
add_action('wp_head', 'set_favicon');
// Set prefetch domain for media.
add_action('wp_head', 'dns_prefetch');
// Wrap comment form fields in <div></div> tags.
add_action('comment_form_before_fields', 'wrap_comment_fields_before');
add_action('comment_form_after_fields', 'wrap_comment_fields_after');
// Clean search URL rewrite.
add_action('template_redirect', 'clean_search_url');
// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');
// HTML5 support in theme.
current_theme_supports('html5');
current_theme_supports('menus');
add_theme_support('html5', array('search-form'));        

?>