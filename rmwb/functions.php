<?php
    // Wordpress repeatedly inserted emoticons. No more, ever.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');

    // HTML5 support.
    current_theme_supports('html5');

function rmwb_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <div class="comment <?php comment_class(); ?>" id="li-comment-<?php comment_ID() ?>">
        <h5><?php echo get_comment_author_link(); ?></h5>
        <p class="comment-meta">
            Commented <?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?>.
            <?php edit_comment_link(__('edit'),'  ',''); ?>
        </p>
        <?php if ($comment->comment_approved == '0') : ?>
            <p><?php _e('Your comment has been held for moderation.') ?></p>
        <?php endif; ?>
        <?php comment_text() ?>
<?php } ?>