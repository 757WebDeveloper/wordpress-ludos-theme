<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_args = get_query_var('ludos_paradise_logo_args');

// Site logo
$ludos_paradise_logo_type   = isset($ludos_paradise_args['type']) ? $ludos_paradise_args['type'] : '';
$ludos_paradise_logo_image  = ludos_paradise_get_logo_image($ludos_paradise_logo_type);
$ludos_paradise_logo_text   = ludos_paradise_is_on(ludos_paradise_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$ludos_paradise_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($ludos_paradise_logo_image) || !empty($ludos_paradise_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php
		if (!empty($ludos_paradise_logo_image)) {
			if (empty($ludos_paradise_logo_type) && function_exists('the_custom_logo') && is_numeric( $ludos_paradise_logo_image['logo'] ) && (int)$ludos_paradise_logo_image['logo'] > 0) {
				the_custom_logo();
			} else {
				$ludos_paradise_attr = ludos_paradise_getimagesize($ludos_paradise_logo_image);
				echo '<img src="'.esc_url($ludos_paradise_logo_image).'" alt="'.esc_attr($ludos_paradise_logo_text).'"'.(!empty($ludos_paradise_attr[3]) ? ' '.wp_kses_data($ludos_paradise_attr[3]) : '').'>';
			}
		} else {
			ludos_paradise_show_layout(ludos_paradise_prepare_macros($ludos_paradise_logo_text), '<span class="logo_text">', '</span>');
			ludos_paradise_show_layout(ludos_paradise_prepare_macros($ludos_paradise_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>