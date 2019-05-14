<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
;?>
<div class="container-fluid">
    <div class="row">
        <div class="single-post-intro" style="background-image:url(<?php globetrotter_render_post_thumbnail(get_the_ID(), 'url', array(), 'auto-width'); ?>)">
            <?php 
            globetrotter_render_post_toggle($next_post, "next");
            globetrotter_render_post_toggle($prev_post, "previous");   
            ?>
            <div class="mb-3 w-75 mx-auto">
            <h1><?php the_title(); ?></h1>
            </div>
            <?php //globetrotter_render_post_tags(get_the_ID()); ?>
            <h6><strong>Published <?php echo globetrotter_time_ago(); ?> by <?php the_author(); ?></strong></h6>
            <?php globetrotter_render_share_icons(); ?>
        </div>
    </div>
</div>
<div class="container bg-white">
    <div class="row py-3 px-2 px-sm-4 py-sm-5">
        <div class="col-12">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php comments_template('/template-parts/post/comments.php'); ?>