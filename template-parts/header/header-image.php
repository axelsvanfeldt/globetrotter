<?php 
if ((is_front_page() && is_home()) || (!is_front_page() && is_home())) {
	globetrotter_get_template('template-parts/content/content', 'carousel');
}
else if (is_single() && !is_attachment()) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="single-post-intro" style="background-image:url(<?php globetrotter_render_post_thumbnail(get_the_ID(), 'url', array(), 'auto-width'); ?>)">
                <?php 
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                globetrotter_render_post_toggle($next_post, "next");
                globetrotter_render_post_toggle($prev_post, "previous");   
                ?>
                <div class="mb-3 w-75 mx-auto">
                <h1><?php the_title(); ?></h1>
                </div>
                <?php //globetrotter_render_post_tags(get_the_ID()); ?>
                <h6 class="font-weight-bold">Published <?php echo globetrotter_time_ago(); ?></h6>
                <?php get_template_part('template-parts/header/header', 'sharing'); ?>
            </div>
        </div>
    </div>
    <?php
}
else {
    $slug = get_post_field('post_name', get_post());
    if ($slug != 'planned-trips' && $slug != 'places-visited'):
        if (get_header_image()): 
            $title = is_archive() ? single_month_title(' ', FALSE) : get_the_title();
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 py-0 px-0 header-image" style="background-image:url(<?php header_image(); ?>); height: <?php echo absint(get_custom_header()->height); ?>px; color:#<?php echo get_header_textcolor();?>">
                        <h1 class="mt-5 font-weight-bold"><?php echo get_bloginfo('name'); ?></h1>
                        <div class="pb-2 px-3 header-description" style="border-color:#<?php echo get_header_textcolor();?>"><?php echo get_bloginfo('description'); ?></div>
                        <h5 class="mt-5 font-weight-bold"><?php echo $title; ?></h5>
                        <?php get_template_part('template-parts/header/header', 'sharing'); ?>
                    </div>
                </div>
            </div>
        <?php 
        endif;      
    endif;
}
?>