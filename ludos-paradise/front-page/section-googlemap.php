<div class="front_page_section front_page_section_googlemap<?php
			$ludos_paradise_scheme = ludos_paradise_get_theme_option('front_page_googlemap_scheme');
			if (!ludos_paradise_is_inherit($ludos_paradise_scheme)) echo ' scheme_'.esc_attr($ludos_paradise_scheme);
			echo ' front_page_section_paddings_'.esc_attr(ludos_paradise_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$ludos_paradise_css = '';
		$ludos_paradise_bg_image = ludos_paradise_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($ludos_paradise_bg_image)) 
			$ludos_paradise_css .= 'background-image: url('.esc_url(ludos_paradise_get_attachment_url($ludos_paradise_bg_image)).');';
		if (!empty($ludos_paradise_css))
			echo ' style="' . esc_attr($ludos_paradise_css) . '"';
?>><?php
	// Add anchor
	$ludos_paradise_anchor_icon = ludos_paradise_get_theme_option('front_page_googlemap_anchor_icon');	
	$ludos_paradise_anchor_text = ludos_paradise_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($ludos_paradise_anchor_icon) || !empty($ludos_paradise_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($ludos_paradise_anchor_icon) ? ' icon="'.esc_attr($ludos_paradise_anchor_icon).'"' : '')
										. (!empty($ludos_paradise_anchor_text) ? ' title="'.esc_attr($ludos_paradise_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (ludos_paradise_get_theme_option('front_page_googlemap_fullheight'))
				echo ' ludos_paradise-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$ludos_paradise_css = '';
			$ludos_paradise_bg_mask = ludos_paradise_get_theme_option('front_page_googlemap_bg_mask');
			$ludos_paradise_bg_color = ludos_paradise_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($ludos_paradise_bg_color) && $ludos_paradise_bg_mask > 0)
				$ludos_paradise_css .= 'background-color: '.esc_attr($ludos_paradise_bg_mask==1
																	? $ludos_paradise_bg_color
																	: ludos_paradise_hex2rgba($ludos_paradise_bg_color, $ludos_paradise_bg_mask)
																).';';
			if (!empty($ludos_paradise_css))
				echo ' style="' . esc_attr($ludos_paradise_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$ludos_paradise_layout = ludos_paradise_get_theme_option('front_page_googlemap_layout');
			if ($ludos_paradise_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$ludos_paradise_caption = ludos_paradise_get_theme_option('front_page_googlemap_caption');
			$ludos_paradise_description = ludos_paradise_get_theme_option('front_page_googlemap_description');
			if (!empty($ludos_paradise_caption) || !empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($ludos_paradise_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($ludos_paradise_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($ludos_paradise_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses($ludos_paradise_caption, 'ludos_paradise_kses_content');
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($ludos_paradise_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses(wpautop($ludos_paradise_description), 'ludos_paradise_kses_content');
						?></div><?php
					}
				if ($ludos_paradise_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$ludos_paradise_content = ludos_paradise_get_theme_option('front_page_googlemap_content');
			if (!empty($ludos_paradise_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($ludos_paradise_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($ludos_paradise_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($ludos_paradise_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($ludos_paradise_content, 'ludos_paradise_kses_content');
				?></div><?php
	
				if ($ludos_paradise_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($ludos_paradise_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!ludos_paradise_exists_trx_addons())
						ludos_paradise_customizer_need_trx_addons_message();
					else
						ludos_paradise_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($ludos_paradise_layout == 'columns' && (!empty($ludos_paradise_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>