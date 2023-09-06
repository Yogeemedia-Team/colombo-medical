<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('SAASLAND_acf_field_file_name') ) :


class essential_acf_field_file_name extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'Saasland Mega Menu Select';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Saasland Mega Menu Select', 'saasland-core');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'basic';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		
	
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'saasland-core'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		
		// do not delete!
    	parent::__construct();
    	
	}

	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/	
		/*
		*  Create a simple text input using the 'font_size' setting.
		*/

        $arrgs = [
            'post_type' => 'droit-templates',
        ];

        $get_posts = get_posts($arrgs);
        
        $mega_menu = [];
        if(is_array($get_posts) && !empty($get_posts)) {
            foreach($get_posts as $posts) {
                 $get_meta_value = get_post_meta($posts->ID, 'dtdr_header_templates', true);
                 $mega_menu_true = $get_meta_value['type'];
                 if($mega_menu_true != 'megamenu') {
                     continue;
                 }
                $mega_menu[$posts->ID] = $posts->post_title;
                
            }
        }
      	
		?>
        <select class="" name="<?php echo esc_attr($field['name']) ?>">
            <option value=> <?php echo esc_html__('Select Menu', 'saasland-core') ?> </option>
            <?php 
             if(!empty($mega_menu)) {
                 foreach ($mega_menu as $key=>$menu)  { ?>
                     <option value="<?php echo esc_attr($key); ?>" <?php selected( $field['value'], $key ); ?>><?php echo esc_html($menu); ?></option>
                     <?php 
                 }
             }
            ?>
        </select>
		<!-- <input type="text" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" style="font-size:<?php echo $field['font_size'] ?>px;" /> -->
		<?php
	}
	
}


// initialize
new essential_acf_field_file_name( $this->settings );


// class_exists check
endif;


