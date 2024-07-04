<?php
/**
 * Generate custom CSS for theme hovers
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('ludos_paradise_hovers_theme_setup3')) {
	add_action( 'after_setup_theme', 'ludos_paradise_hovers_theme_setup3', 3 );
	function ludos_paradise_hovers_theme_setup3() {

		// Add 'Buttons hover' option
		ludos_paradise_storage_set_array_after('options', 'border_radius', array(
			'button_hover' => array(
				"title" => esc_html__("Button's hover", 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select hover effect to decorate all theme buttons', 'ludos-paradise') ),
				"std" => 'slide_top',
				"options" => array(
					'slide_top'		=> esc_html__('Slide from Top',		'ludos-paradise'),
				),
				"type" => "select"
			),
			'image_hover' => array(
				"title" => esc_html__("Image's hover", 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select hover effect to decorate all theme images', 'ludos-paradise') ),
				"std" => 'dots',
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"options" => array(
					'dots'	=> esc_html__('Dots',	'ludos-paradise'),
					'icon'	=> esc_html__('Icon',	'ludos-paradise'),
					'icons'	=> esc_html__('Icons',	'ludos-paradise'),
					'zoom'	=> esc_html__('Zoom',	'ludos-paradise'),
					'fade'	=> esc_html__('Fade',	'ludos-paradise'),
					'slide'	=> esc_html__('Slide',	'ludos-paradise'),
					'pull'	=> esc_html__('Pull',	'ludos-paradise'),
					'border'=> esc_html__('Border',	'ludos-paradise')
				),
				"type" => "select"
			) )
		);
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('ludos_paradise_hovers_theme_setup9')) {
	add_action( 'after_setup_theme', 'ludos_paradise_hovers_theme_setup9', 9 );
	function ludos_paradise_hovers_theme_setup9() {
		add_action( 'wp_enqueue_scripts',			'ludos_paradise_hovers_frontend_scripts', 1010 );
		add_filter( 'ludos_paradise_filter_localize_script','ludos_paradise_hovers_localize_script' );
		add_filter( 'ludos_paradise_filter_merge_scripts',	'ludos_paradise_hovers_merge_scripts' );
		add_filter( 'ludos_paradise_filter_merge_styles',	'ludos_paradise_hovers_merge_styles' );
		add_filter( 'ludos_paradise_filter_merge_styles_responsive', 'ludos_paradise_hovers_merge_styles_responsive' );
		add_filter( 'ludos_paradise_filter_get_css', 		'ludos_paradise_hovers_get_css', 10, 4 );
	}
}
	
// Enqueue hover styles and scripts
if ( !function_exists( 'ludos_paradise_hovers_frontend_scripts' ) ) {
	
	function ludos_paradise_hovers_frontend_scripts() {
		if ( ludos_paradise_is_on(ludos_paradise_get_theme_option('debug_mode')) && ludos_paradise_get_file_dir('theme-specific/theme-hovers/theme-hovers.js')!='' )
			wp_enqueue_script( 'ludos-paradise-hovers', ludos_paradise_get_file_url('theme-specific/theme-hovers/theme-hovers.js'), array('jquery'), null, true );
	}
}

// Merge hover effects into single css
if (!function_exists('ludos_paradise_hovers_merge_styles')) {
	
	function ludos_paradise_hovers_merge_styles($list) {
		$list[] = 'theme-specific/theme-hovers/_theme-hovers.scss';
		return $list;
	}
}

// Merge hover effects into single css (responsive)
if (!function_exists('ludos_paradise_hovers_merge_styles_responsive')) {
	
	function ludos_paradise_hovers_merge_styles_responsive($list) {
		$list[] = 'theme-specific/theme-hovers/_theme-hovers-responsive.scss';
		return $list;
	}
}

// Add hover effect's vars into localize array
if (!function_exists('ludos_paradise_hovers_localize_script')) {
	
	function ludos_paradise_hovers_localize_script($arr) {
		$arr['button_hover'] = ludos_paradise_get_theme_option('button_hover');
		return $arr;
	}
}

// Merge hover effects into single js
if (!function_exists('ludos_paradise_hovers_merge_scripts')) {
	
	function ludos_paradise_hovers_merge_scripts($list) {
		$list[] = 'theme-specific/theme-hovers/theme-hovers.js';
		return $list;
	}
}

// Add hover icons on the featured image
if ( !function_exists('ludos_paradise_hovers_add_icons') ) {
	function ludos_paradise_hovers_add_icons($hover, $args=array()) {

		// Additional parameters
		$args = array_merge(array(
			'cat' => '',
			'image' => null,
			'no_links' => false
		), $args);
	
		$post_link = empty($args['no_links']) ? get_permalink() : '';
		$no_link = 'javascript:void(0)';

		// Hover style 'Icons and 'Zoom'
		if (in_array($hover, array('icons', 'zoom'))) {
			if ($args['image'])
				$large_image = $args['image'];
			else {
				$attachment = wp_get_attachment_image_src( get_post_thumbnail_id(), 'masonry-big' );
				if (!empty($attachment[0]))
					$large_image = $attachment[0];
			}
			?>
			<div class="icons">
				<a href="<?php echo !empty($post_link) ? esc_url($post_link) : esc_attr( $no_link ); ?>" aria-hidden="true" class="icon-link<?php if (empty($large_image)) echo ' single_icon'; ?>"></a>
				<?php if (!empty($large_image)) { ?>
				<a href="<?php echo esc_url($large_image); ?>" aria-hidden="true" class="icon-search" title="<?php the_title_attribute(); ?>"></a>
				<?php } ?>
			</div>
			<?php
	
		// Hover style 'Shop'
		} else if ($hover == 'shop' || $hover == 'shop_buttons') {
			global $product;
			?>
			<div class="icons">
				<?php
				if (!is_object($args['cat'])) {
					ludos_paradise_show_layout(apply_filters( 'woocommerce_loop_add_to_cart_link',
										'<a rel="nofollow" href="' . esc_url($product->add_to_cart_url()) . '" 
														aria-hidden="true" 
														data-quantity="1" 
														data-product_id="' . esc_attr( $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() ) . '"
														data-product_sku="' . esc_attr( $product->get_sku() ) . '"
														class="shop_cart icon-cart-2 button add_to_cart_button'
																. ' product_type_' . $product->get_type()
																. ' product_' . ($product->is_purchasable() && $product->is_in_stock() ? 'in' : 'out') . '_stock'
																. ($product->supports( 'ajax_add_to_cart' ) ? ' ajax_add_to_cart' : '')
																. '">'
											. ($hover == 'shop_buttons' ? ($product->is_type( 'variable' ) ? esc_html__('Select options', 'ludos-paradise') : esc_html__('Buy now', 'ludos-paradise')) : '')
										. '</a>',
										$product));
				}
				?><a href="<?php echo esc_url(is_object($args['cat']) ? get_term_link($args['cat']->slug, 'product_cat') : get_permalink()); ?>" aria-hidden="true" class="shop_link button icon-link"><?php
					if ($hover == 'shop_buttons') {
						if (is_object($args['cat']))
							esc_html_e('View products', 'ludos-paradise');
						else
							esc_html_e('Details', 'ludos-paradise');
					}
				?></a>
			</div>
			<?php

		// Hover style 'Icon'
		} else if ($hover == 'icon') {
			?><div class="icons"><a href="<?php echo !empty($post_link) ? esc_url($post_link) : esc_attr( $no_link );  ?>" aria-hidden="true" class="icon-01-shield"></a></div><?php

		// Hover style 'Dots'
		} else if ($hover == 'dots') {
			?><a href="<?php echo !empty($post_link) ? esc_url($post_link) : esc_attr( $no_link ); ?>" aria-hidden="true" class="icons"><span></span><span></span><span></span></a><?php

		// Hover style 'Fade', 'Slide', 'Pull', 'Border'
		} else if (in_array($hover, array('fade', 'pull', 'slide', 'border'))) {
			?>
			<div class="post_info">
				<div class="post_info_back">
					<h4 class="post_title"><?php
						if (!empty($post_link)) {
							?><a href="<?php echo esc_url($post_link); ?>"><?php
						}
						the_title();
						if (!empty($post_link)) {
							?></a><?php
						}
					?></h4>
					<div class="post_descr">
						<?php
						$ludos_paradise_components = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('meta_parts'));
						$ludos_paradise_counters = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('counters'));
						if (!empty($ludos_paradise_components))
							ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
										'components' => $ludos_paradise_components,
										'counters' => $ludos_paradise_counters,
										'seo' => false,
										'echo' => true
										), 'hover_'.$hover, 1));
						// Remove the condition below if you want display excerpt
						if (false) {
							?><div class="post_excerpt"><?php the_excerpt(); ?></div><?php
						}
						?>
					</div>
				</div>
			</div>
			<?php

		// Hover style empty
		} else if (!empty($post_link)) {
			?><a href="<?php echo esc_url($post_link); ?>" aria-hidden="true" class="icons"></a><?php
		}
	}
}

// Add styles into CSS
if ( !function_exists( 'ludos_paradise_hovers_get_css' ) ) {
	
	function ludos_paradise_hovers_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* ================= BUTTON'S HOVERS ==================== */

