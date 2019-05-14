
<?php
global $post;
$mapID = 'chart-' . $post->post_name;
?>
<div class="container-fluid">
    <?php $mapData = globetrotter_render_map_chart($mapID); ?>
</div>
<div class="container">
    <?php globetrotter_render_map_list($mapID, $mapData); ?>
</div>