<?php

function globetrotter_add_menu_pages() {
    add_menu_page("Globetrotter Theme settings", "Globetrotter", "manage_options", "globetrotter-settings", 'globetrotter_render_general_settings');
    add_submenu_page("globetrotter-settings", "Globetrotter Theme settings", "General Settings", "manage_options", "globetrotter-settings", "globetrotter_render_general_settings");
    add_submenu_page("globetrotter-settings", "Globetrotter Map settings", "Map Settings", "manage_options", "globetrotter-map-settings", "globetrotter_render_map_settings");
    add_submenu_page("globetrotter-settings", "Globetrotter API settings", "API Settings", "manage_options", "globetrotter-api-settings", "globetrotter_render_api_settings");
}

function globetrotter_add_settings() {
    $defaultSettings = array(
        array(
            'group' => 'globetrotter-general-settings-group',
            'settings' => array(
                'settings-archive-layout' => 'cards',
                'settings-carousel-heading' => get_bloginfo(),
                'settings-carousel-bg-color' => '#004959',
                'settings-sharing-platforms' => array(
                    'facebook' => '1',
                    'google' => '1',
                    'pinterest' => '1',
                    'twitter' => '1',
                    'email' => '1',
                    'none' => '1'
                )
            )
        ),
        array(
            'group' => 'globetrotter-api-settings-group',
            'settings' => array(
                'settings-api' => 'algolia',
                'settings-algolia-app' => 'plMCFU64CZOU',
                'settings-algolia-key' => '986f339a1b1d1d89d7631cfb1ed48329',
                'settings-google-key' => ''
            )
        ),
        array(
            'group' => 'globetrotter-map-settings-group',
            'settings' => array(
                'settings-home-map' => 'enabled',
                'settings-map-center' => 'Mdina, Malta, Malta',
                'settings-map-center-lat' => 35.886,
                'settings-map-center-lng' => 14.4026,
                'settings-map-zoom' => 1,
                'settings-map-plane' => 'enabled',
                'settings-map-bg-color' => '#333',
                'settings-map-country-color' => '#555',   
            )
        )        
    );
    foreach ($defaultSettings as $group) {
        foreach ($group['settings'] as $setting => $defaultValue) {
            register_setting($group['group'], $setting);
            $value = get_option($setting);
            switch ($setting) {
                case 'settings-carousel-heading':
                    if ($value === false) {
                        update_option($setting, $defaultValue);
                    }
                    break;
                case 'settings-map-center':
                    if (!$value) {
                        update_option($setting, $defaultValue);
                        update_option('settings-map-center-lat', $group['settings']['settings-map-center-lat']);
                        update_option('settings-map-center-lng', $group['settings']['settings-map-center-lng']);
                    }                 
                    break;
                default:
                    if (!$value) {
                        update_option($setting, $defaultValue);
                    }
            }            
            
            if ($setting === 'settings-carousel-heading') {
                if ($value === false) {
                    update_option($setting, $defaultValue);
                }
            }
            else {
                if (!$value) {
                    update_option($setting, $defaultValue);
                }
            }
        }
    }
    add_settings_section('globetrotter-general-settings', '', 'globetrotter_render_general_settings_info', 'globetrotter-settings');
    add_settings_section('globetrotter-map-settings', '', 'globetrotter_render_map_settings_info', 'globetrotter-map-settings');
    add_settings_section('globetrotter-api-settings', '', 'globetrotter_render_api_settings_info', 'globetrotter-api-settings');
    add_settings_field('settings-archive-layout', 'Archive Layout', 'globetrotter_render_general_settings_archive_layout', 'globetrotter-settings', 'globetrotter-general-settings');
    add_settings_field('settings-sharing-platforms', 'Sharing Platforms', 'globetrotter_render_general_settings_sharing_platforms', 'globetrotter-settings', 'globetrotter-general-settings');
    add_settings_field('settings-carousel-heading', 'Carousel Heading', 'globetrotter_render_general_settings_carousel_heading', 'globetrotter-settings', 'globetrotter-general-settings');
    add_settings_field('settings-carousel-bg-color', 'Carousel Overlay', 'globetrotter_render_general_settings_carousel_bg', 'globetrotter-settings', 'globetrotter-general-settings');
    add_settings_field('settings-map-bg-color', 'Map Background Color', 'globetrotter_render_map_settings_map_bg_color', 'globetrotter-map-settings', 'globetrotter-map-settings');
    add_settings_field('settings-map-country-color', 'Map Country Color', 'globetrotter_render_map_settings_map_country_color', 'globetrotter-map-settings', 'globetrotter-map-settings');    
    add_settings_field('settings-map-center', 'Map Center', 'globetrotter_render_map_settings_map_center_location', 'globetrotter-map-settings', 'globetrotter-map-settings');
    add_settings_field('settings-map-zoom', 'Map Default Zoom', 'globetrotter_render_map_settings_map_zoom', 'globetrotter-map-settings', 'globetrotter-map-settings');
    add_settings_field('settings-map-plane', 'Map Plane Animation', 'globetrotter_render_map_settings_map_plane', 'globetrotter-map-settings', 'globetrotter-map-settings');
    add_settings_field('settings-select-api', 'Maps API', 'globetrotter_render_api_settings_api_select', 'globetrotter-api-settings', 'globetrotter-api-settings');
    add_settings_field('settings-algolia-app', 'Algolia App ID', 'globetrotter_render_api_settings_algolia_app', 'globetrotter-api-settings', 'globetrotter-api-settings');  
    add_settings_field('settings-algolia-key', 'Algolia API key', 'globetrotter_render_api_settings_algolia_key', 'globetrotter-api-settings', 'globetrotter-api-settings');  
    add_settings_field('settings-google-key', 'Google API key', 'globetrotter_render_api_settings_google_key', 'globetrotter-api-settings', 'globetrotter-api-settings');
}

