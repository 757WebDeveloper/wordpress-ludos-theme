<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_cf7_theme_setup9', 9 );
	function ludos_paradise_cf7_theme_setup9() {
		
		add_filter( 'ludos_paradise_filter_merge_styles', 'ludos_paradise_cf7_merge_styles' );
		add_filter( 'ludos_paradise_filter_merge_scripts', 'ludos_paradise_cf7_merge_scripts' );
		add_action( 'wp_enqueue_scripts', 'ludos_paradise_cf7_frontend_scripts', 1100 );

		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins',			'ludos_paradise_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_cf7_tgmpa_required_plugins' ) ) {
	
	function ludos_paradise_cf7_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> ludos_paradise_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
			
		}
		return $list;
	}
}

// Enqueue custom styles and scripts
if ( !function_exists( 'ludos_paradise_cf7_frontend_scripts' ) ) {
	function ludos_paradise_cf7_frontend_scripts() {
		if (ludos_paradise_exists_cf7()) {
			if (ludos_paradise_is_on(ludos_paradise_get_theme_option('debug_mode')) && ludos_paradise_get_file_dir('plugins/contact-form-7/contact-form-7.js')!='') {
				wp_enqueue_script( 'ludos-paradise-cf7', ludos_paradise_get_file_url('plugins/contact-form-7/contact-form-7.js'), array('jquery'), null, true );
			}
		}
	}
}

// Check if cf7 installed and activated
if ( !function_exists( 'ludos_paradise_exists_cf7' ) ) {
	function ludos_paradise_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Merge custom styles
if ( !function_exists( 'ludos_paradise_cf7_merge_styles' ) ) {
	function ludos_paradise_cf7_merge_styles($list) {
		if (ludos_paradise_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}

// Merge custom styles
if ( !function_exists( 'ludos_paradise_cf7_merge_scripts' ) ) {
	function ludos_paradise_cf7_merge_scripts($list) {
		if (ludos_paradise_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}

?>