<?php 
/**
 * template to display single page content 
 */
$show_social_share = medishop_opt('display_blog_share', 'no');

?>
<div class="blog_single_info">
    <div class="media_blog_content">
      <?php  if(has_post_thumbnail( )) {  ?>
        <div class="single-page-media">
           <?php the_post_thumbnail(); ?>
        </div>
        <?php } ?>
       
        <?php the_content();
        
            wp_link_pages(
                array(
                    'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'medishop' ) . '">',
                    'after'    => '</nav>',
                    /* translators: %: page number. */
                    'pagelink' => esc_html__( 'Page %', 'medishop' ),
                )
            );
        
        ?>
       
          <?php   if($show_social_share  == 'yes' && function_exists('_pluginname_social_share') || has_tag()){ ?>
            <div class="post_bottom">
             <?php 
              medishop_single_page_tag();
              if($show_social_share  == 'yes' && function_exists('_pluginname_social_share')){
                _pluginname_social_share();
            }
             ?>
            </div>
           <?php }  ?>
       
    </div>
</div>
                      
    <!-- End medical blog list area -->

 