<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-12 py-4 px-4">
            <?php globetrotter_get_template('template-parts/content/content', 'page'); ?>
        </div>
    </div>
</div>
<?php 
comments_template();
get_footer();
?>