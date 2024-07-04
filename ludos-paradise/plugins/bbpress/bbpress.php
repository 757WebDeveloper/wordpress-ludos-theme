<?php
/* BBPress and BuddyPress support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('ludos_paradise_bbpress_theme_setup1')) {
	add_action( 'after_setup_theme', 'ludos_paradise_bbpress_theme_setup1', 1 );
	function ludos_paradise_bbpress_theme_setup1() {
		add_filter( 'ludos_paradise_filter_list_sidebars', 'ludos_paradise_bbpress_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('ludos_paradise_bbpress_theme_setup3')) {
	add_action( 'after_setup_theme', 'ludos_paradise_bbpress_theme_setup3', 3 );
	function ludos_paradise_bbpress_theme_setup3() {
		if (ludos_paradise_exists_bbpress()) {

			// Section 'BBPress and BuddyPress'
			ludos_paradise_storage_merge_array('options', '', array_merge(
				array(
					'bbpress' => array(
						"title" => esc_html__('BB(Buddy) Press', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select parameters to display the community pages', 'ludos-paradise') ),
						"type" => "section"
						),
					'forum_style' => array(
						"title" => esc_html__('Forum style', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select style to display forums list on the community pages', 'ludos-paradise') ),
						"std" => 'default',
						"options" => array(
							'default' => esc_html__('Default', 'ludos-paradise'),
							'light' => esc_html__('Light', 'ludos-paradise'),
							'callouts' => esc_html__('Callouts', 'ludos-paradise')
						),
						"type" => "select"
						)
				),
				ludos_paradise_options_get_list_cpt_options('bbpress', esc_html__('community', 'ludos-paradise'))
			));
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_bbpress_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_bbpress_theme_setup9', 9 );
	function ludos_paradise_bbpress_theme_setup9() {
		
		add_filter( 'ludos_paradise_filter_merge_styles',					'ludos_paradise_bbpress_merge_styles' );
		add_filter( 'ludos_paradise_filter_merge_styles_responsive',		'ludos_paradise_bbpress_merge_styles_responsive' );

		if (ludos_paradise_exists_bbpress()) {
			add_filter( 'ludos_paradise_filter_sidebar_present',			'ludos_paradise_bbpress_sidebar_present' );
			if (!is_admin()) {
				add_filter( 'ludos_paradise_filter_detect_blog_mode',		'ludos_paradise_bbpress_detect_blog_mode' );
				add_filter( 'post_class',							'ludos_paradise_bbpress_add_post_classes' );
			}
		}
		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins',	'ludos_paradise_bbpress_tgmpa_required_plugins' );
		}

	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_bbpress_tgmpa_required_plugins' ) ) {
	
	function ludos_paradise_bbpress_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'bbpress')) {
			$list[] = array(
					'name' 		=> esc_html__('BBPress', 'ludos-paradise'),
					'slug' 		=> 'bbpress',
					'required' 	=> false
				);
			$list[] = array(
					'name' 		=> esc_html__('BuddyPress', 'ludos-paradise'),
					'slug' 		=> 'buddypress',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Check if BBPress and BuddyPress is installed and activated
if ( !function_exists( 'ludos_paradise_exists_bbpress' ) ) {
	function ludos_paradise_exists_bbpress() {
		return class_exists( 'BuddyPress' ) || class_exists( 'bbPress' );
	}
}

// Return true, if current page is any bbpress page
if ( !function_exists( 'ludos_paradise_is_bbpress_page' ) ) {
	function ludos_paradise_is_bbpress_page() {
		$rez = false;
		if (ludos_paradise_exists_bbpress()) {
			if (!is_search()) {
				$rez = (function_exists('is_buddypress') && is_buddypress()) 
					|| (function_exists('is_bbpress') && is_bbpress())
					|| (!is_user_logged_in() && in_array(get_query_var('post_type'), array('forum', 'topic', 'reply')));
			}
		}
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'ludos_paradise_bbpress_detect_blog_mode' ) ) {
	
	function ludos_paradise_bbpress_detect_blog_mode($mode='') {
		if (ludos_paradise_is_bbpress_page())
			$mode = 'bbpress';
		return $mode;
	}
}
	
// Merge custom styles
if ( !function_exists( 'ludos_paradise_bbpress_merge_styles' ) ) {
	
	function ludos_paradise_bbpress_merge_styles($list) {
		if (ludos_paradise_exists_bbpress()) {
			$list[] = 'plugins/bbpress/_bbpress.scss';
		}
		return $list;
	}
}


// Merge responsive styles
if ( !function_exists( 'ludos_paradise_bbpress_merge_styles_responsive' ) ) {
	
	function ludos_paradise_bbpress_merge_styles_responsive($list) {
		if (ludos_paradise_exists_bbpress()) {
			$list[] = 'plugins/bbpress/_bbpress-responsive.scss';
		}
		return $list;
	}
}


// Hide sidebar on the plugin's pages
if ( !function_exists( 'ludos_paradise_bbpress_sidebar_present' ) ) {
	
	function ludos_paradise_bbpress_sidebar_present($present) {
		return ludos_paradise_is_bbpress_page() && function_exists('bp_is_user') && bp_is_user() 
					? ludos_paradise_is_off(ludos_paradise_get_theme_option('hide_sidebar_on_single')) && $present
					: $present;
	}
}



// Add plugin specific classes to the posts
if ( !function_exists('ludos_paradise_bbpress_add_post_classes') ) {
	
	function ludos_paradise_bbpress_add_post_classes( $classes ) {
		if (ludos_paradise_is_bbpress_page())
			$classes[] = 'bbpress_style_' . esc_attr(ludos_paradise_get_theme_option('forum_style'));
		return $classes;
	}
}



// Add BBPress and BuddyPress specific items into list of sidebars
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'ludos_paradise_bbpress_list_sidebars' ) ) {
	
	function ludos_paradise_bbpress_list_sidebars($list=array()) {
		$list['bbpress_widgets'] = array(
										'name' => esc_html__('BBPress and BuddyPress Widgets', 'ludos-paradise'),
										'description' => esc_html__('Widgets to be shown on the BBPress and BuddyPress pages', 'ludos-paradise')
										);
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (ludos_paradise_exists_bbpress()) { require_once LUDOS_PARADISE_THEME_DIR . 'plugins/bbpress/bbpress-styles.php'; }?>