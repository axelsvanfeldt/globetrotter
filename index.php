<?php
get_header();
globetrotter_get_template('template-parts/content/content', 'carousel');
?>
<div class="container mb-4 mb-lg-5">
    <?php globetrotter_get_post_templates('template-parts/content/content', 3); ?>
</div>
<?php get_footer(); ?>