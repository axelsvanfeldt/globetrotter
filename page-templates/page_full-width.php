<?php 
/* Template Name: Full width page */

get_header();?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 py-0 px-0">
            <?php globetrotter_get_template('template-parts/content/content', 'page'); ?>
        </div>
    </div>
</div>
<?php 
comments_template();
get_footer();
?>