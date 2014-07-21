<?php
    // Wordpress repeatedly inserted emoticons. No more, ever.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    // Declares that the theme has HTML5 support.
    current_theme_supports('html5');
    // Sidebar.
    add_action('widgets_init', 'sidebar_widgets_init');

    // Add your social networks here. Set network and user name.
    // Available networks: 
    // 
    // emails (<-- note the 's'!)
    // facebook
    // flickr
    // github
    // google (google+)
    // instagram
    // linkedin
    // pinterest
    // twitter
    // tumblr
    //  
    $social_networks = array(
        'twitter'    => 'bhalash',
        'facbook'    => 'bhalash',
        'instagram'  => 'bhalash',
        'github'     => 'bhalash',
    );

    if (!isset($content_width)) {
        $content_width = 600;
    }

    function rmwb_social() {
    }

    function sidebar_widgets_init() {
        // Wordpress dynamic sidebar.
        register_sidebar(
            array(
                'name'          => 'Dynamic sidebar.',
                'id'            => 'dynamic-sidebar',
                'before_widget' => '<div class="sidebar-widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="sidebar-title">',
                'after_title'   => '</h6>',
           )
       );
    }

    function split_title($title) {
        // Splits the site title into alternating words.
        // Kinda...you need to pay attention to your site title or the effect can be strange.
        $n      = 1;
        $class  = '<li class="header-title-inset">';
        $anchor = '<a href="' . get_home_url() . '">';
        $close  = '</a></li>'; 
        $words  = explode(' ', $title);

        foreach ($words as $word) {
            if ($n % 2 != 0) {
                echo $class . $anchor . $word . $close;
            } else {
                echo '<li>' . $anchor . $word . $close;
            }

            $n++;
        }
    }

    function rmwb_comments($comment, $args, $depth) {
        // Custom comment output.
        $GLOBALS['comment'] = $comment; ?>
        <div class="comment <?php comment_class(); ?>" id="li-comment-<?php comment_ID() ?>">
            <h5 class="comment-author"><?php echo get_comment_author_link(); ?></h5>
            <p class="comment-meta">
                Commented <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>
                <?php edit_comment_link(__('edit'),'  ',''); ?>
            </p>
            <?php if ($comment->comment_approved == '0') : ?>
                <p><?php _e('Your comment has been held for moderation.') ?></p>
            <?php endif;
            comment_text();
    }
?>