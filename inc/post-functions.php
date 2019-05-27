<?php 

function globetrotter_render_post_carousel() {
    $overlayColor = globetrotter_hex_to_rgb(esc_attr(get_option('settings-carousel-bg-color')));
    $overlayColor = 'rgba(' . implode(",", $overlayColor) . ',0.6)';
    $postQuery = get_posts(array(
        'post_type' => 'post',
        'numberposts' => 3
    ));
    $postCount = count($postQuery);
    for ($i = 0; $i < $postCount; $i++) {
        $postId = $postQuery[$i]->ID;
        $postTitle = $postQuery[$i]->post_title;
        $active = $i ? '' : ' active';
        echo '
        <div class="carousel-item' . $active . '">';
            globetrotter_render_post_thumbnail($postId, 'img', array(
                'class' => 'd-block post-carousel-image',
                'alt' => $postTitle
            ),  'auto-width');
            echo '
            <div class="post-carousel-overlay" style="background:' . $overlayColor . '">
                <div class="carousel-caption d-block">';
                    globetrotter_render_custom_logo(); 
                    echo '
                    <h3 class="mt-4">' . esc_html(get_option('settings-carousel-heading')) . '</h3>
                    <h3 class="font-weight-bold mt-4 mt-xl-5 mb-5">' . $postTitle . '</h3>
                    <a class="white-link" href="' . get_permalink($postId) . '">
                        <div class="transparent-btn">Read post</div>
                    </a>
                </div>
            </div>
        </div>';
    }
}

function globetrotter_render_post_thumbnail($id, $return, $attr = array(), $size = 'post-thumbnail') {
    if (has_post_thumbnail($id)) {
        $image = ($return === 'img') ? get_the_post_thumbnail($id, $size, $attr) : get_the_post_thumbnail_url($id);
    }
    else {
        if ($return === 'img') {
            $image = '<img src="' . get_template_directory_uri() . '/img/placeholders/post.jpg" ';
            foreach ($attr as $key => $value) {
                $image .= $key . '="' . $value . '" ';
            }
            $image .= '>';
        }
        else {
            $image = get_template_directory_uri() . '/img/placeholders/post.jpg';
        }
    }
    echo $image;
}

function globetrotter_render_post_tags($id) {
    $tags = get_the_tags($id);
    $content = '';
    if ($tags) {
        $content = '
        <ul class="nav justify-content-center mt-3 mb-3">';
        foreach ($tags as $tag) {
            $content .= '
            <li class="nav-item">
                <a class="nav-link white-link pl-1 pr-1" href="#"><div class="transparent-btn">#' . $tag->name . '</div></a>
            </li>';
        }
        $content .= '
        </ul>';
    }
    echo $content;
}

function globetrotter_render_post_toggle($togglePost, $direction) {
    if (!empty($togglePost)) {
        $faIcon = ($direction == "next") ? "left" : "right";
        echo '
        <div class="single-post-toggle single-post-toggle-' . $direction . ' d-none d-sm-block">
            <a class="white-link" href="' . esc_url(get_permalink($togglePost->ID)) . '">
                <i class="fas fa-angle-double-' . $faIcon . '"></i>
                <div>' . $direction . ' post</div>
            </a>
        </div>';
    }    
}

function globetrotter_get_fa_icon($source) {
    if ($source == "email") {
        $source = "envelope";
    }
    $fasSources = array("envelope", "rss");
    $icon = in_array($source, $fasSources) ? 'fas fa-' . $source : 'fab fa-' . $source;
    return '<i class="' . $icon . '"></i>';
}

function globetrotter_get_share_url($source) {
    global $wp;
    $currentURL = rawurlencode(home_url(add_query_arg(array(), $wp->request)));
    $urlMap = array(
        "email"     => 'mailto:?body=' . $currentURL,
        "facebook"  => 'https://www.facebook.com/sharer/sharer.php?u=' . $currentURL . '&title=' . $currentURL,
        "google"    => 'https://plus.google.com/share?url=' . $currentURL,
        "linkedin"  => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $currentURL,
        "pinterest" => 'https://pinterest.com/pin/create/link/?url=' . $currentURL,
        "twitter"   => 'https://twitter.com/home?status=' . $currentURL,
    );
    if (array_key_exists($source, $urlMap)) {
        return $urlMap[$source];
    }
    return false;
}

function globetrotter_time_ago() {
	return human_time_diff(get_the_time('U'), current_time('timestamp')).' '.__('ago');
}

function globetrotter_shorten_post_excerpt($content) {
    $short = (strlen($content) > 60) ? substr($content, 0, 60 + strpos(substr($content, 60), ' ')) : $content;
    if (substr($short, -1) === "!" || substr($short, -1) === "?") {
        $short = substr($short, 0, -1);
    }
    return $short . "...";
}
?>