<?php 

class Medishop_Navwalker extends Walker_Nav_Menu  {

    public function start_lvl( &$output, $depth = 0, $args = []) {

       $indent = str_repeat("\t", $depth);
       $output .= "\n$indent<ul class=\"dropdown-menu sub-menu submenu\">\n";
    }

    public function start_el(&$output, $page, $depth = 0, $args = [], $current_page = 0) {
         $indent = ($depth) ? str_repeat("\t", $depth) : '';
         $mega_menu = '';
         $mega_menu_width = '';
         if(class_exists('ACF')) {
            $mega_menu = get_field( 'mega_menu_select', $page->ID, true);
            $mega_menu_width = get_field( 'mega_menu_width', $page->ID, true);
         }
         
         $li_attributes = '';
         $class_names = $value = '';
         $classes =  empty($page->classes) ? array() : (array) $page->classes ;    
         $classes[] = 'nav-item' ;
         $classes[] = ($mega_menu != '') ? 'has-mega-menu': '' ;
         $classes[] = ($mega_menu != '' && $mega_menu_width != '') ? $mega_menu_width: '' ;
         $classes[]  =   ($args->walker->has_children) ? 'dropdown sub-menu submenu' : '';
         $classes[]  =   ($page->current || $page->current_item_ancestor) ? 'active current-menu-item current_item_ancestor' : '';
         $classes[]  =   'menu-item-'.$page->ID;
         if($depth && $args->walker->has_children) {
            $classes[] = 'dropdown dropdown-submenu';
         }
         $class_names = join(' ', apply_filters( 'nav_menu_css_class', array_filter($classes), $page, $args));
         $class_names = 'class="'.esc_attr($class_names).'"';

         $id = apply_filters( 'nav_menu_item_id', 'menu-item'.$page->ID, $page, $args );

         $id = strlen($id) ? ' id="'.esc_attr($id).'"' : '';

         $output .= $indent. '<li '.$class_names. $id . $value. $li_attributes.'>';

        $attributes = ! empty( $page->attr_title ) ? ' title="' . esc_attr($page->attr_title) . '"' : '';
		$attributes .= ! empty( $page->target ) ? ' target="' . esc_attr($page->target) . '"' : '';
		$attributes .= ! empty( $page->xfn ) ? ' rel="' . esc_attr($page->xfn) . '"' : '';
		$attributes .= ! empty( $page->url ) ? ' href="' . esc_attr($page->url) . '"' : '';
        $attributes .= ( $args->walker->has_children ) ? ' data-toggle="dropdown"' : '';
        $href_class[] = 'nav-link';
        $href_class[] = ( $args->walker->has_children ) ? 'dropdown-toggle' : '';
       
        $href_class_attr = join(' ', $href_class);
        $attributes .= ' class="'.esc_attr( $href_class_attr ).'"';
        $has_child_icon = '';

        $mega_menu_id = '';
        $mega_menu_html = '';
       
        if(class_exists('ACF')) {
            $menu = wp_get_nav_menu_object($args->menu);
            $mega_menu_id = get_field('mega_menu_select', $page->ID);
            $icon_display_type = get_post_meta( $page->ID, 'icon_type_', true);
            $show_icon_on_dropdown = get_field( 'show_dropdown_menu_icon',  $menu);
            $top_lable_menu_icon = get_field( 'icon_top_leable',  $menu);
            $child_lable_menu_icon = get_field( 'child_menu_item',  $menu);
            $general_icon = '';
            if($show_icon_on_dropdown) {
                $general_icon = '<i class="ti-'.$top_lable_menu_icon.'"></i>';
                if($depth > 0 ){
                    $general_icon = '<i class="ti-'.$child_lable_menu_icon.'"></i>';
                }
            }
         
            if($icon_display_type == 'icon'){
                $has_child_icon = get_field( 'menu_icon_picker', $page->ID, true);
                $has_child_icon = '<i class="ti-'.$has_child_icon.'"></i>';
            }   
            
            if($icon_display_type == 'image'){
                $image = get_field('icon_image', $page->ID, true);                
                $has_child_icon = wp_get_attachment_image($image['ID'], [30, 30]);
            }     

        }else{
            $has_child_icon = '';
            if($depth == 0 && $args->walker->has_children) {

                $general_icon = '<i class="fa-solid fa-angle-down mobile_dropdown_icon"></i>';
    
            }elseif ($depth > 0 && $args->walker->has_children) {
    
                $general_icon = '<i class="fa-solid fa-angle-down mobile_dropdown_icon"></i>';

            }
        }
       
        if($mega_menu_id != '' && class_exists('\Elementor\Plugin')) {
            $elementor = \Elementor\Plugin::instance();
            $mega_menu_html = $general_icon.'<div class="dl-megamenu-content dl-elementor sub-menu">'.$elementor->frontend->get_builder_content_for_display(  $mega_menu_id  ).'</div>';
        }
        
        $item_output = $args->before;
        if($depth > 0 && $has_child_icon != '') {
            $item_output .= $has_child_icon;
        }
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $page->title, $page->ID ) . $args->link_after;
		$item_output .='</a>';
        if($depth == 0) {
            $item_output .= $has_child_icon;
        }
        if($args->walker->has_children) {
            $item_output .= $general_icon;
        }
        if($mega_menu_html != '') {
            $item_output .= $mega_menu_html;
        }
		$item_output .= $args->after;

        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $page, $depth, $args );
    }

}

