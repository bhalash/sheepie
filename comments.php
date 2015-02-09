<?php if (comments_open()) {
    printf('<div class="article-comments" id="comments">');

    if (post_password_required()) {
        printf('<h5>%s</h5>', 'This post is password protected. Enter the password to view comments.');
        return;
    }

    if (have_comments()) {
        printf('<hr><h5>%s</h5>', get_comments_number('% comments.', '1 comment.', '% comments.'));
        printf('<ul>');
        
        wp_list_comments(array( 
            'callback' => 'rmwb_comments',
            'avatar_size' => 0,
            'format' => 'html5',
            'style' => 'ul'
        ));

        printf('</ul></div>');
    }

    printf('<div id="comment-entry">');

    comment_form(array(
        'title_reply' => 'Have your say!',
        'comment_field' => '<p id="textarea"><textarea aria-required="true" class="comment-form-comment" id="comment" name="comment"></textarea></p>',
        'fields' => array(
            'author' => '<input aria-required="true" class="author-name" id="author" name="author" placeholder="Name*" type="text" required>',
            'email' => '<input aria-required="true" class="author-email" id="email" name="email" placeholder="Email*" type="text" required>',
            'url' => '<input aria-required="false" class="author-url" id="url" name="url" placeholder="Website" type="text">'
        )
    ));

    printf('</div>');
} ?>