<?php 
get_header(); 
if (comments_open()): ?>
    <div class="container-fluid bg-light-gray">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 pt-4 pb-2 px-3 pb-sm-2 px-sm-4 my-sm-5 rounded bg-light">
            <?php comment_form(array(
                'id_form' => 'comments-form',
                'class_submit' => 'btn btn-secondary',
                'title_reply' => __( 'Leave a comment'),
                'fields' => array(
                    'author' => '
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="author">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . '>
                            </div>
                        </div>',
                    'email' => '
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="email">Email Address</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . '>
                            </div>
                        </div>',
                    'url' => '
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="url">Website</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" >
                            </div>
                        </div>',
                    'cookies' => '
                        <div class="form-group row">
                            <div class="col-sm-3">Remember me</div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wp-comment-cookies-consent" value="yes"' . $consent . ' >
                                    <label class="form-check-label" for="wp-comment-cookies-consent">' . __( 'Save settings for the next time I comment.' ) . '</label>
                                </div>
                            </div>
                        </div>'
                ),
                'comment_field' => '
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="comment" id="comment" rows="3" aria-required="true" placeholder="Enter comment"></textarea>
                        </div>
                    </div>',
                'comment_notes_before' => '
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <small class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</small>
                        </div>
                    </div>'
            ), get_the_ID()); ?>
            </div>
        </div>
        <?php if (have_comments()): ?>
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-5">
            <?php wp_list_comments(array(
                'style' => 'div',
                'avatar_size' => 42,
            )); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php 
endif;
get_footer();
?>