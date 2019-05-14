<?php

function globetrotter_require_files() {
    if (is_admin()) {
        require get_template_directory() . '/inc/admin-functions.php';
    }
    else {
        require get_template_directory() . '/inc/template-functions.php';
        require get_template_directory() . '/inc/post-functions.php';
        require get_template_directory() . '/inc/map-functions.php';
    }  
}

function globetrotter_add_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('custom-logo', array(
        'height' => 128,
        'width' => 128,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description')
    ));
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'globetrotter'),
        'footer-menu' => __('Footer Menu', 'globetrotter'),
        'social-menu' => __( 'Social Menu', 'globetrotter')
    ));
    add_image_size('auto-width');
    add_image_size('customs-logo', 128);
    add_image_size('card-thumb', 426);
    add_image_size('large-image', 1920);
}

function globetrotter_load_core_resources() {
    wp_enqueue_style('font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat', array(), false, 'all');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), false, 'all');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all');
    wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.min.css', array(), false, 'all');
    wp_enqueue_style('stylesheet', get_stylesheet_uri());
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array(), false, false);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), false, false);
    wp_enqueue_script('lazysizes', get_template_directory_uri() . '/js/lazysizes-4.1.5.min.js', array(), false, false);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, false);
    global $post;
    if ($post->post_name === "planned-trips" || $post->post_name === "places-visited") {
        wp_enqueue_script('amcharts-core', get_template_directory_uri() . '/js/amcharts-core.min.js', array(), false, false);
        wp_enqueue_script('amcharts-maps', get_template_directory_uri() . '/js/amcharts-maps.min.js', array(), false, false);
        wp_enqueue_script('amcharts-world', get_template_directory_uri() . '/js/amcharts-worldLow.min.js', array(), false, false);
        wp_enqueue_script('amcharts-animated', get_template_directory_uri() . '/js/amcharts-animated.min.js', array(), false, false);
    }
}

function globetrotter_load_admin_resources() {
    wp_enqueue_style('font-montserrat', 'https://fonts.googleapis.com/css?family=Montserrat', array(), false, 'all');
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('admin-stylesheet', get_template_directory_uri() . '/css/admin-panel.css', array(), false, 'all');
    wp_enqueue_script('admin-js', get_template_directory_uri() . '/js/admin-settings.js', array('jquery', 'wp-color-picker'), false, true);
    $api = get_option('settings-api');
    if ($api === 'google') {
        $apiKey = esc_attr(get_option('settings-google-key'));
        wp_enqueue_script('google-places', 'https://maps.googleapis.com/maps/api/js?key=' . $apiKey . '&libraries=places', array(), false, true);    
        wp_enqueue_script('algolia-autocomplete', get_template_directory_uri() . '/js/autocomplete-google.js', array('google-places'), false, true);
    }
    else {
        $apiID = get_option('settings-algolia-app');
        $apiKey = get_option('settings-algolia-key');
        wp_register_script('algolia-places', get_template_directory_uri() . '/js/algolia-places.min.js', array(), false, true);
        wp_localize_script('algolia-places', 'algolia_data', array(
            'app_id' => $apiID,
            'api_key' => $apiKey,
        ));
        wp_enqueue_script('algolia-places');
        wp_enqueue_script('algolia-autocomplete', get_template_directory_uri() . '/js/autocomplete-algolia.js', array('algolia-places'), false, true);
    }
}

function globetrotter_render_title_tag() {
    ?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
}

add_action('after_setup_theme', 'globetrotter_add_theme_support');
add_action('wp_enqueue_scripts', 'globetrotter_load_core_resources');
add_action('admin_enqueue_scripts', 'globetrotter_load_admin_resources');
add_action('wp_head', 'globetrotter_render_title_tag');
globetrotter_require_files();
?>