function globetrotter_render_settings_subpage($page, $title, $group) {
    ?>
    <div id="globetrotter-settings" class="wrap">
    <h1><?php echo $title; ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields($group); ?>
            <?php do_settings_sections($page); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php     
}


function globetrotter_render_general_settings() {
    globetrotter_render_settings_subpage('globetrotter-settings', 'Globetrotter General Settings', 'globetrotter-general-settings-group');
}

function globetrotter_render_map_settings() {
    globetrotter_render_settings_subpage('globetrotter-map-settings', 'Globetrotter Map Settings', 'globetrotter-map-settings-group');
}

function globetrotter_render_api_settings() {
    globetrotter_render_settings_subpage('globetrotter-api-settings', 'Globetrotter API Settings', 'globetrotter-api-settings-group');
}

function globetrotter_render_general_settings_info() {
    echo '<p>...</p>';
}

function globetrotter_render_map_settings_info() {
    echo '<p>All Globetrotter Maps are interactive and responsive. The Zoom and Center values are only used upon the initial render of the map.</p>';
}

function globetrotter_render_api_settings_info() {
    ?>
    <p>An API is required to indentify the coordinates of locations submitted when using the features <a href="edit.php?post_type=places-visited" target="_blank">Places Visited</a> or <a href="edit.php?post_type=planned-trips" target="_blank">Planned Trips</a>. Without valid API credentials, those features will <em>not</em> work.</p>
    <p>You are free to select the Algolia Places API or the Google Places API. Your selection is only a matter of which one you find easier to register and won't affect any features of the theme.</p>
    <p>Read more on how to obtain a valid API credentials from <a href="https://www.algolia.com/users/sign_up" target="_blank">Algolia</a> or <a href="https://developers.google.com/places/web-service/get-api-key" target="_blank">Google</a>.</p>
    <?php
}

function globetrotter_render_settings_select($name, $options) {
    $content = '
    <select name="' . $name . '" class="settings-input-select" required>';
    foreach ($options as $option) {
        $selected = '';
        if ($option === get_option($name)) {
            $selected = 'selected';
        }
        $content .= '
        <option value="' . $option . '" ' . $selected . '>' . ucfirst($option) . '</option>';
    }
    $content .= '
    </select>
    <p class="description settings-alert">Please select a valid option!</p>';
    echo $content;    
}

function globetrotter_render_general_settings_carousel_heading() {
    $value = esc_attr(get_option('settings-carousel-heading'));
    echo '
    <input type="text" id="settings-carousel-heading" name="settings-carousel-heading" class="regular-text" value="' . $value . '" placeholder="Enter heading">
    <p class="description">The Carousel Heading is displayed below the site logo in the post carousel on the home page.</p>';
}

