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
define('THEME_PARTIALS', '/partials');
define('THEME_ARTICLES', THEME_PARTIALS . '/articles/');

/**
 * Theme Asset Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_ASSETS', THEME_ROOT . '/assets/');
define('THEME_JS', THEME_ASSETS . 'js/');
define('THEME_IMAGES', THEME_ASSETS . 'images/');
define('THEME_CSS', THEME_ASSETS . 'css/');

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

// require_once(THEME_INCLUDES . 'options.php');
require_once(THEME_INCLUDES . 'container-states.php');

/**
 * Theme Text Domain
 * -----------------------------------------------------------------------------
 */

define('TTD', 'sheepie');

/**
 * Other Variables
 * -----------------------------------------------------------------------------
 */

// Media prefetch domain: If null or empty, defaults to site domain.
$prefetch_domain = 'ix.bhalash.com';
// Path to favicon.
$favicon_pth = THEME_IMAGES . 'favicon.png';

/**
 * Social Meta Fallback
 * -----------------------------------------------------------------------------
 */

$social_fallback = array(
    // Social fallback is called in cases where the post is missing n info.
    'publisher' => 'http://www.bhalash.com',
    'image' => THEME_IMAGES . 'fallback.jpg',
    'description' => get_bloginfo('description'),
    'twitter' => '@bhalash'
);

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
 * Output Open Graph and Twitter Card Tags
 * -----------------------------------------------------------------------------
 * Call the Open Graph and Twitter Card functions.
 */

function social_meta() {
    open_graph_tags();
    twitter_card_tags();
}

/**
 * Twitter Card
 * -----------------------------------------------------------------------------
 * This function /should/ present all of the relevant and correct
 * information for Twitter Card. 
 */

function twitter_card_tags() {
    global $social_fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);

    $site_meta = array(
        'twitter:card' => 'summary',
        'twitter:site' => $social_fallback['twitter'],
        'twitter:title' => get_the_title(),
        'twitter:description' => (is_single()) ? get_the_excerpt() : $social_fallback['description'],
        'twitter:image:src' => content_first_image($post->ID),
        'twitter:url' => get_site_url() . $_SERVER['REQUEST_URI'],
    );

    foreach ($site_meta as $key => $value) {
        printf('<meta name="%s" content="%s">', $key, $value);
    }
}

/**
 * Open Graph
 * -----------------------------------------------------------------------------
 * This function /should/ present all of the relevant and correct
 * information for Open Graph scrapers. 
 */

function open_graph_tags() {
    global $social_fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);

    $site_meta = array(
        'og:title' => get_the_title(),
        'og:site_name' => get_bloginfo('name'),
        'og:url' => get_site_url() . $_SERVER['REQUEST_URI'],
        'og:description' => (is_single()) ? get_the_excerpt() : $social_fallback['description'],
        'og:image' => content_first_image($post->ID),
        'og:type' => (is_single()) ? 'article' : 'website',
        'og:locale' => get_locale(),
    );

    if (is_single()) {
        // If single post, add category and tag information.
        $category = get_the_category($post->ID);

        $tags = get_the_tags();
        $taglist = array();
        $i = 0;

        foreach ($tags as $key => $value) {
            if ($i > 0) {
                $taglist[] = ', ';
            }

            $taglist[] = $value->name;
            $i++;
        }

        $article_meta = array(
            'article:section' => $category[0]->cat_name,
            'article:tag' => implode('', $taglist),
            'article:publisher' => $social_fallback['publisher'],
        );

        $site_meta = array_merge($site_meta, $article_meta);
    }

    foreach ($site_meta as $key => $value) {
        // Iterate all information and output.
        printf('<meta property="%s" content="%s">', $key, $value);
    }
}

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function dns_prefetch() {
    global $prefetch_domain;
    $prefetch = $prefetch_domain || $_SERVER['SERVER_NAME'];
    printf('<link rel="dns-prefetch" href="//%s">', $prefetch);
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
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Inpsired by Medium; see: http://www.bhalash.com/archives/13544802870
 *
 * Return the reading time of the article in seconds, based on an average 
 * WPM of 300. You are free to override this.
 * 
 * @param   int     $post_id 
 * @param   int     $average_wpm    Average reading speed.
 * @return  int     $reading_time   Reading time in seconds.
 */

function article_reading_time($post_id = null, $average_wpm = 300, $return_minutes = false) {
    $reading_time = 0;

    if (is_null($post_id_id)) {
        $post_id = get_the_ID();
    }

    $average_wps = round($average_wpm / 60);
    $time = str_word_count(strip_tags($post_id));
    $reading_tine = round($time / $average_wps);

    if ($return_minutes) {
        $reading_time = article_reading_time_minutes($reading_time);
    }

    return $reading_time;
}

/**
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Convert the reading time in seconds, to the reding time in minutes.
 * 
 * @param   int     $seconds        Reading time in seconds.
 * @return  int     $minutes        Reading time in minutes.
 */

function article_reading_time_minutes($seconds) {
    $minutes = 0;

    if ($seconds % 60 <= 30) {
        $minutes = floor($seconds / 60);
    } else {
        $minutes = ceil($seconds / 60);
    }

    return $minutes;
}

/**
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Converts a given minutes time to words. Only does up to 99 minutes,
 * because, honestly, if your article's reading time is above that then
 * you went horribly wrong somewhere.
 * 
 * @param   int     $seconds        Reading time in minutes.
 * @return  string  $time_words     Reading time of article expressed as a phrase.
 * 
 */

function reading_time_in_words($reading_time) {
    $words = array(
        'singles' => array(
            'one','two','three','four','five','six','seven','eight','nine'
        ),
        'teens' => array(
            'eleven','twelve','thirteen','fourteen','fifteen','sixteen',
            'seventeen','eighteen','nineteen'
        ),
        'tens' => array(
            'ten','twenty','thirty','forty','fifty','sixty','seventy','eighty',
            'ninety'
        )
    );

    // Reading time in words.
    $time_word = array();

    if ($reading_time <= 0) {
        // <0 - 0
        $time_word[] = $words['singles'][0];
    } elseif ($reading_time < 10) {
        // 1 - 9
        $time_word[] =$words['singles'][$reading_time - 1];
    } elseif ($reading_time > 10 && $reading_time < 20) {
        // 11 - 19
        $time_word[] = $words['teens'][$reading_time - 11];
    } elseif ($reading_time % 10 === 0) {
        // 10, 20, etc.
        $time_word[] = $words['tens'][($reading_time / 10) - 1];
    } elseif ($reading_time > 99) {
         // > 99
        $time_word[] = 'greater than';
        $time_word[] = $words['singles'][8];
        $time_word[] = '-';
        $time_word[] = $words['tens'][8];
    } else {
        // 31, 56, 77, etc.
        $time_word[] = $words['tens'][($reading_time % 100) / 10 - 1];
        $time_word[] = '-';
        $time_word[] = $words['singles'][($reading_time % 10) - 1];
    }

    return implode('', $time_word);
}

/**
 * Reading Time Wrapper
 * -----------------------------------------------------------------------------
 * Take in post and return its reading time in minutes as a phrase.
 * See http://www.bhalash.com/archives/13544802870
 *
 * @param   int     $post_id 
 * @param   string  $time_phrase    Reading time as a phrase/words.
 */

function rmwb_reading_time($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $time = article_reading_time($post_id, true);
    $time_phrase = reading_time_in_words($time);
    $minute_word = ($time <= 1) ? ' minute.' : ' minutes.';
    return ucfirst($time_phrase) . $minute_word;
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
add_action('wp_head', 'social_meta');
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