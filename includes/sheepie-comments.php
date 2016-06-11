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
    $GLOBALS['comment'] = $comment;
    ?>

    <li <?php comment_class(['comment']); ?> id="comment--<?php comment_ID() ?>">
        <header>
            <?php echo sheepie_avatar($comment, get_comment_author($comment), 'comment__avatar', ['size' => 130]); ?>
            <p class="comment__header">
                <span class="comment__header-item"><?php comment_author_link(); ?></span>
                <span class="comment__header-item">
                    <time datetime="<?php comment_date('Y-M-d H:i'); ?>"><?php comment_date(get_option('date_format')); ?></time>
                    <a href="<?php comment_link($comment); ?>">#</a>

                    <?php if (is_user_logged_in()) : ?>
                        <?php edit_comment_link(__('edit', 'sheepie'), ' / ', ''); ?>
                    <?php endif; ?>
                </span>
            </p>
        </header>
        <div class="comment__body">
            <?php if (!$comment->comment_approved) : ?>
                <p><?php _e('Your comment is awaiting approval.', 'sheepie'); ?></p>
            <?php else : ?>
                <?php comment_text(); ?>
            <?php endif; ?>
        </div>
    </li>

    <?php
}

/**
 * Generate Custom Commentform Input HTML
 * -------------------------------------------------------------------------
 * @param   array       $input_fields   Labels for input fields.
 * @param   string      $input_html     Raw HTML for input fields.
 * @param   array       $input_fields   Raw HTML joined with labels.
 */

function sheepie_commentform_fields($input_fields = null, $input_html = null) {
    // Template input for name, email and URL.
    $input_html = $input_html ?: '<input class="comments__input %s-name font-size--small" id="%s" name="%s" placeholder="%s" type="text" required="required">';

    $input_fields = $input_fields ?: [
        'author' => __('Name*', 'sheepie'),
        'email' => __('Email*', 'sheepie'),
        'url' => __('Website', 'sheepie')
    ];

    foreach ($input_fields as $field => $label) {
        $input_fields[$field] = sprintf($input_html, $field, $field, $field, $label);
    }

    return $input_fields;
}

/**
 * Wrap Comment Fields in Elements
 * -------------------------------------------------------------------------
 * Wrap comment form fields in <div></div> tags.
 * @link http://wordpress.stackexchange.com/a/172055
 */

function sheepie_wrap_comment_fields_before() {
    printf('<div class="comments__inputs vspace--full">');
}

function sheepie_wrap_comment_fields_after() {
    printf('</div>');
}

add_action('comment_form_before_fields', 'sheepie_wrap_comment_fields_before');
add_action('comment_form_after_fields', 'sheepie_wrap_comment_fields_after');

?>
