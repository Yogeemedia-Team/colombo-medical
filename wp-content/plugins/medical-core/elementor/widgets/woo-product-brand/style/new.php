<?php use Elementor\Utils; ?>
<div class="dl-product-cat-grid-wrapper dl-product-cat-grid-<?php echo $dlpro_woocg_skin; ?>">
    <?php
        foreach ( $product_cats as $product_cat ) :

            $image_src = Utils::get_placeholder_image_src();
            $thumbnail_id = get_term_meta( $product_cat->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_image_src( $thumbnail_id, $dlpro_woocg_cat_image_size, false );

            if ( $image ) {
                $image_src = $image[0];
            }

            $has_image = '';
            if ( 'yes' == $dlpro_woocg_cat_image_show ) {
                $has_image = esc_attr( ' dl-product-cat-grid-has-image' );
            }

            ?>
            <?php if ( $image_src && 'yes' == $dlpro_woocg_cat_image_show ) : ?>
                        <div class="dl-product-cat-grid-thumbnail">
                            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $product_cat->name ); ?>">
                        </div>
                    <?php endif; ?>
            <?php
        endforeach;
        ?>
</div>

<?php 
    $this->__dlpro_loadmore_btn();
?>