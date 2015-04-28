<?php

/**
 * Comment Output Template
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
    printf('<div class="article-comments" id="comments">');

    if (post_password_required()) {
        printf('<h5>%s</h5>', __('This post is password protected. Enter the password to view comments.'));
        return;
    }

    if (have_comments()) {
        $s = (get_comments_number() == 1) ? '' : 's';

        printf('<hr>');
        printf(__('<h5>%d comment%s on \'%s\':</h5>'), get_comments_number(), $s, get_the_title());
        printf('<ul>');

        wp_list_comments(array( 
            'callback' => 'rmwb_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul></div>');
    }

    printf('<hr><div id="comment-entry">');
    printf('<h5>%s on \'%s\':</h5>', __('Have your own say'), get_the_title());

    comment_form(array(
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => '',
        'comment_field' => '<p id="textarea"><textarea autocomplete="off" class="comment-form-comment" id="comment" name="comment" required></textarea></p>',
        'comment_form_before_fields' => '<div class="argh">',
        'comment_form_after_fields' =>'</div>',
        'fields' => array(
            'author' => '<input class="author-name" id="comment-author" name="author" placeholder="Name*" type="text" required>',
            'email' => '<input class="author-email" id="comment-email" name="email" placeholder="Email*" type="text" required>',
            'url' => '<input class="author-url" id="comment-url" name="url" placeholder="Website" type="text">'
        )
    ));

    printf('</div>');
} ?>