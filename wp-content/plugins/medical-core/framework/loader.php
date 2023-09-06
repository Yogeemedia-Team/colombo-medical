<?php
namespace TH_ESSENTIAL\Framework;
defined( 'ABSPATH' ) || exit;


use \TH_ESSENTIAL\DRTH_Plugin as DR_Plugin;

class Loader{

	private static $instance;

	public static function elementor_url(){
		return DR_Plugin::dtdr_th_url().'framework/';
	}

	public static function elementor_dir(){
		return DR_Plugin::dtdr_th_dir().'framework/';
	}

	public function _init(){
	   // load header footer builder
	  // require_once self::elementor_dir().'header-footer-builder/droit-header-footer.php';
	}


	public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}