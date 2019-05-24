</div>
<footer class="footer py-5 navbar-dark bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-4">                      
                <?php wp_nav_menu(array(
                    'theme_location'    => 'footer-menu',
                    'menu_class'        => 'nav flex-column',
                    'list_item_class'   => "nav-item",
                    'link_class'        => "nav-link white-link",
                )); ?>
            </div>            
            <div class="col-4 text-center">
                <?php 
                globetrotter_render_custom_logo(); 
                echo '
                <h5>' . get_bloginfo() . '</h5>
                <p><a class="white-link" href="mailto:"' . get_bloginfo('admin_email') . '" target="_blank">' . get_bloginfo('admin_email') . '</a></p>';
                wp_nav_menu(array(
                    'theme_location'    => 'social-menu',
                    'container_class'   => 'social-menu my-3',
                    'menu_class'        => 'nav justify-content-center',
                    'list_item_class'   => "nav-item",
                    'link_class'        => "nav-link white-link pl-2 pl-2",
                ));
                ?>
                <small>Copyright © <?php echo date('Y');?> - All rights reserved.</small>
            </div>
            <div class="col-4">
                <?php get_template_part('template-parts/footer/widgets'); ?>
            </div>
        </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>