function globetrotter_render_general_settings_carousel_bg() {
    $value = esc_attr(get_option('settings-carousel-bg-color'));
    echo '
    <input type="text" name="settings-carousel-bg-color" class="settings-input-color" value="' . $value . '">
    <p class="description settings-alert">Please select a valid hex color!</p>
    <p class="description">Note that the overlay is somewhat transparent.</p>';
}

function globetrotter_render_general_settings_sharing_platforms() {
    $options = get_option('settings-sharing-platforms');
    echo '  
    <input type="checkbox" id="facebook" name="settings-sharing-platforms[facebook]" value="1"' . checked( 1, $options['facebook'], false) . '>
    <label for="facebook">Facebook</label>
    <br>
    <input type="checkbox" id="google" name="settings-sharing-platforms[google]" value="1"' . checked( 1, $options['google'], false) . '>
    <label for="google">Google+</label>
    <br>
    <input type="checkbox" id="pinterest" name="settings-sharing-platforms[pinterest]" value="1"' . checked( 1, $options['pinterest'], false) . '>
    <label for="pinterest">Pinterest</label>
    <br>
    <input type="checkbox" id="twitter" name="settings-sharing-platforms[twitter]" value="1"' . checked( 1, $options['twitter'], false) . '>
    <label for="twitter">Twitter</label>
    <br>
    <input type="checkbox" id="email" name="settings-sharing-platforms[email]" value="1"' . checked( 1, $options['email'], false) . '>
    <label for="email">Email</label>
    <br>      
    <input type="checkbox" id="none" name="settings-sharing-platforms[none]" value="1" style="display:none" checked>
    <p class="description">The selected sources enables visitors to share your pages on those platforms. Uncheck all platforms to remove the share block completely.</p>';
}

function globetrotter_render_map_settings_map_bg_color() {
    $value = esc_attr(get_option('settings-map-bg-color'));
    echo '
    <input type="text" name="settings-map-bg-color" class="settings-input-color" value="' . $value . '">
    <p class="description settings-alert">Please select a valid hex color!</p>';
}

function globetrotter_render_map_settings_map_country_color() {
    $value = esc_attr(get_option('settings-map-country-color'));
    echo '
    <input type="text" name="settings-map-country-color" class="settings-input-color" value="' . $value . '">
    <p class="description settings-alert">Please select a valid hex color!</p>';
}

function globetrotter_render_general_settings_archive_layout() {
    globetrotter_render_settings_select('settings-archive-layout', array('blocks', 'cards'));
    echo '<p class="description">the layout....</p>';
}

function globetrotter_render_map_settings_home_map() {
    globetrotter_render_settings_select('settings-home-map', array('enabled', 'disabled'));
}

function globetrotter_render_map_settings_map_theme() {
    globetrotter_render_settings_select('settings-map-theme', array('dark', 'light'));
}

function globetrotter_render_map_settings_map_plane() {
    globetrotter_render_settings_select('settings-map-plane', array('enabled', 'disabled'));
    echo '<p class="description">If enabled, a plane will be animated over the flight path between the origin and destination on maps displaying <a href="edit.php?post_type=planned-trips" target="_blank">Planned Trips</a>.</p>';
}

function globetrotter_render_map_settings_map_center_location() {
	$locationValue = esc_attr(get_option('settings-map-center'));
    $latValue = esc_attr(get_option('settings-map-center-lat'));
    $lngValue = esc_attr(get_option('settings-map-center-lng'));
	echo '
    <input type="text" id="settings-map-center" name="settings-map-center" class="regular-text settings-input-text" value="' . $locationValue . '" placeholder="Enter location" maxlength="120" required>
    <p class="description settings-alert">Please insert a valid text value!</p>
    <input type="hidden" id="settings-map-center-lat" name="settings-map-center-lat" value="' . $latValue . '">
    <input type="hidden" id="settings-map-center-lng" name="settings-map-center-lng" value="' . $lngValue . '">  ';
}

function globetrotter_render_map_settings_map_zoom() {
	$value = esc_attr(get_option('settings-map-zoom'));
	echo '
    <input type="number" class="settings-input-number" name="settings-map-zoom" min="1" max="32" value="' . $value . '" required>
    <p class="description settings-alert">Please insert a valid number!</p>
    <p class="description">Higher values zooms the map more....</p>';
}