/* Slide */
.sc_button_hover_slide_top {	background: linear-gradient(to bottom,	{$colors['alter_hover2']} 0%, {$colors['alter_link2']} 50%, {$colors['inverse_link']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['text_link']} !important; }

.sc_button_hover_style_link2.sc_button_hover_slide_top {	background: linear-gradient(to bottom,	{$colors['text_hover2']} 50%, {$colors['text_link2']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['text_link2']} !important; }

.sc_button_hover_style_link3.sc_button_hover_slide_top {	background: linear-gradient(to bottom,	{$colors['text_hover3']} 50%, {$colors['text_link3']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['text_link3']} !important; }

.sc_button_hover_style_dark.sc_button_hover_slide_top {			background: linear-gradient(to bottom,	{$colors['text_link']} 50%, {$colors['text_dark']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['text_dark']} !important; }

.woocommerce-notices-wrapper .wc-block-components-notice-banner>.wc-block-components-notice-banner__content .wc-forward,
.sc_button_hover_style_inverse.sc_button_hover_slide_top,
.wp-block-tag-cloud a,
.woocommerce-cart .button {		background: linear-gradient(to bottom,	{$colors['inverse_link']} 50%, {$colors['alter_hover2']} 50%, {$colors['alter_link2']} 100%) no-repeat scroll right bottom / 100% 210% {$colors['text_link']} !important; }

.sc_button_hover_style_hover.sc_button_hover_slide_top {		background: linear-gradient(to bottom,	{$colors['text_hover']} 50%, {$colors['text_link']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['text_link']} !important; }

.sc_button_hover_style_alter.sc_button_hover_slide_top {		background: linear-gradient(to bottom,	{$colors['alter_dark']} 50%, {$colors['alter_link']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['alter_link']} !important; }

.sc_button_hover_style_alterbd.sc_button_hover_slide_top {		background: linear-gradient(to bottom,	{$colors['alter_link']} 50%, {$colors['alter_bd_color']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['alter_bd_color']} !important; }

.sc_button_hover_style_extra.sc_button_hover_slide_top {		background: linear-gradient(to bottom,	{$colors['extra_link']} 50%, {$colors['extra_bg_color']} 50%) no-repeat scroll right bottom / 100% 210% {$colors['extra_bg_color']} !important; }

.sc_button_hover_style_alter.sc_button_hover_slide_top:hover{	color: {$colors['bg_color']} !important; }

.sc_button_hover_style_extra.sc_button_hover_slide_top:hover  {	color: {$colors['inverse_link']} !important; }

.sc_button_hover_slide_top {
    color: {$colors['text_link2']} !important;
    border-color: {$colors['text_hover2']} !important;
}
.woocommerce-notices-wrapper .wc-block-components-notice-banner>.wc-block-components-notice-banner__content .wc-forward,
.sc_button_hover_style_inverse.sc_button_hover_slide_top,
.wp-block-tag-cloud a,
.woocommerce-cart .button {
    color: {$colors['inverse_link']} !important;
    border-color: {$colors['text_hover2']} !important;
}

.woocommerce-notices-wrapper .wc-block-components-notice-banner>.wc-block-components-notice-banner__content .wc-forward:hover,
.sc_button_hover_style_inverse.sc_button_hover_slide_top:hover,
.wp-block-tag-cloud a:hover,
.woocommerce-cart .button:hover {
    color: {$colors['text_link2']} !important;
    background-position: right top !important; 
}
.sc_button_hover_slide_top:hover,
.sc_button_hover_slide_top.active,
.ui-state-active .sc_button_hover_slide_top,
.vc_active .sc_button_hover_slide_top,
.vc_tta-accordion .vc_tta-panel-title:hover .sc_button_hover_slide_top,
li.active .sc_button_hover_slide_top {
		background-position: right top !important; 
		color: {$colors['inverse_link']} !important;
		border-color: {$colors['text_hover2']} !important; 
}
#bbpress-forums #bbp-search-form:hover  input[type="submit"],
.sidebar form:hover input[type="submit"] {
    background-position: right top !important; 
}

/* ================= IMAGE'S HOVERS ==================== */

/* Dots */
.post_featured.hover_dots .icons span {
	background-color: {$colors['text_link']};
}
.post_featured.hover_dots .post_info {
	color: {$colors['inverse_link']};
}

/* Icon */
.post_featured.hover_icon .icons a {
	color: {$colors['inverse_link']};
}
.post_featured.hover_icon a:hover {
	color: {$colors['text_hover3']};
}

/* Icon and Icons */
.post_featured.hover_icons .icons a {
	color: {$colors['text_dark']};
	background-color: {$colors['bg_color_07']};
}
.post_featured.hover_icons a:hover {
	color: {$colors['text_link']};
	background-color: {$colors['bg_color']};
}

/* Fade */
.post_featured.hover_fade .post_info,
.post_featured.hover_fade .post_info a,
.post_featured.hover_fade .post_info .post_meta_item {
	color: {$colors['inverse_link']};
}
.post_featured.hover_fade .post_info a:hover {
	color: {$colors['text_link']};
}

/* Slide */
.post_featured.hover_slide .post_info,
.post_featured.hover_slide .post_info a,
.post_featured.hover_slide .post_info .post_meta_item {
	color: {$colors['inverse_link']};
}
.post_featured.hover_slide .post_info a:hover {
	color: {$colors['text_link']};
}
.post_featured.hover_slide .post_info .post_title:after {
	background-color: {$colors['inverse_link']};
}

/* Pull */
.post_featured.hover_pull {
	background-color: {$colors['extra_bg_color']};
}
.post_featured.hover_pull .post_info,
.post_featured.hover_pull .post_info a,
.post_featured.hover_pull .post_info a:before {
	color: {$colors['extra_dark']};
}
.post_featured.hover_pull .post_info a:hover,
.post_featured.hover_pull .post_info a:hover:before {
	color: {$colors['extra_link']};
}

/* Border */
.post_featured.hover_border .post_info,
.post_featured.hover_border .post_info a,
.post_featured.hover_border .post_info .post_meta_item {
	color: {$colors['inverse_link']};
}
.post_featured.hover_border .post_info a:hover {
	color: {$colors['text_link']};
}
.post_featured.hover_border .post_info:before,
.post_featured.hover_border .post_info:after {
	border-color: {$colors['inverse_link']};
}

/* Shop */
.post_featured.hover_shop .icons a {
	color: {$colors['inverse_link']};
	border-color: {$colors['text_link']} !important;
	background-color: transparent;
}
.post_featured.hover_shop .icons a:hover {
	color: {$colors['inverse_hover']};
	border-color: {$colors['text_link']} !important;
	background-color: {$colors['text_link']};
}
.products.related .post_featured.hover_shop .icons a {
	color: {$colors['inverse_link']};
	border-color: {$colors['text_link']} !important;
	background-color: {$colors['text_link']};
}
.products.related .post_featured.hover_shop .icons a:hover {
	color: {$colors['inverse_hover']};
	border-color: {$colors['text_hover']} !important;
	background-color: {$colors['text_hover']};
}

/* Shop Buttons */
.post_featured.hover_shop_buttons .icons .shop_link {
	color: {$colors['bg_color']};
	background-color: {$colors['text_dark']};
}
.post_featured.hover_shop_buttons .icons a:hover {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_hover']};
}
CSS;
		}
		
		return $css;
	}
}
?>