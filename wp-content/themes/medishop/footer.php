<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package medishop
 */
global $post;
$footer = get_themebuilder_Id(get_the_ID(), 'footer');
/**
 * add header
 * hook _medishop_footer -- 10;
 */
do_action('_medishop_footer_content', $footer);
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
