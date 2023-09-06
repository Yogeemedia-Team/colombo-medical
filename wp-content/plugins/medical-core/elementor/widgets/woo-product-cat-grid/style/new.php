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
            <article class="dl-product-cat-grid-item<?php echo esc_attr( ' ' . $has_image ); ?>">
                <div class="dl-product-cat-grid-item-inner">

                    <?php if ( $image_src && 'yes' == $dlpro_woocg_cat_image_show ) : ?>
                        <div class="dl-product-cat-grid-thumbnail">
                            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $product_cat->name ); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="dl-product-cat-grid-content">
                        <div class="dl-product-cat-grid-content-inner">
                            <h2 class="dl-product-cat-grid-title">
                                <a href="<?php echo esc_url( get_term_link( $product_cat->term_id, 'product_cat' ) ); ?>">
                                    <?php echo esc_html( $product_cat->name ); ?>
                                </a>
                            </h2>

                            <?php if ( $dlpro_woocg_show_cats_count == 'yes' ) : ?>
                                <?php
                                    $count_text = '';
                                    if( 'classic' == $dlpro_woocg_skin ){
                                        $count_text = '('. $product_cat->count . ')';
                                    }
                                    if( 'minimal' == $dlpro_woocg_skin ){
                                        $count_text = $product_cat->count > 1 ? $product_cat->count . __( ' Items', 'happy-addons-pro' ) : $product_cat->count . __( ' Item', 'happy-addons-pro' );
                                    }
                                ?>
                                <div class="dl-product-cat-grid-count">
                                    <?php esc_html_e( $count_text ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
            <?php
        endforeach;
        ?>
</div>

<?php 
    $this->__dlpro_loadmore_btn();
?>