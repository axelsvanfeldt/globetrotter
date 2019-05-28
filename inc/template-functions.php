<?php

function globetrotter_get_template($template, $name = null) {
    if (have_posts()) {
        the_post();
        get_template_part($template, $name);
    }
    else {
        get_template_part('template-parts/content/content', 'notfound');
    }
}

function globetrotter_get_post_templates($template) {
    $postQuery = new WP_Query($args = array(
        'post_type' => 'post'
    ));
    if($postQuery->have_posts() ) {
        while($postQuery->have_posts() ) {
            $postQuery->the_post();
            if ($i % $postsPerRow == 0) {
                echo $i ? '</div><div class="row justify-content-center">' : '<div class="row justify-content-center">';
            }
            get_template_part($template);
            if (($i + 1) === 3) {
                echo '</div>';
            }
            $i++;
        }
    }
    else {
        get_template_part('/template-parts/content/content', 'notfound');
    }
}

function globetrotter_render_custom_logo($class = '') {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'customs-logo');
    if (has_custom_logo()) {
        echo '<img class="logo ' . $class . '" src="' . $logo[0] . '" alt="' . get_bloginfo( 'name' ) . '">';
    }
}

function globetrotter_hex_to_rgb($hex) {
    $rgb = array(0,0,0);
    if (is_string($hex)) {
        $hex = str_replace("#", "", $hex);
        $rgb = (strlen($hex) === 3) ? array(hexdec($hex[0]), hexdec($hex[1]), hexdec($hex[2])) : array(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    }
    return $rgb;
}

function globetrotter_add_menu_link_class($atts, $item, $args) {
    if ($args->link_class) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}

function globetrotter_add_menu_list_item_class($classes, $item, $args) {
    if ($args->theme_location === 'main-menu') {
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active ';
        }
    }
    return $classes;
}

function globetrotter_add_menu_social_icons($item_output, $item, $depth, $args) {
	if ('social-menu' === $args->theme_location) {
        $social_icons_map = array(
            'amazon' => array(
                'amazon.com',
                'amazon.cn',
                'amazon.in',
                'amazon.fr',
                'amazon.de',
                'amazon.it',
                'amazon.nl',
                'amazon.es',
                'amazon.co',
                'amazon.ca',
            ),
            'apple' => array(
                'apple.com',
                'itunes.com',
            ),
            'behance' => array(
                'behance.net',
            ),
            'codepen' => array(
                'codepen.io',
            ),
            'facebook' => array(
                'facebook.com',
                'fb.me',
            ),
            'get-pocket' => array(
                'getpocket.com',
            ),        
            'github' => array(
                'github.com',
            ),        
            'google-plus' => array(
                'plus.google.com',
            ),
            'instagram' => array(
                'instagram.com',
            ),        
            'lastfm' => array(
                'last.fm',
            ),
            'linkedin' => array(
                'linkedin.com',
            ),        
            'envelope' => array(
                'mailto:',
            ),
            'reddit' => array(
                'reddit.com',
            ),
            'rss' => array(
                'rss',
                'feed',
            ),             
            'slideshare' => array(
                'slideshare.net',
            ),
            'snapchat' => array(
                'snapchat.com',
                'snap.com',
            ),
            'spotify' => array(
                'spotify.com',
            ),         
            'twitch' => array(
                'twitch.tv',
            ),
            'twitter' => array(
                'twitter.com',
            ),
            'tumblr' => array(
                'tumblr.com',
            ),         
            'wordpress' => array(
                'wordpress.com',
                'wordpress.org',
            ),
            'youtube' => array(
                'youtube.com',
                'youtu.be',
            ),        
        );          
        $url = $item->url;
        $icon = '<i class="fas fa-link"></i>';
        foreach ($social_icons_map as $source => $domains) {
            foreach ($domains as $domain) {
                if (strpos($url, $domain) !== false) {
                    $icon = globetrotter_get_fa_icon($source);
                    break 2;
                }
            }
        }
		$item_output = str_replace(array('<a ', $item->post_title), array('<a target="_blank" ', $icon), $item_output);
	}
	return $item_output;
}

add_filter('walker_nav_menu_start_el', 'globetrotter_add_menu_social_icons', 10, 4);
add_filter('nav_menu_link_attributes', 'globetrotter_add_menu_link_class', 1, 3);
add_filter('nav_menu_css_class', 'globetrotter_add_menu_list_item_class', 1, 3);
?>