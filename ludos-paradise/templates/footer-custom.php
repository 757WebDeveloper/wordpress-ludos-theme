<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.10
 */

$ludos_paradise_footer_id = str_replace('footer-custom-', '', ludos_paradise_get_theme_option("footer_style"));
if ((int) $ludos_paradise_footer_id == 0) {
	$ludos_paradise_footer_id = ludos_paradise_get_post_id(array(
												'name' => $ludos_paradise_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$ludos_paradise_footer_id = apply_filters('ludos_paradise_filter_get_translated_layout', $ludos_paradise_footer_id);
}
$ludos_paradise_footer_meta = get_post_meta($ludos_paradise_footer_id, 'trx_addons_options', true);
if (!empty($ludos_paradise_footer_meta['margin']) != '') 
	ludos_paradise_add_inline_css(sprintf('.page_content_wrap{padding-bottom:%s}', esc_attr(ludos_paradise_prepare_css_value($ludos_paradise_footer_meta['margin']))));
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($ludos_paradise_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($ludos_paradise_footer_id))); 
						if (!ludos_paradise_is_inherit(ludos_paradise_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(ludos_paradise_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('ludos_paradise_action_show_layout', $ludos_paradise_footer_id);
	?>
</footer><!-- /.footer_wrap -->
