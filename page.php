<?php get_header(); ?>
<div class="container">
    <div clasS="row">
        <div class="col-12 py-4 px-4">
            <?php while (have_posts()) {
				the_post();
                the_content();
            } ?>
        </div>
    </div>
</div>
<?php 
comments_template();
get_footer();
?>