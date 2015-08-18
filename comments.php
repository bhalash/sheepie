<?php

/**
 * Comments Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * This file is part of Sheepie.
 * 
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
 */

if (comments_open()) {
    if (post_password_required()) {
        return;
    }

    printf('<div class="article-comments" id="comments">');
        printf('<h4 class="comments-title subtitle">%s \'%s\'</h4>',
            __('Have your say on ', TTD),
            get_the_title()
        );

    if (have_comments()) {
        printf('<ul class="%s">', 'commentlist');

        wp_list_comments(array(
            'callback' => 'theme_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul>');
    }

    printf('<div id="comment-entry">');

    // Template input for name, email and URL.
    $input = '<input class="%s-name" id="%s" name="%s" placeholder="%s" type="text" required="required">';
    $textarea = '<textarea class="comment-form-comment" id="comment" name="comment" required="required"></textarea>';

    $fields = array(
        // Name, author and email fields.
        'author' => sprintf($input,
            'author', 'author', 'author', __('Name*', TTD)
        ), 
        'email' => sprintf($input,
            'email', 'email', 'email', __('Email*', TTD)
        ), 
        'url' => sprintf($input,
            'url', 'url', 'url', __('Website', TTD)
        )
    );

    comment_form(array(
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => '',
        'comment_field' => sprintf('<p id="textarea">%s</p>', $textarea),
        'comment_form_before_fields' => '<div class="comment-form">',
        'comment_form_after_fields' =>'</div>',
        'fields' => $fields,
    ));

    printf('</div>');
    printf('</div>');
}

?>
