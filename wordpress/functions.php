<?php
    if (!isset($content_width)) {
        $content_width = 600;
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
        echo 'Results ' . $count_low . ' to ' . $count_high . ' of ' . $total_results;
    }

    function split_title($title) {
        // Splits the site title into alternating words.
        $anchor = '<a href="' . get_home_url() . '">';
        $open   = '<li>';
        $close  = '</a></li>'; 
        $words  = explode(' ', $title);

        foreach ($words as $word) {
            echo $open . $anchor . $word . $close;
        }
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
            <h4 class="comment-author"><?php echo get_comment_author_link(); ?></h4>
            <p>
                <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
                <?php edit_comment_link(__('edit'),'  ',''); ?>
            </p>
            <?php if ($comment->comment_approved == '0') : ?>
                <p><?php _e('Your comment has been held for moderation.') ?></p>
            <?php endif;
            comment_text();
    }

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