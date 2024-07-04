<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.06
 */

$ludos_paradise_header_css = '';
$ludos_paradise_header_image = get_header_image();
$ludos_paradise_header_video = ludos_paradise_get_header_video();
if (!empty($ludos_paradise_header_image) && ludos_paradise_trx_addons_featured_image_override(is_singular() || ludos_paradise_storage_isset('blog_archive') || is_category())) {
	$ludos_paradise_header_image = ludos_paradise_get_current_mode_image($ludos_paradise_header_image);
}

$ludos_paradise_header_id = str_replace('header-custom-', '', ludos_paradise_get_theme_option("header_style"));
if ((int) $ludos_paradise_header_id == 0) {
	$ludos_paradise_header_id = ludos_paradise_get_post_id(array(
												'name' => $ludos_paradise_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$ludos_paradise_header_id = apply_filters('ludos_paradise_filter_get_translated_layout', $ludos_paradise_header_id);
}
$ludos_paradise_header_meta = get_post_meta($ludos_paradise_header_id, 'trx_addons_options', true);
if (!empty($ludos_paradise_header_meta['margin']) != '') 
	ludos_paradise_add_inline_css(sprintf('.page_content_wrap{padding-top:%s}', esc_attr(ludos_paradise_prepare_css_value($ludos_paradise_header_meta['margin']))));

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($ludos_paradise_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($ludos_paradise_header_id)));
				echo !empty($ludos_paradise_header_image) || !empty($ludos_paradise_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($ludos_paradise_header_video!='') 
					echo ' with_bg_video';
				if ($ludos_paradise_header_image!='') 
					echo ' '.esc_attr(ludos_paradise_add_inline_css_class('background-image: url('.esc_url($ludos_paradise_header_image).');'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (ludos_paradise_is_on(ludos_paradise_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight ludos_paradise-full-height';
				if (!ludos_paradise_is_inherit(ludos_paradise_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(ludos_paradise_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($ludos_paradise_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('ludos_paradise_action_show_layout', $ludos_paradise_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>