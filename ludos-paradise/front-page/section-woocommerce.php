<div class="front_page_section front_page_section_woocommerce<?php
			$ludos_paradise_scheme = ludos_paradise_get_theme_option('front_page_woocommerce_scheme');
			if (!ludos_paradise_is_inherit($ludos_paradise_scheme)) echo ' scheme_'.esc_attr($ludos_paradise_scheme);
			echo ' front_page_section_paddings_'.esc_attr(ludos_paradise_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$ludos_paradise_css = '';
		$ludos_paradise_bg_image = ludos_paradise_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($ludos_paradise_bg_image)) 
			$ludos_paradise_css .= 'background-image: url('.esc_url(ludos_paradise_get_attachment_url($ludos_paradise_bg_image)).');';
		if (!empty($ludos_paradise_css))
			echo ' style="' . esc_attr($ludos_paradise_css) . '"';
?>><?php
	// Add anchor
	$ludos_paradise_anchor_icon = ludos_paradise_get_theme_option('front_page_woocommerce_anchor_icon');	
	$ludos_paradise_anchor_text = ludos_paradise_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($ludos_paradise_anchor_icon) || !empty($ludos_paradise_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($ludos_paradise_anchor_icon) ? ' icon="'.esc_attr($ludos_paradise_anchor_icon).'"' : '')
										. (!empty($ludos_paradise_anchor_text) ? ' title="'.esc_attr($ludos_paradise_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (ludos_paradise_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' ludos_paradise-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$ludos_paradise_css = '';
			$ludos_paradise_bg_mask = ludos_paradise_get_theme_option('front_page_woocommerce_bg_mask');
			$ludos_paradise_bg_color = ludos_paradise_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($ludos_paradise_bg_color) && $ludos_paradise_bg_mask > 0)
				$ludos_paradise_css .= 'background-color: '.esc_attr($ludos_paradise_bg_mask==1
																	? $ludos_paradise_bg_color
																	: ludos_paradise_hex2rgba($ludos_paradise_bg_color, $ludos_paradise_bg_mask)
																).';';
			if (!empty($ludos_paradise_css))
				echo ' style="' . esc_attr($ludos_paradise_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$ludos_paradise_caption = ludos_paradise_get_theme_option('front_page_woocommerce_caption');
			$ludos_paradise_description = ludos_paradise_get_theme_option('front_page_woocommerce_description');
			if (!empty($ludos_paradise_caption) || !empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($ludos_paradise_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($ludos_paradise_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($ludos_paradise_caption, 'ludos_paradise_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($ludos_paradise_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($ludos_paradise_description), 'ludos_paradise_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$ludos_paradise_woocommerce_sc = ludos_paradise_get_theme_option('front_page_woocommerce_products');
				if ($ludos_paradise_woocommerce_sc == 'products') {
					$ludos_paradise_woocommerce_sc_ids = ludos_paradise_get_theme_option('front_page_woocommerce_products_per_page');
					$ludos_paradise_woocommerce_sc_per_page = count(explode(',', $ludos_paradise_woocommerce_sc_ids));
				} else {
					$ludos_paradise_woocommerce_sc_per_page = max(1, (int) ludos_paradise_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$ludos_paradise_woocommerce_sc_columns = max(1, min($ludos_paradise_woocommerce_sc_per_page, (int) ludos_paradise_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$ludos_paradise_woocommerce_sc}"
									. ($ludos_paradise_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($ludos_paradise_woocommerce_sc_ids).'"' 
											: '')
									. ($ludos_paradise_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(ludos_paradise_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($ludos_paradise_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(ludos_paradise_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(ludos_paradise_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($ludos_paradise_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($ludos_paradise_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>