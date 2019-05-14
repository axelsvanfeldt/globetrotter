<?php
class GlobetrotterMapClass {
    
    private $metaKeys = array(
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
            "place-location-lng"      
        )
    );
    
    public function globetrotter_get_map_data($id) {
        $data = array();
        $currentKeys = $metaKeys[$id];
        $posts = get_posts(array('post_type' => str_replace("chart-", "", $id)));
        if ($posts) {
            foreach ($posts as $post) {
                $postID = $post->ID;
                $postMeta = array();
                foreach ($currentKeys as $key) {
                    $metaValue = get_post_meta($postID, $key);
                    if ($metaValue) {
                       $postMeta[$key] = $metaValue[0];
                    }
                }
                array_push($data, $postMeta);                
            }
        }
        return $data;
    }
    
    public globetrotter_load_map_script($id, $data) {
        wp_register_script($id, get_template_directory_uri() . '/js/render-maps.js', array(), false, true);
        wp_localize_script($id, 'map_data', $data);
        wp_enqueue_script($id);    
    }  
    
}
?>