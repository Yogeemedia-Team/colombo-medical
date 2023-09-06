<article class="dl_pro_woolist_wrapper <?php echo esc_attr($_dl_woo_layout); ?>"> 
    <?php
    if ( $post_query->have_posts() ) {
        while( $post_query->have_posts()) : 
            $post_query->the_post();
            global $product;
            ?>
            <div class="dl_woolist_item">
                <?php if( $_dl_woolist_show_thumb == 'yes'){
                   $gallery_ids = $product->get_gallery_image_ids();
                   if ( is_array( $gallery_ids ) && count($gallery_ids) > 1 ) { 
                        $gallery_ids = $product->get_gallery_image_ids();   
                    ?>
                    <div class="dl_woolist_item_thumb best_pr_slider item-slider">
                    <?php  the_post_thumbnail( $_dl_woolist_feature_image_size ); ?>
                    </div>
                  <?php  }else{ ?>         
                    <div class="dl_woolist_item_thumb">
                        <a href="<?php the_permalink();?>" class="dl_woolist_link">
                            <?php  the_post_thumbnail( $_dl_woolist_feature_image_size ); ?>
                            <?php if( $_dl_woolist_show_badge == 'yes'){
                                woocommerce_show_product_loop_sale_flash();
                            }
                        ?>
                        </a>
                        <?php
                                do_action('woocommerce_after_shop_loop_item_title');

                            foreach($_dl_woo_ordering_data as $order){
                                    
                            $id_order_data = isset($order['_dl_woo_order_id']) ? $order['_dl_woo_order_id'] : '';

                            
                            if('yes' !== $order['_dl_woo_order_enable'] ){
                                continue;
                            }

                            if( $id_order_data == 'extra_info' ) {
                                ?>
                                <div class="dl_extra_info <?php echo esc_attr( ($_dl_woolist_extra_show_hover == 'yes') ? 'show_hover' : '' );?> <?php echo esc_attr( ($_dl_woolist_extra_show_vartical == 'yes') ? 'block-info' : '' );?> <?php echo esc_attr( ($_dl_woolist_extra_position == 'absolute') ? 'dl_absolute' : 'dl_relative' );?>">
                                <?php
                                if ( shortcode_exists( 'yith_quick_view' ) && $_dl_woolist_extra_show_quick_view =='yes' ) {
                                    echo do_shortcode( '[yith_quick_view]');
                                }
                                if ( shortcode_exists( 'yith_compare_button' )  && $_dl_woolist_extra_compare_view == 'yes') {
                                    echo do_shortcode( '[yith_compare_button container="yes"]');
                                }
                                $arg['class'] = implode( ' ', [
                                    'button',
                                    'product_type_' . $product->get_type(),
                                    'droit_add_to_cart',
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                ]);
                                if ( $_dl_woolist_extra_cart_view == 'yes' ):
                                    woocommerce_template_loop_add_to_cart($arg);
                                endif;
                                ?>
                                </div>
                                <?php

                            }

                        }  ?>

                    </div>
                <?php
                 }
                 }
                ?>
                
                <div class="dl_woolist_item_content">

                    <?php
                    
                    foreach($_dl_woo_ordering_data as $order){
                                    
                        $id_order = isset($order['_dl_woo_order_id']) ? $order['_dl_woo_order_id'] : '';

                        if('yes' !== $order['_dl_woo_order_enable'] ){
                            continue;
                        }

                        switch( $id_order ){
                            case 'product_title':
                                ?>
                                    <a href="<?php the_permalink();?>" class="dl_title"><h2><?php echo get_the_title();?></h2></a>
                                <?php
                            break;
                            case 'product_category':
                            ?>   
                            <div class="dl_post_category">
                                <?php
                                    $get_cat = wc_get_product_category_list( $post_query->ID, ' ' );
                                    echo !empty( $get_cat ) ? $get_cat : '';
                                ?>
                            </div>  

                            <?php 
                            break;

                            case 'product_content':
                                  if($_dl_woolist_content_type == 'excerpt'){ ?>
                                    <div class="dl_content"><?php  echo wp_trim_words( get_the_excerpt(), $_dl_woolist_excerpt_length,'....' ); ?></div>
                                 <?php }else{ ?>
                                    <div class="dl_content"><?php  echo wp_trim_words( get_the_content(), $_dl_woolist_excerpt_length,'....'); ?></div>
                                <?php  } 
                            break;

                            case 'product_meta':
                                ?>
                                <ul class="dl_entry_meta">
                                    <li><?php echo esc_html(get_the_date())?></li>
                                    <li><a href=""><?php echo esc_html(get_the_author())?></a></li>
                                </ul>
                                <?php
                            break;    

                            case 'product_price':
                                ?>
                                <div class="dl_post_price">
                                    <?php woocommerce_template_loop_price(); ?>
                                </div>
                                <?php
                            break;

                            case 'product_ratting':
                                ?>
                                <div class="dl_post_ratting">
                                    <div class="star-rating">
                                        <?php 
                                       
                                            $rating_count = $product->get_rating_count();
                                            $review_count = $product->get_review_count();
                                            $average = $product->get_average_rating();
                                            echo wc_get_star_rating_html($average, $review_count);
                                                                   
                                        ?>
                                        
                                    </div>
                                </div>
                                <?php
                            break;  

                            case 'product_button':
                                ?>
                                <div class="dl_add_cart">
                                    <?php
                                    $icon = ($_dl_woolist_addcart_icon['value']) ?? '';
                                    $arg['class'] = implode( ' ', [
                                        'button',
                                        'product_type_' . $product->get_type(),
                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                        $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
                                        'droit_add_to_cart',
                                        $icon,
                                        $_dl_woolist_addcart_icon_position
                                    ]);
                                    woocommerce_template_loop_add_to_cart($arg);
                                    ?>
                                </div>
                                <?php
                            break;
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        endwhile;
    }
    ?>
</article>