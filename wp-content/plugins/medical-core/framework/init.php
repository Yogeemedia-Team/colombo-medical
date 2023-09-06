<?php 

//  add admin menu to display header footer builder

add_action( 'admin_menu', 'register_admin_page_for_header_footer' );
function register_admin_page_for_header_footer() {
	add_menu_page(
		'Donarity Header Footer',
		'Header Footer',
		'read',
		'donarity-header-footer',
		'', // Callback, leave empty
		'dashicons-feedback',
		14 // Position
	);
}


//  add custom postype 

$custom_postype = new \Dt_custom_postype\Dt_CustomPosttype;
$taxonomy = new \Dt_custom_postype\Dt_Taxonomies;

$custom_postype->dt_postype('project', 'Project', 'Projects', array('title', 'editor', 'thumbnail', 'excerpt'));
$taxonomy->dt_taxonomy( 'recent_project_cat', 'Category', 'Categories', 'project');
$custom_postype->dt_postype('header', 'Header', 'Headers', array( 'elementor'), 'donarity-header-footer');
$custom_postype->dt_postype('footer', 'Footer', 'Footers', array( 'elementor'), 'donarity-header-footer');


function donarity_header_footer_add_cpt_support() {

	//if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );

	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
		$cpt_support = [ 'header', 'footer']; //create array of our default supported post types
		update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
	}

}
add_action( 'after_switch_theme', 'donarity_header_footer_add_cpt_support' );