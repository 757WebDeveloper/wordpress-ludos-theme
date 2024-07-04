<?php
/* BP Classic support functions (addon for a compatibility with BuddyPress under 12.0.0)
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ludos_paradise_bp_classic_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ludos_paradise_bp_classic_theme_setup9', 9 );
	function ludos_paradise_bp_classic_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins', 'ludos_paradise_bp_classic_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ludos_paradise_bp_classic_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('ludos_paradise_filter_tgmpa_required_plugins',	'ludos_paradise_bp_classic_tgmpa_required_plugins');
	function ludos_paradise_bp_classic_tgmpa_required_plugins( $list = array() ) {
		if ( ludos_paradise_storage_isset( 'required_plugins', 'bp-classic' ) && ludos_paradise_storage_get_array( 'required_plugins', 'bp-classic', 'install' ) !== false ) {
			$list[] = array(
				'name'     => esc_html__( 'BP Classic', 'ludos-paradise' ),
				'slug'     => 'bp-classic',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if BP Classic is installed and activated
if ( ! function_exists( 'ludos_paradise_exists_bp_classic' ) ) {
	function ludos_paradise_exists_bp_classic() {
		return class_exists( 'BP_Classic' );
	}
}
