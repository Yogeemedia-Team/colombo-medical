<?php
/**
 * template Name: Medishop Fluid
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Medishop
 */

get_header();

?>

	<main id="primary" class="site-main">

		<?php get_template_part('template-parts/banner/banner', 'page');

	    medishop_wrapper_start( 'full', 12);

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		medishop_wrapper_end( 'full' );
		?>
	</main><!-- #main -->

<?php
get_footer();
