<?php

function globetrotter_render_map_chart($id) {
    $bgColor = esc_attr(get_option('settings-map-bg-color'));
    echo '
    <div class="row justify-content-center" style="background-color:' . $bgColor . '">
        <div id="' . $id . '" class="chart"></div>
    </div>';
    return globetrotter_get_map_data($id, $bgColor);
}

function globetrotter_get_map_data($id, $bgColor) {
    $data = array(
        'id' => $id,
        'theme_url' => get_bloginfo('template_url'),
        'background_color' => $bgColor,
        'country_color' => get_option('settings-map-country-color'),
        'zoom' => get_option('settings-map-zoom'),
        'center' => array(
            'lat' => get_option('settings-map-center-lat'),
            'lng' => get_option('settings-map-center-lng')
        ),
        'plane_animation' => get_option('settings-map-plane'),
        'data' => []
    );
    $metaKeys = array(
        "chart-planned-trips" => array(
            "trip-origin",
            "trip-origin-lat",
            "trip-origin-lng",
            "trip-destination",
            "trip-destination-lat",
            "trip-destination-lng"
        ),
        "chart-places-visited" => array(
            "place-location",
            "place-location-lat",
            "place-location-lng",
            "place-rating"
        )
    );
    $currentKeys = $metaKeys[$id];
    $posts = get_posts(array(
        'post_type' => str_replace("chart-", "", $id),
        'numberposts' => -1
    ));
    if ($posts) {
        foreach ($posts as $post) {
            $postID = $post->ID;
            $postMeta = array("excerpt" => $post->post_excerpt);
            foreach ($currentKeys as $key) {
                $metaValue = get_post_meta($postID, $key);
                if ($metaValue) {
                   $postMeta[$key] = $metaValue[0];
                }
            }
            array_push($data['data'], $postMeta);
        }
    }
    globetrotter_load_map_script($id, $data);
    return $data['data'];
}

function globetrotter_load_map_script($id, $data) {
    wp_register_script($id, get_template_directory_uri() . '/dist/js/maps.js', array(), false, true);
    wp_localize_script($id, 'map_data', $data);
    wp_enqueue_script($id);
}

function globetrotter_render_map_list($id, $data) {
    $locationKey = ($id == 'chart-planned-trips') ? 'trip-destination' : 'place-location';
    $title = ucwords(str_replace(array('chart-', '-'), array('', ' '), $id));
    echo '
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h6 class="border-bottom border-gray pb-2 mb-0">' . $title . '</h6>';
        foreach ($data as $trip) {
            $flag = globetrotter_get_country_flag($trip[$locationKey]);
            echo '
            <div class="media text-muted pt-3 location-list-item">
                <img src="' . $flag . '" alt="Flag">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">' . $trip[$locationKey] . '</strong>
                    <span class="d-block">';
                    echo ($id === 'chart-places-visited') ? globetrotter_get_place_ratings($trip["place-rating"]) : '<em>From ' . $trip["trip-origin"] . '</em>';
                    echo '
                    </span>
                    <span>' . $trip["excerpt"] . '</span>
                </p>
            </div>';
        }
    echo '
    </div>';
}

function globetrotter_get_country_flag($location) {
    $country = explode(", ", $location);
    $flagDir = get_bloginfo('template_url') . '/img/flags/';
    $url = $flagDir . end($country) . '.png';
    $url = (@getimagesize(str_replace(' ', "%20", $url))) ? $url : $flagDir . 'notfound.png';
    return $url;
}

function globetrotter_get_place_ratings($rating) {
    $stars = array();
    for ($i = 1; $i <= $rating; $i++) {
        ($i % 2 == 0) ? array_splice($stars, -1, 1, '<i class="fas fa-star"></i>') : array_push($stars, '<i class="fas fa-star-half"></i>');
    }
    return implode("", $stars);
}
?>