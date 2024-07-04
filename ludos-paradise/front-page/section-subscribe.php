<div class="front_page_section front_page_section_subscribe<?php
			$ludos_paradise_scheme = ludos_paradise_get_theme_option('front_page_subscribe_scheme');
			if (!ludos_paradise_is_inherit($ludos_paradise_scheme)) echo ' scheme_'.esc_attr($ludos_paradise_scheme);
			echo ' front_page_section_paddings_'.esc_attr(ludos_paradise_get_theme_option('front_page_subscribe_paddings'));
		?>"<?php
		$ludos_paradise_css = '';
		$ludos_paradise_bg_image = ludos_paradise_get_theme_option('front_page_subscribe_bg_image');
		if (!empty($ludos_paradise_bg_image)) 
			$ludos_paradise_css .= 'background-image: url('.esc_url(ludos_paradise_get_attachment_url($ludos_paradise_bg_image)).');';
		if (!empty($ludos_paradise_css))
			echo ' style="' . esc_attr($ludos_paradise_css) . '"';
?>><?php
	// Add anchor
	$ludos_paradise_anchor_icon = ludos_paradise_get_theme_option('front_page_subscribe_anchor_icon');	
	$ludos_paradise_anchor_text = ludos_paradise_get_theme_option('front_page_subscribe_anchor_text');	
	if ((!empty($ludos_paradise_anchor_icon) || !empty($ludos_paradise_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_subscribe"'
										. (!empty($ludos_paradise_anchor_icon) ? ' icon="'.esc_attr($ludos_paradise_anchor_icon).'"' : '')
										. (!empty($ludos_paradise_anchor_text) ? ' title="'.esc_attr($ludos_paradise_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_subscribe_inner<?php
			if (ludos_paradise_get_theme_option('front_page_subscribe_fullheight'))
				echo ' ludos_paradise-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$ludos_paradise_css = '';
			$ludos_paradise_bg_mask = ludos_paradise_get_theme_option('front_page_subscribe_bg_mask');
			$ludos_paradise_bg_color = ludos_paradise_get_theme_option('front_page_subscribe_bg_color');
			if (!empty($ludos_paradise_bg_color) && $ludos_paradise_bg_mask > 0)
				$ludos_paradise_css .= 'background-color: '.esc_attr($ludos_paradise_bg_mask==1
																	? $ludos_paradise_bg_color
																	: ludos_paradise_hex2rgba($ludos_paradise_bg_color, $ludos_paradise_bg_mask)
																).';';
			if (!empty($ludos_paradise_css))
				echo ' style="' . esc_attr($ludos_paradise_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$ludos_paradise_caption = ludos_paradise_get_theme_option('front_page_subscribe_caption');
			if (!empty($ludos_paradise_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo !empty($ludos_paradise_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($ludos_paradise_caption, 'ludos_paradise_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$ludos_paradise_description = ludos_paradise_get_theme_option('front_page_subscribe_description');
			if (!empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo !empty($ludos_paradise_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($ludos_paradise_description), 'ludos_paradise_kses_content'); ?></div><?php
			}
			
			// Content
			$ludos_paradise_sc = ludos_paradise_get_theme_option('front_page_subscribe_shortcode');
			if (!empty($ludos_paradise_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo !empty($ludos_paradise_sc) ? 'filled' : 'empty'; ?>"><?php
					ludos_paradise_show_layout(do_shortcode($ludos_paradise_sc));
				?></div><?php
			}
			?>
		</div>
	</div>
</div>