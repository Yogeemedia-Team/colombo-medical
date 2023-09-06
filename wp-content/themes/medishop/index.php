<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
		 */
		 $banner_id = get_themebuilder_Id(get_the_ID(), 'banner');
		 /**
		  * hook --_medishop_banner -- 10
		  */
		 do_action('medishop_banner_content', $banner_id, 'blog');

	medishop_wrapper_start($blog_sidebar);

		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/blog/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );

			endwhile;

			medishop_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		medishop_wrapper_end( $blog_sidebar );
		 ?>
		 
	</main><!-- #main -->

<?php

get_footer();
