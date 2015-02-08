<?php
    if (!isset($content_width)) {
        $content_width = 600;
    }

    function clean_search_url() {
        // See: http://wpengineer.com/2258/change-the-search-url-of-wordpress/
        if (is_search() && ! empty($_GET['s'])) {
            wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
            exit();
        }
    }

    function rmwb_scripts() {
        wp_enqueue_script('rmwb-functions', get_stylesheet_directory_uri() . '/js/functions.js', array('jquery'), '1.0', true);
        wp_enqueue_script('rmwb-prettify', get_stylesheet_directory_uri() . '/js/prettify.js', array('jquery'), '1.0', true);
    }

    function rmwb_styles() {
        wp_register_style('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800|Bitter|Roboto+Condensed|Source+Code+Pro');
        wp_enqueue_style('google-fonts');
        // Main style.
        wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/sass/style.css', false, '1.4', 'all');
        // Google code prettifier.
        wp_enqueue_style('code-prettify', get_stylesheet_directory_uri() . '/prettify.css');
    }

    function rmwb_menu() {
        register_nav_menu('sidebar-menu',__('Sidebar Menu'));
    }

    function search_results_count($page_num, $total_results) {
        // Displays 'x to y of z' in search results.
        $page_num = ($page_num == 0) ? 1 : $page_num;
        $posts_per_page = get_option('posts_per_page');
        $count_high = $page_num * $posts_per_page;
        $count_low  = ($count_high - $posts_per_page) + 1;
        $count_high = ($count_high > $total_results) ? $total_results : $count_high;
        return 'Results ' . $count_low . ' to ' . $count_high . ' of ' . $total_results;
    }

    function rmwb_reading_seconds($post) {
        // Word count to seconds reading time, based on 300 WPM.
        $average_wpm = 300;
        $average_wps = round($average_wpm / 60);
        $time = str_word_count(strip_tags($post));
        return round($time / $average_wps);
    }

    function rmwb_reading_minutes($seconds) {
        // Seconds to minutes, rounded to nearest minute.
        if ($seconds % 60 <= 30) {
            $minutes = floor($seconds / 60);
        } else {
            $minutes = ceil($seconds / 60);
        }

        return $minutes;
    }

    function rmwb_minutes_to_words($minutes) {
        // Converts a given minutes time to words.
        // Only does up to ninety-nine minutes.
        // Honestly, if your article's reading time is above that, you've gone wrong somewhere.
        $time_word = '';

        $singles = array(
            'one','two','three','four','five',
            'six','seven','eight','nine'
        );

        $teens = array(
            'eleven', 'twelve','thirteen','fourteen','fifteen',
            'sixteen','seventeen','eighteen','nineteen'
        );

        $tens = array(
            'ten','twenty','thirty','forty','fifty',
            'sixty','seventy','eighty','ninety'
        );

        if ($minutes <= 0) {
            // <0 - 0
            $time_word = $singles[0];
        } elseif ($minutes < 10) {
            // 1 - 9
            $time_word = $singles[$minutes - 1];
        } elseif ($minutes > 10 && $minutes < 20) {
            // 11 - 19
            $time_word = $teens[$minutes - 11];
        } elseif ($minutes % 10 == 0) {
            // 10, 20, etc.
            $time_word = $tens[($minutes / 10) - 1];
        } elseif ($minutes > 99) {
             // > 99
            $a = $tens[8];   
            $b = $singles[8];
            $time_word = 'greater than' . $a . '-' . $b;
        } else {
            // 31, 56, 77, etc.
            $a = $tens[($minutes % 100) / 10 - 1];   
            $b = $singles[($minutes % 10) - 1];
            $time_word = $a . '-' . $b;
        }

        return $time_word;
    }

    function rmwb_reading_time($post) {
        // See http://www.bhalash.com/archives/13544802870
        $time = rmwb_reading_seconds($post);
        $time = rmwb_reading_minutes($time);
        $time_word = rmwb_minutes_to_words($time);
        $min_word = ($time <= 1) ? ' minute.' : ' minutes.';
        return ucfirst($time_word) . $min_word;
    }

    function sidebar_widgets_init() {
        // Wordpress dynamic sidebar.
        register_sidebar(
            array(
                'name'          => 'Dynamic sidebar.',
                'id'            => 'dynamicsidebar',
                'before_widget' => '<div class="sidebarwidget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="sidebartitle">',
                'after_title'   => '</h6>',
            )
        );
    }

    function rmwb_comments($comment, $args, $depth) {
        // Custom comment output.
        $GLOBALS['comment'] = $comment; ?>
        <li class="comment <?php comment_class(); ?>" id="li-comment-<?php comment_ID() ?>">
            <h4 class="author"><?php echo get_comment_author_link(); ?></h4>
            <p>
                <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
                <?php edit_comment_link(__('edit'),'  ',''); ?>
            </p>
            <?php if ($comment->comment_approved == '0') : ?>
                <p><?php _e('Your comment has been held for moderation.') ?></p>
            <?php endif;
            comment_text();
    }

    add_action( 'template_redirect', 'clean_search_url');
    // Enqueue all scripts and stylesheets.
    add_action('wp_enqueue_scripts', 'rmwb_styles');
    add_action('wp_enqueue_scripts', 'rmwb_scripts');
    // Wordpress repeatedly inserted emoticons. No more, ever.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    // Declares that the theme has HTML5 support.
    current_theme_supports('html5');
    // Sidebar.
    add_action('widgets_init', 'sidebar_widgets_init');
    // Menu. 
    add_action('init', 'rmwb_menu');
?>