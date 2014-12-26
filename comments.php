<?php if (comments_open()) : ?>
    <div class="article-comments" id="comments">
        <?php if (post_password_required()) : ?>
            <h3>This post is password protected. Enter the password to view comments.</h3>
        <?php return; endif; ?>
        <?php if (have_comments()) : ?>
            <h3 class="title"><?php comments_number('% comments.', '1 comment.', '% comments.');?></h3>
            <ul>
                <?php wp_list_comments(
                    array( 
                        'callback' => 'rmwb_comments',
                        'avatar_size' => 0,
                        'format' => 'html5',
                        'style' => 'ul'
                    )
                ); ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="comment-entry">
        <?php 
        $comment_form_fields = array (
            'author' => '<input aria-required="true" class="author-name" id="author" name="author" placeholder="Name*" type="text">',
            'email' => '<input aria-required="true" class="author-email" id="email" name="email" placeholder="Email*" type="email">',
            'url' => '<input aria-required="true" class="author-url" id="url" name="url" placeholder="Website" type="url">'
            );

        comment_form( 
            array (
                'title_reply' => 'Say something',
                'comment_field' => '<p><textarea aria-required="true" class="comment-form-comment" id="comment" name="comment" rows="10"></textarea></p>',
                'fields' => $comment_form_fields
            )
        ); ?>
    </div>
<?php endif; ?>