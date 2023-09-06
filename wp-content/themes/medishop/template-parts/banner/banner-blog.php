<?php
/**
* Display page banner
*/

$show_banner = medishop_opt('blog_banner_toggle', 'show')    ;
$banner_url = medishop_opt('blog_banner_img_upload');
$show_title = medishop_opt('is_blog_banner_title', 'show');
$title = medishop_opt('blog_banner_title', get_bloginfo('name'));
$banner_background_url = MEDISHOP_IMAGES.'/blog/banner/blog_details_img.png';
  
if ( $banner_url && !empty($banner_url['url']) ) {
    $banner_background_url = $banner_url['url'];
}

if (!class_exists('Redux')) {
    $banner_background_url = '';
}

if ( $show_banner == 'show' ) {
    if ( $banner_background_url != '' ) {  ?>
        <div class="blog_breadcrumbs_area_two parallaxie" data-bg-img="<?php echo esc_url($banner_background_url); ?>">
        <div class="overlay_bg"></div>
        <?php
    } else { ?>
        <div class="blog_breadcrumbs_area_two banner-with-color">
            <?php
            }
            ?>
            <div class="container">
                <div class="breadcrumb_content text-white text-center">
                    <?php
                    if ($show_title == 'show') { ?>
                        <h2 class="page_title">
                            <?php echo esc_html( $title ); ?>
                        </h2>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
}

