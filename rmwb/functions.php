<?php
    // Wordpress repeatedly inserted emoticons. No more, ever.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');

    // HTML5 support.
    current_theme_supports('html5');
?>

<?php function rmwb_comments($comment, $args, $depth) {
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

<?php function stock_comment($comment, $args, $depth) {
    // This is the HTML template for the stock Wordpress comment. Used as reference. 
    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-body-inner">
                <div class="comment-avatar">
                    <?php echo get_avatar($comment, $size = '45', $default = get_bloginfo('stylesheet_directory').'/images/default-avatar.png' ); ?>
                </div>
                <div class="comment-author vcard">
                    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.') ?></em><br />
                <?php endif; ?>
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                        <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
                    <?php edit_comment_link(__('(Edit)'),'  ','') ?>
                </div>
                 <?php comment_text() ?>
                 <div class="reply">
                    <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div>
            </div>
        </div>
<?php } ?>