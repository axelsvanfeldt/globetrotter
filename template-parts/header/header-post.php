<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
?>
<div class="container-fluid">
    <div class="row">
        <div class="single-post-header" style="background-image:url(<?php echo globetrotter_get_post_thumbnail(get_the_ID(), 'url', array(), 'auto-width'); ?>)">
            <?php 
            globetrotter_render_post_toggle($next_post, "next");
            globetrotter_render_post_toggle($prev_post, "previous");   
            ?>
            <div class="mb-3 w-75 mx-auto">
                <h1><?php the_title(); ?></h1>
            </div>
            <h6 class="font-weight-bold">Published <?php echo globetrotter_time_ago(); ?></h6>
            <?php 
            globetrotter_render_post_tags(get_the_ID());
            get_template_part('template-parts/header/header', 'sharing');
            ?>
        </div>
    </div>
</div>