function globetrotter_render_api_settings_api_select() {
    globetrotter_render_settings_select('settings-api', array('algolia', 'google'));
}

function globetrotter_render_api_settings_algolia_app() {
    $api = get_option('settings-api');
	$value = esc_attr(get_option('settings-algolia-app'));
    $description = ($value == 'plMCFU64CZOU' && $api === "algolia") ? '<p class="description settings-alert settings-alert-displayed">The App ID provided above is not intended for productional environments!</p>' : '';
	echo '<input type="text" name="settings-algolia-app" class="settings-api-input settings-api-input-algolia regular-text" value="' . $value . '" placeholder="Enter App ID" maxlength="64">' . $description;
}

function globetrotter_render_api_settings_algolia_key() {
    $api = get_option('settings-api');
	$value = esc_attr(get_option('settings-algolia-key'));
    $description = ($value == '986f339a1b1d1d89d7631cfb1ed48329' && $api === "algolia") ? '<p class="description settings-alert settings-alert-displayed">The API key provided above is not intended for productional environments!</p>' : '';
	echo '<input type="text" name="settings-algolia-key" class="settings-api-input settings-api-input-algolia regular-text" value="' . $value . '" placeholder="Enter API key" maxlength="64">' . $description;
}

function globetrotter_render_api_settings_google_key() {
	$value = esc_attr(get_option('settings-google-key'));
	echo '<input type="text" name="settings-google-key" class="settings-api-input settings-api-input-google regular-text" value="' . $value . '" placeholder="Enter API key" maxlength="64">';
}

function globetrotter_register_post_types() {
    register_post_type('places-visited', array(
        'labels' => array(
            'name' => __('Places Visited'),
            'all_items' => 'All Places'
        ),
        'public' => true,
        'supports' => array('title', 'excerpt'),
        'menu_icon' => get_template_directory_uri() . "/img/admin/places-visited.png"
    )); 
    register_post_type('planned-trips', array(
        'labels' => array(
            'name' => __('Planned Trips'),
            'all_items' => 'All Trips'
        ),
        'public' => true,
        'supports' => array('title', 'excerpt'),
        'menu_icon' => get_template_directory_uri() . "/img/admin/planned-trips.png"
    ));    
}

function globetrotter_add_editor_style() {
    add_editor_style('style-editor.css');
}

function globetrotter_add_meta_boxes() {
    add_meta_box(
        'meta-box-planned-trips',
        'Add Trip Locations',
        'globetrotter_render_meta_box_trip',
        'planned-trips'
    );
    add_meta_box(
        'meta-box-places-visited-location',
        'Add Location',
        'globetrotter_render_meta_box_place_location',
        'places-visited'
    );
    add_meta_box(
        'meta-box-places-visited-rating',
        'Rate Location',
        'globetrotter_render_meta_box_place_rating',
        'places-visited'
    );        
}

function globetrotter_render_meta_box_trip($post) {
    $originLocation = get_post_meta($post->ID, 'trip-origin', true) ? get_post_meta($post->ID, 'trip-origin', true) : '';
    $originLat = get_post_meta($post->ID, 'trip-origin-lat', true) ? get_post_meta($post->ID, 'trip-origin-lat', true) : '';
    $originLng = get_post_meta($post->ID, 'trip-origin-lng', true) ? get_post_meta($post->ID, 'trip-origin-lng', true) : '';
    $destinationLocation = get_post_meta($post->ID, 'trip-destination', true) ? get_post_meta($post->ID, 'trip-destination', true) : '';
    $destinationLat = get_post_meta($post->ID, 'trip-destination-lat', true) ? get_post_meta($post->ID, 'trip-destination-lat', true) : '';
    $destinationLng = get_post_meta($post->ID, 'trip-destination-lng', true) ? get_post_meta($post->ID, 'trip-destination-lng', true) : '';   
    echo '
    <div class="globetrotter-meta-box">
        <table>
            <tbody>' .
                globetrotter_render_meta_box_input('trip-origin', 'Origin', esc_attr($originLocation), esc_attr($originLat), esc_attr($originLng)) . 
                globetrotter_render_meta_box_input('trip-destination', 'Destination', esc_attr($destinationLocation), esc_attr($destinationLat), esc_attr($destinationLng)) . '            
            </tbody>
        </table>
        <p><em>Make sure to select a valid location from the suggestion box displayed when entering your input!</em></p>
    </div>';
}

