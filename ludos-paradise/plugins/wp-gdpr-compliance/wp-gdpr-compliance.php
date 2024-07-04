<?php
/* Cookie Information support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'ludos_paradise_wp_gdpr_compliance_feed_theme_setup9' ) ) {
    add_action( 'after_setup_theme', 'ludos_paradise_wp_gdpr_compliance_theme_setup9', 9 );
    function ludos_paradise_wp_gdpr_compliance_theme_setup9() {
        if ( is_admin() ) {
            add_filter( 'ludos_paradise_filter_tgmpa_required_plugins', 'ludos_paradise_wp_gdpr_compliance_tgmpa_required_plugins' );
        }
    }
}

// Filter to add in the required plugins list
if ( ! function_exists( 'ludos_paradise_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
    function ludos_paradise_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
        if ( false && ludos_paradise_storage_isset('required_plugins', 'wp-gdpr-compliance') ) {
            $list[] = array(
                'name' 		=> esc_html__('Cookie Information', 'ludos-paradise'),
                'slug' 		=> 'wp-gdpr-compliance',
                'required' 	=> false
            );
        }
        return $list;
    }
}

// Check if this plugin installed and activated
if ( ! function_exists( 'ludos_paradise_exists_wp_gdpr_compliance' ) ) {
    function ludos_paradise_exists_wp_gdpr_compliance() {
        return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
    }
}
