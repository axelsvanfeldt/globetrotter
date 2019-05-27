<?php 
/* Template Name: Full width page */

get_header();?>
<div class="container-fluid">
    <div clasS="row">
        <div class="col-12 py-0 px-0">
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