function globetrotter_render_meta_box_place_location($post) {
    $location = get_post_meta($post->ID, 'place-location', true) ? get_post_meta($post->ID, 'place-location', true) : "";
    $lat = get_post_meta($post->ID, 'place-location-lat', true) ? get_post_meta($post->ID, 'place-location-lat', true) : "";
    $lng = get_post_meta($post->ID, 'place-location-lng', true) ? get_post_meta($post->ID, 'place-location-lng', true) : "";
    echo '
    <div class="globetrotter-meta-box">
        <table>
            <tbody>' .
                globetrotter_render_meta_box_input('place-location', 'Location', esc_attr($location), esc_attr($lat), esc_attr($lng)) . '
            </tbody>
        </table>
        <p><em>Make sure to select a valid location from the suggestion box displayed when entering your input!</em></p>
    </div>';
}

function globetrotter_render_meta_box_place_rating($post) {
    $rating = get_post_meta($post->ID, 'place-rating', true) ? get_post_meta($post->ID, 'place-rating', true) : "";
    echo '
    <div class="globetrotter-meta-box">
        <table>
            <tbody>' .
                globetrotter_render_meta_box_input('place-rating', 'Your Rating', esc_attr($rating)) . '
            </tbody>
        </table>
        <p><em>Rate your stay at this location on a 1-10 scale.</em></p>
    </div>';
}

function globetrotter_render_meta_box_input($identifier, $label, $primaryValue, $latValue = false, $lngValue = false) {
    if ($identifier == 'place-rating') {
        $content = '
        <input type="number" name="' . $identifier . '" id="' . $identifier . '" class=" settings-input-number" placeholder="Enter rating" min="1" max="10" value="' . $primaryValue . '" required>
        <p class="description settings-alert">Please insert a valid number!</p>';        
    }
    else {
        $content = '
        <input type="text" name="' . $identifier . '" id="' . $identifier . '" class=" settings-input-text" placeholder="Enter ' . strtolower($label) . '" value="' . $primaryValue . '" maxlength="120" required>
        <p class="description settings-alert">Please insert a valid text value!</p>
        <input type="hidden" id="' . $identifier . '-lat" name="' . $identifier . '-lat" value="' . $latValue . '">
        <input type="hidden" id="' . $identifier . '-lng" name="' . $identifier . '-lng" value="' . $lngValue . '">';
    }
    return '
    <tr>
        <th>
            <label for="' . $identifier . '">' . $label . ':</label>
        </th>
        <td>' .
            $content . '
        </td>
    </tr>';
}

function globetrotter_save_meta_box_data($postID) {
    $metaBoxValues = array("trip-origin", "trip-origin-lat", "trip-origin-lng", "trip-destination", "trip-destination-lat", "trip-destination-lng", "place-location", "place-location-lat", "place-location-lng", "place-rating");
    foreach ($metaBoxValues as $key) {
        if (array_key_exists($key, $_POST)) {
            $value = globetrotter_validate_meta_box_input($key, $_POST[$key]);
            update_post_meta($postID, $key, $value);
        }
    }
}

function globetrotter_validate_meta_box_input($input, $value) {
    if (is_string($value)) {
        $allowedCharacters = (strpos($input, 'lat') !== false || strpos($input, 'lng') !== false || strpos($input, 'rating') !== false) ? 14 : 120;
        if (strlen($inputValue) > $allowedCharacters) {
            $value = substr($inputValue, 0, $allowedCharacters);
        }
        return sanitize_meta($input, $value, 'post');
    }
    return "";
}

add_action('admin_menu', 'globetrotter_add_menu_pages');
add_action('admin_init', 'globetrotter_add_settings');
add_action('admin_init', 'globetrotter_add_editor_style');
add_action('init', 'globetrotter_register_post_types');
add_action('add_meta_boxes', 'globetrotter_add_meta_boxes');
add_action('save_post', 'globetrotter_save_meta_box_data');
?>