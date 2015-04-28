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

$social_fallback = array(
    // Social fallback is called in cases where the post is missing n info.
    'publisher' => 'http://www.bhalash.com',
    'image' => get_template_directory_uri() . '/assets/images/lightning.jpg',
    'description' => get_bloginfo('description'),
    'twitter' => '@bhalash'
);

$google_fonts = array(
    // All Google Fonts to be loaded.
    'Open Sans Condensed 300',
    'Merriweather',
    'Open Sans:400,700,800',
    'Bitter',
    'Roboto Condensed',
    'Source Code Pro'
);

/**
 * Enqueue Styles and Scripts
 * --------------------------
 */

function google_font_url() {
    /**
     * Generate Google Fonts URL
     * -------------------------
     * @param {none}
     * @return {none}
     */

    global $google_fonts;
    $google_url = array();

    $google_uri[] '//fonts.googleapis.com/css?family=';

    foreach ($google_fonts as $index => $value) {
        $g_string[] = str_replace(' ', '+', $value);

        if ($index < sizeof($google_fonts) - 1) {
            $google_uri[] = '|';
        }
    }

    return implode('', $google_uri);
}

function enqueue_theme_scripts() {
    /**
     * Enqueue Theme JavaScript
     *  -----------------------
     * @param {none}
     * @return {none}
     */    

    wp_enqueue_script('highlightjs', '//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js', '', '1.0', true);
    wp_enqueue_script('rmwb-browser-detect', get_stylesheet_directory_uri() . '/assets/js/browser_detect.js', '', '1.0', true);
    wp_enqueue_script('rmwb-functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', array('jquery'), '1.0', true);
}

function enqueue_theme_stylesheets() {
    /**
     * Enqueue Theme Stylesheets
     *  ------------------------
     * @param {none}
     * @return {none}
     */    

    wp_register_style('google-fonts', google_font_url());
    wp_enqueue_style('google-fonts');
    wp_enqueue_style('main-style', get_stylesheet_uri(), false, '1.4', 'all');
    wp_enqueue_style('custom-stylesheet', get_stylesheet_directory_uri() . '/custom.css', false, '1.4', 'all');
}

/**
 * Open Graph and Twitter Card Information
 * ---------------------------------------
 */

function social_meta() {
    /**
     * Output Open Graph and Twitter Card Tags
     * ---------------------------------------
     * Call the Open Graph and Twitter Card functions.
     *
     * @param {none}
     * @return {none}  
     */

    open_graph_tags();
    twitter_card_tags();
}

