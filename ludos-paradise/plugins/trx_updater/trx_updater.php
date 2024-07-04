<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ludos_paradise_trx_updater_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ludos_paradise_trx_updater_theme_setup9', 9 );
	function ludos_paradise_trx_updater_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins', 'ludos_paradise_trx_updater_tgmpa_required_plugins', 8 );
		}
	}
}

// Filter to add in the required plugins list
// Priority 8 is used to add this plugin before all other plugins
if ( ! function_exists( 'ludos_paradise_trx_updater_tgmpa_required_plugins' ) ) {
	function ludos_paradise_trx_updater_tgmpa_required_plugins( $list = array() ) {
		if (ludos_paradise_storage_isset('required_plugins', 'trx_updater')){
			$path = ludos_paradise_get_file_dir( 'plugins/trx_updater/trx_updater.zip' );
			if ( ! empty( $path ) || ludos_paradise_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => esc_html__('ThemeREX Updater', 'ludos-paradise'),
					'slug'     => 'trx_updater',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_updater.zip',
					'version'  => '2.1.4',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'ludos_paradise_exists_trx_updater' ) ) {
	function ludos_paradise_exists_trx_updater() {
		return defined( 'TRX_UPDATER_VERSION' );
	}
}
