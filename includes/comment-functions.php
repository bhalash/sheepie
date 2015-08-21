<?php 

/**
 * Theme Comment Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

/**
 * Custom Comment and Comment Form Output
 * -----------------------------------------------------------------------------
 * @param   string  $comment    The comment.
 * @param   array   $args       Array argument
 * @param   int     $depth      Depth of the comments thread.
 */

function theme_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>

    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <?php printf('<div class="%s" style="%s"><a title="%s" href="%s"></a></div>',
            'photo comment-photo',
            sprintf('background-image: url(%s);', get_avatar($comment)),
            get_comment_author(),
            get_comment_author_url()
        ); ?>
        <div class="comment-body">
            <header>
                <p class="comment-meta">
                    <span class="comment-author-link"><?php comment_author_link(); ?></span>
                    <?php printf('<span class="%s"><time datetime="%s">%s</time></span>',
                        'post-date',
                        get_comment_date('Y-M-d H:i'),
                        get_comment_date_strftime()
                    ); ?>
                </p>
            </header>

            <div class="comment-body">
                <?php if (!$comment->comment_approved) {
                    printf('<p class="%s">%s</p>',
                        'comment-unapproved',
                        __('Tá do thrácht á mheas.', TTD)
                    );
                } else {
                    comment_text();
                } ?>
            </div>

            <?php if (is_user_logged_in()) : ?>
                <footer>
                    <p><?php edit_comment_link(__('edit', TTD),'', ''); ?></p>
                </footer>
            <?php endif; ?>
        </div>
    </li>

    <?php
}

/**
 * Wrap Comment Fields in Elements
 * -------------------------------------------------------------------------
 * @link http://wordpress.stackexchange.com/a/172055
 */

function wrap_comment_fields_before() {
    printf('<div class="commentform-inputs">');
}

function wrap_comment_fields_after() {
    printf('</div>');
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

// Wrap comment form fields in <div></div> tags.
add_action('comment_form_before_fields', 'wrap_comment_fields_before');
add_action('comment_form_after_fields', 'wrap_comment_fields_after');

?>