function twitter_card_tags() {
    /**
     * Twitter Card
     * ------------
     * This function /should/ present all of the relevant and correct
     * information for Twitter Card. 
     *
     * @param {none}
     * @return {none}
     */

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

function open_graph_tags() {
    /**
     * Open Graph
     * ----------
     * This function /should/ present all of the relevant and correct
     * information for Open Graph scrapers. 
     *
     * @param {none}
     * @return {none}
     */

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

function search_results_count($page_num, $total_results) {
    /**
     * Search Result Count
     * -------------------
     * Return a count of results for the search in the format 
     * 'Results 1 to 10 of 200'
     * 
     * @param {int} $page_num Current page nunber.
     * @param {int} $total_results Total number of search results.
     * @return {string} Count of results.
     */

    $page_num = ($page_num === 0) ? 1 : $page_num;
    $posts_per_page = get_option('posts_per_page');
    $count_high = $page_num * $posts_per_page;
    $count_low  = ($count_high - $posts_per_page) + 1;
    $count_high = ($count_high > $total_results) ? $total_results : $count_high;
    return 'Results ' . $count_low . ' to ' . $count_high . ' of ' . $total_results;
}

function clean_search_url() {
    /**
     * Rewrite Search URL Cleanly
     * --------------------------
     * Cleanly rewrite search URL from ?s=topic to /search/topic
     * See: http://wpengineer.com/2258/change-the-search-url-of-wordpress/
     * 
     * @param {none}
     * @return {none}
     */

    if (is_search() && ! empty($_GET['s'])) {
        wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
        exit();
    }
}

function custom_excerpt($excerpt) {
    /**
     * Custom Theme Excerpt
     * --------------------
     * I forget why I did this.
     * 
     * @param {string} $excerpt
     * @return {string} $excerpt
     */

    $excerpt = get_the_content(); 
    $excerpt = strip_shortcodes($excerpt); 
    $excerpt = strip_tags($excerpt); 
    $excerpt = explode('.', $excerpt);
    $excerpt = $excerpt[0]; 
    $length = strlen(preg_replace(array('/\s/', '/\n/'), '', $excerpt)); 
    return $excerpt;
}

function archive_page_count($page_num = null, $total_results = null, $type = null) {
    /**
     * Pagination Post Counter
     * -----------------------
     * Fetch and display total post count in format of 'Page 1 of 10'.
     * This only counts published, public posts; drafts, pages, custom
     * post types and private posts are all excluded unless you specify
     * inclusion.
     * 
     * @param {int} $page_num Current page in pagination.
     * @param {int} $total_results Total results, for pagination.
     * @param {string} $type Type of post to use.
     * @return {string The post counter.
     */

    if (is_null($page_num)) {
        $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    if (is_null($type)) {
        $type = 'post';
    }

    if (is_null($total_results)) {
        $total_results = wp_count_posts($type, 'readable')->publish;
    }

    $posts_per_page = get_option('posts_per_page');
    $total_pages = ceil($total_results / $posts_per_page);
    printf('Page %s of %s', $page_num, $total_pages);
}

function content_first_image() {
    /**
     * Retrive first image in content.
     * -------------------------------
     * I chose not to use the featured image feature in WordPress, because
     * I do not want to be ultimately tied to WordPress as a blogging CMS.
     * 
     * This functions extracts and returns the first found image in the post,
     * no matter what that image happens to be.
     * 
     * See: http://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/
     *
     * @param {none}
     * @return {string} Full URL of the first image found.
     */

    global $post, $posts, $social_fallback;
    ob_start();
    ob_end_clean();
    $first_image = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_image = $matches[1][0];
    return (!empty($first_image)) ? $first_image : $social_fallback['image'];
}

function article_reading_time($post_id = null, $average_wpm = 300, $return_minutes = false) {
    /**
     * Article Reading Time in Seconds
     * -------------------------------
     * Inpsired by Medium; see: http://www.bhalash.com/archives/13544802870
     *
     * Return the reading time of the article in seconds, based on an average 
     * WPM of 300. You are free to override this.
     * 
     * @param {int} $post_id 
     * @param {int} $average_wpm Average reading speed.
     * @return {int} $reading_time Reading time in seconds.
     */

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

function article_reading_time_minutes($seconds) {
    /**
     * Article Reading Time in Seconds
     * -------------------------------
     * Convert the reading time in seconds, to the reding time in minutes.
     * 
     * @param {int} $seconds Reading time in seconds.
     * @return {int} $minutes Reading time in minutes.
     */
    
    $minutes = 0;

    if ($seconds % 60 <= 30) {
        $minutes = floor($seconds / 60);
    } else {
        $minutes = ceil($seconds / 60);
    }

    return $minutes;
}

function reading_time_in_words($reading_time) {
    /**
     * Article Reading Time in Seconds
     * -------------------------------
     * Converts a given minutes time to words. Only does up to 99 minutes,
     * because, honestly, if your article's reading time is above that then
     * you went horribly wrong somewhere.
     * 
     * @param {int} $seconds Reading time in minutes.
     * @return {string} $time_words Reading time of article expressed as a phrase.
     * 
     */

    $words = array(
        'singles' = array(
            'one','two','three','four','five','six','seven','eight','nine'
        ),
        'teens' = array(
            'eleven','twelve','thirteen','fourteen','fifteen','sixteen',
            'seventeen','eighteen','nineteen'
        ),
        'tens' = array(
            'ten','twenty','thirty','forty','fifty','sixty','seventy','eighty',
            'ninety'
        )
    );

    // Reading time in words.
    $time_word = '';

    if ($reading_time <= 0) {
        // <0 - 0
        $time_word = $words['singles'][0];
    } elseif ($reading_time < 10) {
        // 1 - 9
        $time_word = $words['singles'][$reading_time - 1];
    } elseif ($reading_time > 10 && $reading_time < 20) {
        // 11 - 19
        $time_word = $words['teens'][$reading_time - 11];
    } elseif ($reading_time % 10 === 0) {
        // 10, 20, etc.
        $time_word = $words['tens'][($reading_time / 10) - 1];
    } elseif ($reading_time > 99) {
         // > 99
        $time_word = 'greater than' . $words['singles'][8] . '-' . $words['tens'][8];
    } else {
        // 31, 56, 77, etc.
        $time_word = $words['tens'][($reading_time % 100) / 10 - 1] . '-' . $words['singles'][($reading_time % 10) - 1];
    }

    return $time_word;
}

function rmwb_reading_time($post_id = null) {
    /**
     * Reading Time Wrapper
     * --------------------
     * Take in post and return its reading time in minutes as a phrase.
     * See http://www.bhalash.com/archives/13544802870
     *
     * @param {int} $post_id 
     * @param {string} $time_phrase Reading time as a phrase/words.
     */

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $time = article_reading_time($post_id, true);
    $time_phrase = reading_time_in_words($time);
    $minute_word = ($time <= 1) ? ' minute.' : ' minutes.';
    return ucfirst($time_phrase) . $minute_word;
}

function sidebar_widgets_init() {
    /**
     * Register Theme Widget Areas
     * ---------------------------
     * @param {none}
     * @return {none}
     */

    register_sidebar(array(
        'name' => 'Dynamic sidebar.',
        'id' => 'dynamicsidebar',
        'before_widget' => '<div class="sidebarwidget">',
        'after_widget' => '</div>',
        'before_title' => '<h6 class="sidebartitle">',
        'after_title' => '</h6>',
    ));
}

function rmwb_nav() {
    /**
     * Register Theme Navigation Menus
     * -------------------------------
     * @param {none}
     * @return {none}
     */

    register_nav_menus(array(
        'top-menu' => __('Header Menu'),
        'top-social' => __('Header Social Links')
    ));
}

add_action('init', 'rmwb_nav');

function rmwb_comments($comment, $args, $depth) {
    /**
     * Custom Comment and Comment Form Output
     * --------------------------------------
     * @param {string} $comment The comment.
     * @param {array} $args Array argument 
     * @param {int} $depth Depth of the comments thread.
     * @return {none}
     */

    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="avatar-wrapper">
            <?php echo get_avatar($comment, 75); ?>
        </div>
        <div class="comment-interior">
            <header>
                <p class="author"><?php comment_author_link(); ?></p>
                <p class="date"><small><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?></small></p>
            </header>

            <?php if ($comment->comment_approved === '0') {
                printf('<p>%s</p>', _e('Your comment has been held for moderation.'));
            } ?>

            <div class="comment-body">
                <?php comment_text(); ?>
            </div>
            <?php if (is_user_logged_in()) : ?>
                <footer>
                    <p><small>
                        <?php edit_comment_link(__('edit'),'  ',''); ?>
                    </small></p>
                </footer>
            <?php endif; ?>
        </div>
    </li><?php
}

function wrap_comment_fields_before() {
    /**
     * Prepend Element to Comment Fields
     * ---------------------------------
     * See: https://wordpress.stackexchange.com/questions/172052/how-to-wrap-comment-form-fields-in-one-div
     *
     * @param {none}
     * @return {none}
     */

    printf('<div class="commentform-inputs">');
}

function wrap_comment_fields_after() {
    /**
     * Append Element to Comment Fields
     * --------------------------------
     * See: https://wordpress.stackexchange.com/questions/172052/how-to-wrap-comment-form-fields-in-one-div
     *
     * @param {none}
     * @return {none}
     */

    printf('</div>');
}

if (!isset($content_width)) {
    $content_width = 600;
}

add_action('widgets_init', 'sidebar_widgets_init');
// Enqueue all scripts and stylesheets.
add_action('wp_enqueue_scripts', 'enqueue_theme_stylesheets');
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');
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