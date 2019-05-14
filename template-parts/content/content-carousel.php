<div class="container-fluid mb-4 mb-lg-5">
    <div class="row">
        <div class="col-12 py-0 px-0">
            <div id="post-carousel" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false">
                <ol class="carousel-indicators">
                  <li data-target="#post-carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#post-carousel" data-slide-to="1"></li>
                  <li data-target="#post-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <?php globetrotter_render_post_carousel();?>
                </div>
                <a class="carousel-control-prev" href="#post-carousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#post-carousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>