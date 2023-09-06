<?php 

$is_banner = medishop_opt('error_banner_toggle', 'show');
$is_banner_title = medishop_opt('is_error_banner_title', 'show');
$banner_title = medishop_opt('error_banner_title', '404');
  
$banner_url = medishop_opt('error_banner_img_upload');
$show_breadcrumbs = medishop_opt('error_banner_breadcrumb', 'show');
$banner_background_url = MEDISHOP_IMAGES.'/blog/banner/blog_details_img.png';

if ($banner_url && !empty($banner_url['url'])) {
    $banner_background_url = $banner_url['url'];
}

if (!class_exists('Redux')) {
    $banner_background_url = '';
}

if ( $is_banner == 'show' ) {
    if ( $banner_background_url != '') :  ?>
        <div class="blog_breadcrumbs_area_two parallaxie" data-bg-img="<?php echo esc_url($banner_background_url); ?>">
        <div class="overlay_bg"></div>
    <?php else: ?>
        <div class="blog_breadcrumbs_area_two banner-with-color">
    <?php endif; ?>
        <div class="container">
            <div class="breadcrumb_content text-white text-center">
                <?php
                if ( $is_banner_title == 'show' ) {  ?>
                    <h1 class="page-title page_title"><?php echo  esc_html($banner_title); ?></h1>
                    <?php
                }
                if ( $show_breadcrumbs == 'show' ) {
                    medishop_breadcrumbs();
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}