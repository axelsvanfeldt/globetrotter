<?php 
$slug = get_post_field('post_name', get_post());
if ($slug != 'planned-trips' && $slug != 'places-visited' && get_header_image()): ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 py-0 px-0 header-image" style="background-image:url(<?php header_image(); ?>); height: <?php echo absint(get_custom_header()->height); ?>px; color:#<?php echo get_header_textcolor();?>">
                <h1 class="mt-5 font-weight-bold"><?php echo get_bloginfo('name'); ?></h1>
                <div class="pb-2 px-3 header-description" style="border-color:#<?php echo get_header_textcolor();?>"><?php echo get_bloginfo('description'); ?></div>
                <h5 class="mt-5 font-weight-bold"><?php echo globetrotter_get_header_title(); ?></h5>
                <?php get_template_part('template-parts/header/header', 'sharing'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>