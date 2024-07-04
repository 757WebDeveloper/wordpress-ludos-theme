<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_instagram_feed_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_instagram_feed_theme_setup9', 9 );
	function ludos_paradise_instagram_feed_theme_setup9() {

		add_filter('ludos_paradise_filter_merge_styles_responsive',		'ludos_paradise_instagram_merge_styles_responsive');
		
		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins',	'ludos_paradise_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_instagram_feed_tgmpa_required_plugins' ) ) {
	
	function ludos_paradise_instagram_feed_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'instagram-feed')) {
			$list[] = array(
					'name' 		=> ludos_paradise_storage_get_array('required_plugins', 'instagram-feed'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'ludos_paradise_exists_instagram_feed' ) ) {
	function ludos_paradise_exists_instagram_feed() {
		return defined('SBIVER');
	}
}


// Merge responsive styles
if ( !function_exists( 'ludos_paradise_instagram_merge_styles_responsive' ) ) {
	
	function ludos_paradise_instagram_merge_styles_responsive($list) {
		if (ludos_paradise_exists_instagram_feed()) {
			$list[] = 'plugins/instagram/_instagram-responsive.scss';
		}
		return $list;
	}
}?>