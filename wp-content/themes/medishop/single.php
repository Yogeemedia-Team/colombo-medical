<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package medishop
 */

get_header();

$blog_sidebar = medishop_opt('blog_layout');
?>

	<main id="primary" class="site-main">
		<?php
		/**
		 * if active core plugin banner will pull from core plugin
		 * else default load form theme 
		 * @package _medishop Banner
		 * @since 1.0.0
		 * hook --_medishop_banner -- 10
		 */
		$banner_id = get_themebuilder_Id(get_the_ID(), 'banner');		 
		do_action('medishop_banner_content', $banner_id, 'single');
		
		medishop_wrapper_start( $blog_sidebar );

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/blog/content/content', 'single');
			 
			// Display About auther 
			medishop_about_author();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		wp_reset_postdata(  );
		
		medishop_wrapper_end($blog_sidebar);
		?>
	</main><!-- #main -->

<?php

get_footer();
