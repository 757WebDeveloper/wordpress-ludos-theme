<div class="front_page_section front_page_section_team<?php
			$ludos_paradise_scheme = ludos_paradise_get_theme_option('front_page_team_scheme');
			if (!ludos_paradise_is_inherit($ludos_paradise_scheme)) echo ' scheme_'.esc_attr($ludos_paradise_scheme);
			echo ' front_page_section_paddings_'.esc_attr(ludos_paradise_get_theme_option('front_page_team_paddings'));
		?>"<?php
		$ludos_paradise_css = '';
		$ludos_paradise_bg_image = ludos_paradise_get_theme_option('front_page_team_bg_image');
		if (!empty($ludos_paradise_bg_image)) 
			$ludos_paradise_css .= 'background-image: url('.esc_url(ludos_paradise_get_attachment_url($ludos_paradise_bg_image)).');';
		if (!empty($ludos_paradise_css))
			echo ' style="' . esc_attr($ludos_paradise_css) . '"';
?>><?php
	// Add anchor
	$ludos_paradise_anchor_icon = ludos_paradise_get_theme_option('front_page_team_anchor_icon');	
	$ludos_paradise_anchor_text = ludos_paradise_get_theme_option('front_page_team_anchor_text');	
	if ((!empty($ludos_paradise_anchor_icon) || !empty($ludos_paradise_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_team"'
										. (!empty($ludos_paradise_anchor_icon) ? ' icon="'.esc_attr($ludos_paradise_anchor_icon).'"' : '')
										. (!empty($ludos_paradise_anchor_text) ? ' title="'.esc_attr($ludos_paradise_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_team_inner<?php
			if (ludos_paradise_get_theme_option('front_page_team_fullheight'))
				echo ' ludos_paradise-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$ludos_paradise_css = '';
			$ludos_paradise_bg_mask = ludos_paradise_get_theme_option('front_page_team_bg_mask');
			$ludos_paradise_bg_color = ludos_paradise_get_theme_option('front_page_team_bg_color');
			if (!empty($ludos_paradise_bg_color) && $ludos_paradise_bg_mask > 0)
				$ludos_paradise_css .= 'background-color: '.esc_attr($ludos_paradise_bg_mask==1
																	? $ludos_paradise_bg_color
																	: ludos_paradise_hex2rgba($ludos_paradise_bg_color, $ludos_paradise_bg_mask)
																).';';
			if (!empty($ludos_paradise_css))
				echo ' style="' . esc_attr($ludos_paradise_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_team_content_wrap content_wrap">
			<?php
			// Caption
			$ludos_paradise_caption = ludos_paradise_get_theme_option('front_page_team_caption');
			if (!empty($ludos_paradise_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_team_caption front_page_block_<?php echo !empty($ludos_paradise_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($ludos_paradise_caption, 'ludos_paradise_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$ludos_paradise_description = ludos_paradise_get_theme_option('front_page_team_description');
			if (!empty($ludos_paradise_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_team_description front_page_block_<?php echo !empty($ludos_paradise_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($ludos_paradise_description), 'ludos_paradise_kses_content'); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_team_output"><?php 
				if (is_active_sidebar('front_page_team_widgets')) {
					dynamic_sidebar( 'front_page_team_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!ludos_paradise_exists_trx_addons())
						ludos_paradise_customizer_need_trx_addons_message();
					else
						ludos_paradise_customizer_need_widgets_message('front_page_team_caption', 'ThemeREX Addons - Team');
				}
			?></div>
		</div>
	</div>
</div>