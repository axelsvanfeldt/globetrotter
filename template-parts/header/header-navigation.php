<header>
    <nav id="top-menu" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php globetrotter_render_custom_logo(); ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-top-menu" aria-controls="navbar-top-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php wp_nav_menu(array(
            'theme_location' => 'main-menu',
            'container_id' => 'navbar-top-menu',
            'container_class' => 'collapse navbar-collapse',
            'menu_class'     => 'navbar-nav',
            'list_item_class' => "nav-item",
            'link_class' => "nav-link",
        ));
        wp_nav_menu(array(
            'theme_location' => 'social-menu',
            'container_class' => 'social-menu d-none d-lg-block',
            'menu_class'     => 'nav',
            'list_item_class' => "nav-item",
            'link_class' => "nav-link white-link pl-2 pl-2",
        )); ?>          
    </nav>    
</header>