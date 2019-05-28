<?php 
$platforms = get_option('settings-sharing-platforms');
if (count($platforms) > 1): ?>
    <div class="single-post-shares">
        <h6 class="mt-5 mb-2">Share this page</h6>
        <ul class="nav justify-content-center social-menu">
        <?php foreach ($platforms as $source => $val):
            if ($source != 'none'):
                $url = globetrotter_get_share_url($source);
                if ($url): ?>
                    <li class="nav-item">
                        <a class="nav-link white-link" href="<?php echo esc_url($url); ?>" target="_blank"><?php echo globetrotter_get_fa_icon($source); ?></a>
                    </li>
                <?php 
                endif;
            endif;
        endforeach; ?>
        </ul>
    </div>
<?php endif;?>