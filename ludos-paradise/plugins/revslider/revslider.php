<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_revslider_theme_setup9', 9 );
	function ludos_paradise_revslider_theme_setup9() {

		add_filter( 'ludos_paradise_filter_merge_styles',				'ludos_paradise_revslider_merge_styles' );
		
		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins','ludos_paradise_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_revslider_tgmpa_required_plugins' ) ) {
	
	function ludos_paradise_revslider_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'revslider')) {
			$path = ludos_paradise_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || ludos_paradise_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> ludos_paradise_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'version'	=> '6.7.12',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'ludos_paradise_exists_revslider' ) ) {
	function ludos_paradise_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Merge custom styles
if ( !function_exists( 'ludos_paradise_revslider_merge_styles' ) ) {
	
	function ludos_paradise_revslider_merge_styles($list) {
		if (ludos_paradise_exists_revslider()) {
			$list[] = 'plugins/revslider/_revslider.scss';
		}
		return $list;
	}
}
?>