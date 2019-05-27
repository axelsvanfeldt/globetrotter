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
    add_theme_support('custom-header', array(
        'default-image'      => get_template_directory_uri() . '/img/placeholders/header.jpg',
        'default-text-color' => 'FFF',
        'header-text'        => true,
        'width'              => 1920,
        'height'             => 360,
        'flex-width'         => false,
        'flex-height'        => true
    ));
    register_default_headers(array(
        'default' => array(
            'url'           => '%s/img/placeholders/header.jpg',
            'thumbnail_url' => '%s/img/placeholders/header.jpg',
            'description'   => __( 'Default image', 'globetrotter' )
        )
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

function apa() {
    echo "<h1>asdfasdfasdf</h1>";
}

function globetrotter_load_core_resources() {
    //wp_enqueue_style('stylesheet', get_stylesheet_uri());
    wp_deregister_script('jquery');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/dist/js/app.js', array(), false, false);
    wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css');    
}

function globetrotter_load_admin_resources() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('admin-js', get_template_directory_uri() . '/dist/js/admin.js', array('jquery', 'wp-color-picker'), false, true);
    $api = get_option('settings-api');
    if ($api === 'google') {
        $apiKey = esc_attr(get_option('settings-google-key'));
        wp_enqueue_script('google-places', 'https://maps.googleapis.com/maps/api/js?key=' . $apiKey . '&libraries=places', array(), false, true);
        wp_enqueue_script('algolia-autocomplete', get_template_directory_uri() . '/dist/js/autocomplete_google.js', array('google-places'), false, true);
    }
    else {
        $apiID = get_option('settings-algolia-app');
        $apiKey = get_option('settings-algolia-key');
        wp_register_script('algolia-autocomplete', get_template_directory_uri() . '/dist/js/autocomplete_algolia.js', array(), false, true);
        wp_localize_script('algolia-autocomplete', 'algolia_data', array(
            'app_id' => $apiID,
            'api_key' => $apiKey,
        ));
        wp_enqueue_script('algolia-autocomplete');
    }
}

function globetrotter_render_title_tag() {
    ?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
}

function globetrotter_initialize_widgets() {
	register_sidebar(
		array(
			'name'          => __('Footer', 'globetrotter'),
			'id'            => 'sidebar-footer',
			'description'   => __('Add widgets here to appear in your footer.', 'globetrotter'),
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
}


add_action('after_setup_theme', 'globetrotter_add_theme_support');
add_action('wp_enqueue_scripts', 'globetrotter_load_core_resources');
add_action('admin_enqueue_scripts', 'globetrotter_load_admin_resources');
add_action('wp_head', 'globetrotter_render_title_tag');
add_action('widgets_init', 'globetrotter_initialize_widgets');
globetrotter_require_files();
?>