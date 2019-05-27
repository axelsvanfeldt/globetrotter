<div class="container">
    <div class="row">
        <div class="col-12 py-2 px-2 py-sm-4 px-sm-4 single-image-wrapper">
            <?php echo wp_get_attachment_image(get_the_ID(), 'large-image', false, array("class" => "single-image mb-4")); ?>
            <div class="col-12 text-center">
                <?php //globetrotter_render_post_tags(get_the_ID()); ?>
                <h6>Published <?php echo globetrotter_time_ago(); ?> by <?php the_author(); ?></h6>
            </div>            
        </div>
    </div>
</div>
<?php comments_template('/template-parts/post/comments.php'); ?>