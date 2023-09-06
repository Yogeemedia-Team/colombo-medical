<div class="relatedposts">
<h3><?php esc_html_e( 'Related posts', 'medishop') ?></h3>
<div class="row">
 <?php

  global $post;
  $tags = wp_get_post_tags($post->ID);
  $tag_ids = array();

  if ($tags) {
    foreach ($tags as $tag){
        $tag_ids[] = $tag->term_id;
    }
  }
  
  
  $args = [
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'posts_per_page'=>3, // Number of related posts to display.
  ];

  $relataed_post = new wp_query( $args );


  if($relataed_post->have_posts(  )){
      
     while($relataed_post->have_posts(  )){
         $relataed_post->the_post();
         ?>
         
           <div class="col-sm-4">
            <?php the_title('<h3><a href="'.esc_url(get_the_permalink()).'"></a>', '</a></h3>'); ?>
            <?php if(has_post_thumbnail()){ ?>
             <a href="<?php echo esc_url( get_the_permalink(get_the_ID()) ) ?>">
               <?php the_post_thumbnail(); ?>
             </a>
             <?php } ?>
           </div>
        
         <?php
     }
  }

  ?>
  </div>
</div>