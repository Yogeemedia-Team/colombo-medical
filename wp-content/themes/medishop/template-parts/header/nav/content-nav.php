<nav class="navbar navbar-expand-lg menu_one">
    <div class="container">
        <?php medishop_logo(); ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <?php 
            
                wp_nav_menu( array(
                        'menu_class' => 'navbar-nav menu ms-lg-auto',
                        'container'  => '',
                        'theme_location' => 'main_menu',
                        'walker'         => new Medishop_Navwalker(),
                        'fallback_cb'     => false,
                ) ); 

            ?>
            
        </div>
        <?php get_template_part( 'template-parts/header/nav/content-nav', 'serch'); ?>
    </div>
</nav>