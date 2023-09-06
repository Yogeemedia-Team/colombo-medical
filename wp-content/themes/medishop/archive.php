<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package medishop
 */

get_header();

$description = medishop_opt('archive_description', 'show');

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
		do_action('medishop_banner_content', $banner_id, 'archive');
		
		medishop_wrapper_start( $blog_sidebar );
		
		 if ( have_posts() && $description == 'show') : ?>

			<header class="page-header">
				<?php
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
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
