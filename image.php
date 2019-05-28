<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) {
        the_post(); ?>
        <div class="row">
            <div class="col-12 py-2 px-2 py-sm-4 px-sm-4 single-image-wrapper">
                <?php echo wp_get_attachment_image(get_the_ID(), 'large-image', false, array("class" => "single-image mb-4")); ?>
                <div class="col-12 text-center">
                    <h6>Published <?php echo globetrotter_time_ago(); ?> by <?php the_author(); ?></h6>
                </div>
            </div>
        </div>
    <?php 
    }
    else {
        get_template_part('template-parts/content/content', 'notfound');
    } ?>
</div>
<?php
comments_template();
get_footer(); 
?>