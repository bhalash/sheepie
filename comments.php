<?php

/**
 * Comments Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

if (!comments_open() || post_password_required()) {
    return;
}

$textarea_html = '<textarea class="comments__textarea" id="comment" name="comment" required="required"></textarea>';

?>

<hr class="vcenter--double">
<div class="comments" id="comments">
    <h4 class="vspace--full subtitle noprint">
        <?php printf('%s "%s"', __('Have your say on ', 'sheepie'), get_the_title()); ?>
    </h4>

    <?php if (have_comments()) : ?>
        <ul class="comments__commentlist">
            <?php wp_list_comments([
                'callback' => 'sheepie_theme_comments',
                'avatar_size' => 0,
                'format' => 'html5',
                'style' => 'ul'
            ]); ?>
        </ul>
    <?php endif; ?>

    <?php if (get_comment_pages_count() > 1) {
        sheepie_partial('pagination', 'comment');
    } ?>

    <div class="noprint" id="comments__entry">
        <?php comment_form([
            'id_form' => 'comments__form',
            'id_submit' => 'comments__submit',
            'title_reply' => '',
            'comment_field' => sprintf('<p id="textarea">%s</p>', $textarea_html),
            'comment_form_before_fields' => '<div class="comments__form">',
            'comment_form_after_fields' => '</div>',
            'fields' => sheepie_commentform_fields()
        ]); ?>
    </div>
</div>
