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

if (comments_open()) {
    if (post_password_required()) {
        return;
    }

    printf('<hr>');

    printf('<div class="comments" id="comments">');
        printf('<h4 class="%s">%s \'%s\'</h4>',
            'vspace--full subtitle',
            __('Have your say on ', 'sheepie'),
            get_the_title()
        );

    if (have_comments()) {
        printf('<ul class="%s">', 'comments__commentlist');

        wp_list_comments(array(
            'callback' => 'sheepie_theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul>');
    }

    if (get_comment_pages_count() > 1) {
        sheepie_partial('pagination', 'comment');
    }

    printf('<div id="comments__entry">');

    // Template input for name, email and URL.
    $input = '<input class="comments__input %s-name font-size--small" id="%s" name="%s" placeholder="%s" type="text" required="required">';
    $textarea = '<textarea class="comments__textarea" id="comment" name="comment" required="required"></textarea>';

    $fields = array(
        // Name, author and email fields.
        'author' => sprintf($input,
            'author', 'author', 'author', __('Name*', 'sheepie')
        ), 
        'email' => sprintf($input,
            'email', 'email', 'email', __('Email*', 'sheepie')
        ), 
        'url' => sprintf($input,
            'url', 'url', 'url', __('Website', 'sheepie')
        )
    );

    comment_form(array(
        'id_form' => 'comments__form',
        'id_submit' => 'comments__submit',
        'title_reply' => '',
        'comment_field' => sprintf('<p id="textarea">%s</p>', $textarea),
        'comment_form_before_fields' => '<div class="comments__form">',
        'comment_form_after_fields' =>'</div>',
        'fields' => $fields,
    ));

    printf('</div>');
    printf('</div>');
}

?>
