<?php get_header(); ?>
<div class="container">
    <?php globetrotter_get_template('template-parts/content/content', 'single'); ?>
</div>
<?php
comments_template();
get_footer(); 
?>