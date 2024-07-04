<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ludos_paradise_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'ludos_paradise_elegro_payment_theme_setup9', 9 );
	function ludos_paradise_elegro_payment_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'ludos_paradise_filter_tgmpa_required_plugins', 'ludos_paradise_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ludos_paradise_elegro_payment_tgmpa_required_plugins' ) ) {
	function ludos_paradise_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( ludos_paradise_storage_isset('required_plugins', 'woocommerce') && ludos_paradise_storage_isset('required_plugins', 'elegro-payment') ) {
			$list[] = array(
				'name'     => esc_html__('Elegro Crypto Payment', 'ludos-paradise'),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'ludos_paradise_exists_elegro_payment' ) ) {
	function ludos_paradise_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}