<?php

/**
 * Theme Comment Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

function sheepie_theme_comments($comment, $args, $depth) {
    $comment_classes = array(
        'comment', 'comments__comment', 'avatar'
    );

    $GLOBALS['comment'] = $comment;
    ?>

    <li <?php comment_class($comment_classes); ?> id="comment--<?php comment_ID() ?>">
        <div class="avatar__container comments__avatar noprint">
            <?php sheepie_avatar_background_html($comment, 'thumb', 'avatar__photo'); ?>
        </div>
        <div class="comment-body comments__comment-content avatar__text">
            <header class="comments__comment-header">
                <?php

                printf('<span class="%s comments__meta">%s %s </span>',
                    'comment-author-link font-size--small',
                    get_comment_author_link(),
                    __('on', 'sheepie')
                );

                printf('<span class="%s comments__meta"><time datetime="%s">%s</time></span>',
                    'post-date',
                    get_comment_date('Y-M-d H:i'),
                    get_comment_date(get_option('date_format'))
                );

                ?>
            </header>

            <div class="comments__comment-body font-size--small">
                <?php if (!$comment->comment_approved) {
                    printf('<p class="%s">%s</p>',
                        'comments__comment-unapproved',
                        __('Your comment is awaiting approval.', 'sheepie')
                    );
                } else {
                    comment_text();
                } ?>
            </div>

            <?php if (is_user_logged_in()) : ?>
                <footer class="comments__comment-footer">
                    <span class="font-size--small"><?php edit_comment_link(__('edit', 'sheepie'),'', ''); ?></span>
                </footer>
            <?php endif; ?>
        </div>
    </li>
    <hr>

    <?php
}

/**
 * Wrap Comment Fields in Elements
 * -------------------------------------------------------------------------
 * Wrap comment form fields in <div></div> tags.
 * @link http://wordpress.stackexchange.com/a/172055
 */

function sheepie_wrap_comment_fields_before() {
    printf('<fieldset class="comments__inputs vspace--full">');
}

function sheepie_wrap_comment_fields_after() {
    printf('</fieldset>');
}

add_action('comment_form_before_fields', 'sheepie_wrap_comment_fields_before');
add_action('comment_form_after_fields', 'sheepie_wrap_comment_fields_after');

?>
