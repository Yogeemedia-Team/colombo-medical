<?php 
 /**
  * Display page banner 
  */
$show_banner = medishop_opt('shop_banner_toggle', 'show');
$show_banner_in_page = medishop_page_meta('is_banner', get_the_ID(), 1);

$banner_url = medishop_opt('shop_banner_img_upload');
$banner_url_page= medishop_page_meta('banner_background_image', get_the_ID());  

$show_title = medishop_opt('is_shop_banner_title', 'show');
$shop_banner_title = medishop_opt('shop_banner_title', 'Shop Page');

$shop_single_banner_title = medishop_opt('shop_single_banner_title', 'Product Details');

$show_breadcrumbs = medishop_opt('shop_banner_breadcrumb', 'show');

$banner_background_url = MEDISHOP_IMAGES.'/woocommerce/banner/banner.png';

if($banner_url_page && $banner_url_page != ''){
    $banner_background_url = $banner_url_page;
}elseif($banner_url && !empty($banner_url['url'])) {
    $banner_background_url = $banner_url['url'];
}
if(!class_exists('Redux')){
    $banner_background_url = '';
  }
if($show_banner == 'show'):
 if($show_banner_in_page):
?>

<?php if($banner_background_url != '') :  ?>
<div class="blog_breadcrumbs_area_two" data-bg-img="<?php echo esc_url($banner_background_url); ?>">
<div class="overlay_bg"></div>
<?php else: ?>
<div class="blog_breadcrumbs_area_two banner-with-color">
<?php endif; ?>       
    <div class="container">
        <div class="breadcrumb_content text-white text-center">
            <?php if($show_title == 'show') : ?>
                <?php if(is_shop()) { ?>
                <h2 class="page_title"><?php echo esc_html($shop_banner_title); ?></h2>
                <?php }elseif( is_product_category() ){ ?>
                    <h2 class="page_title"><?php the_archive_title(); ?></h2>
                    <?php }elseif (is_tax( 'pwb-brand' )) { ?>
                    <h2 class="page_title"><?php the_archive_title(); ?></h2>
               <?php }else{?>
                <h2 class="page_title"><?php echo esc_html( $shop_single_banner_title );  ?></h2>
                <?php } ?> 
            <?php endif;
            if($show_breadcrumbs  == 'show') : 
            medishop_breadcrumbs();
            endif; ?> 
        </div>
    </div>
</div>
<?php 
endif;
endif;
