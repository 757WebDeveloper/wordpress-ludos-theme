<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_header_css = '';
$ludos_paradise_header_image = get_header_image();
$ludos_paradise_header_video = ludos_paradise_get_header_video();
if (!empty($ludos_paradise_header_image) && ludos_paradise_trx_addons_featured_image_override(is_singular() || ludos_paradise_storage_isset('blog_archive') || is_category())) {
	$ludos_paradise_header_image = ludos_paradise_get_current_mode_image($ludos_paradise_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($ludos_paradise_header_image) || !empty($ludos_paradise_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($ludos_paradise_header_video!='') echo ' with_bg_video';
					if ($ludos_paradise_header_image!='') echo ' '.esc_attr(ludos_paradise_add_inline_css_class('background-image: url('.esc_url($ludos_paradise_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (ludos_paradise_is_on(ludos_paradise_get_theme_option('header_fullheight'))) echo ' header_fullheight ludos_paradise-full-height';
					if (!ludos_paradise_is_inherit(ludos_paradise_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(ludos_paradise_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($ludos_paradise_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (ludos_paradise_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (ludos_paradise_is_on(ludos_paradise_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Display featured image in the header on the single posts
	// Comment next line to prevent show featured image in the header area
	// and display it in the post's content
	get_template_part( 'templates/header-single' );

?></header>