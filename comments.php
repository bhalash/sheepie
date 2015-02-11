<?php if (comments_open()) {
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
        'comment_field' => '<p id="textarea"><textarea aria-required="true" class="comment-form-comment" id="comment" name="comment"></textarea></p>',
        'fields' => array(
            'author' => '<input aria-required="true" class="author-name" id="comment-author" name="author" placeholder="Name*" type="text" required>',
            'email' => '<input aria-required="true" class="author-email" id="comment-email" name="email" placeholder="Email*" type="text" required>',
            'url' => '<input aria-required="false" class="author-url" id="comment-url" name="url" placeholder="Website" type="text">'
        )
    ));

    printf('</div>');
} ?>