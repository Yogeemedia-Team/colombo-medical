<?php
 
 $display_search = medishop_opt('search_icon_toggle', 'yes');

 if($display_search =='yes') : 

$medishop_unique_id = wp_unique_id( 'search-form-' );
$medishop_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';

?>
<ul class="navbar-nav search_cart">
    <li class="nav-item search"><a class="nav-link search-btn" href="javascript:void(0);"><i
                class="icon-search"></i></a>
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="menu-search-form" <?php echo medishop_return($medishop_aria_label); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?>>
            <div class="input-group">
                <input type="search" class="form-control" placeholder="<?php echo esc_attr_e( 'Search...', 'medishop' ) ?>" id="<?php echo esc_attr( $medishop_unique_id ); ?>" value="<?php echo get_search_query(); ?>" name="s">
                <button type="submit"><i class="ti-arrow-right"></i></button>
            </div>
        </form>
    </li>
</ul>
<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
    aria-expanded="false" aria-label="Toggle navigation">
    <span></span><span></span><span></span><span></span><span></span><span></span>
</button>

<?php 
endif;