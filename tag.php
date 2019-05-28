<?php 
get_header(); 
$tag = get_queried_object();
?>
<div class="container my-4 my-lg-5">
    <?php globetrotter_get_post_templates(array('tag' => $tag->slug)); ?>
</div>
<?php get_footer(); ?>