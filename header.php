<!DOCTYPE html>
<html class="bg-dark">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php get_template_part('template-parts/header/navigation'); ?>
<div id="content" class="d-flex flex-column h-100">