<?php
/* WPBakery Page Builder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_vc_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_vc_theme_setup9', 9 );
	function ludos_paradise_vc_theme_setup9() {
		
		add_filter( 'ludos_paradise_filter_merge_styles',		'ludos_paradise_vc_merge_styles' );

		if (ludos_paradise_exists_visual_composer()) {
	
			// Add/Remove params in the standard VC shortcodes
			//-----------------------------------------------------
			add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,	'ludos_paradise_vc_add_params_classes', 10, 3 );
			add_filter( 'vc_iconpicker-type-fontawesome',	'ludos_paradise_vc_iconpicker_type_fontawesome' );
			
			// Color scheme
			$scheme = array(
				"param_name" => "scheme",
				"heading" => esc_html__("Color scheme", 'ludos-paradise'),
				"description" => wp_kses_data( __("Select color scheme to decorate this block", 'ludos-paradise') ),
				"group" => esc_html__('Colors', 'ludos-paradise'),
				"admin_label" => true,
				"value" => array_flip(ludos_paradise_get_list_schemes(true)),
				"type" => "dropdown"
			);
			$sc_list = apply_filters('ludos_paradise_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text'));
			foreach ($sc_list as $sc)
				vc_add_param($sc, $scheme);
		}
		if (is_admin()) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins', 'ludos_paradise_vc_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'ludos_paradise_vc_tgmpa_required_plugins' ) ) {
	
	function ludos_paradise_vc_tgmpa_required_plugins($list=array()) {
		if (ludos_paradise_storage_isset('required_plugins', 'js_composer')) {
			$path = ludos_paradise_get_file_dir('plugins/js_composer/js_composer.zip');
			if (!empty($path) || ludos_paradise_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> ludos_paradise_storage_get_array('required_plugins', 'js_composer'),
					'slug' 		=> 'js_composer',
					'version'	=> '7.6',
					'source'	=> !empty($path) ? $path : 'upload://js_composer.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if WPBakery Page Builder installed and activated
if ( !function_exists( 'ludos_paradise_exists_visual_composer' ) ) {
	function ludos_paradise_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery Page Builder in frontend editor mode
if ( !function_exists( 'ludos_paradise_vc_is_frontend' ) ) {
	function ludos_paradise_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}
	
// Merge custom styles
if ( !function_exists( 'ludos_paradise_vc_merge_styles' ) ) {
	
	function ludos_paradise_vc_merge_styles($list) {
		if (ludos_paradise_exists_visual_composer()) {
			$list[] = 'plugins/js_composer/_js_composer.scss';
		}
		return $list;
	}
}

// Merge responsive styles
if ( !function_exists( 'ludos_paradise_vc_merge_styles_responsive' ) ) {
	
	function ludos_paradise_vc_merge_styles_responsive($list) {
		if (ludos_paradise_exists_visual_composer()) {
			$list[] = 'plugins/js_composer/_js_composer-responsive.scss';
		}
		return $list;
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Add params to the standard VC shortcodes
if ( !function_exists( 'ludos_paradise_vc_add_params_classes' ) ) {
	
	function ludos_paradise_vc_add_params_classes($classes, $sc, $atts) {
		// Add color scheme
		if (in_array($sc, apply_filters('ludos_paradise_filter_add_scheme_in_vc', array('vc_section', 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text')))) {
			if (!empty($atts['scheme']) && !ludos_paradise_is_inherit($atts['scheme']))
				$classes .= ($classes ? ' ' : '') . 'scheme_' . $atts['scheme'];
		}
		return $classes;
	}
}
	
// Add theme icons to the VC iconpicker list
if ( !function_exists( 'ludos_paradise_vc_iconpicker_type_fontawesome' ) ) {
	
	function ludos_paradise_vc_iconpicker_type_fontawesome($icons) {
		$list = ludos_paradise_get_list_icons();
		if (!is_array($list) || count($list) == 0) return $icons;
		$rez = array();
		foreach ($list as $icon)
			$rez[] = array($icon => str_replace('icon-', '', $icon));
		return array_merge( $icons, array(esc_html__('Theme Icons', 'ludos-paradise') => $rez) );
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (ludos_paradise_exists_visual_composer()) { require_once LUDOS_PARADISE_THEME_DIR . 'plugins/js_composer/js_composer-styles.php'; }
?>