<?php
if ('post' === get_post_type()): 
    $postID = get_the_ID();
    ;?>
    <div id="post-<?php echo $postID; ?>" class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
        <div class="card mb-3 mt-3 shadow-sm">
            <a href="<?php the_permalink(); ?>">
                <?php echo
                globetrotter_get_post_thumbnail($postID, 'img', array(
                    'class' => 'card-img-top',
                    'alt' => 'Thumbnail'
                ), 'card-thumb'); ?>
            </a>
            <div class="card-body">
                <h5 class="card-title font-weight-bold"><?php the_title() ;?></h5>
                <p class="card-text"><?php echo globetrotter_shorten_post_excerpt(get_the_excerpt());?></p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Published <?php echo globetrotter_time_ago() . ' by ' . get_the_author(); ?></small>
            </div>
        </div>
    </div>
<?php endif; ?>