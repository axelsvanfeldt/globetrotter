<?php get_header(); 
$year     = get_query_var('year');
$monthnum = get_query_var('monthnum');
?>
<div class="container my-4 my-lg-5">
    <?php globetrotter_get_post_templates(array(
        'year' => $year,
        'month' => $monthnum
    )); ?>
</div>
<?php get_footer(); ?>