<?php
/**
 * Theme customizer
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */


//--------------------------------------------------------------
//-- First run actions after switch theme
//--------------------------------------------------------------
if (!function_exists('ludos_paradise_customizer_action_switch_theme')) {
	add_action('after_switch_theme', 'ludos_paradise_customizer_action_switch_theme');
	function ludos_paradise_customizer_action_switch_theme() {
		// Duplicate theme options between parent and child themes
		$duplicate = ludos_paradise_get_theme_setting('duplicate_options');
		if (in_array($duplicate, array('child', 'both'))) {
			$theme_slug = get_option( 'template' );
			$theme_time = (int) get_option( "ludos_paradise_options_timestamp_{$theme_slug}" );
			$stylesheet_slug = get_option( 'stylesheet' );

			// If child-theme is activated - duplicate options from template to the child-theme
			if ($theme_slug != $stylesheet_slug) {
				$stylesheet_time = (int) get_option( "ludos_paradise_options_timestamp_{$stylesheet_slug}" );
				if ($theme_time > $stylesheet_time) ludos_paradise_customizer_duplicate_theme_options($theme_slug, $stylesheet_slug, $theme_time);
			
			// If main theme (template) is activated and 'duplicate_options' == 'child'
			// (duplicate options only from template to the child-theme) - regenerate CSS  with custom colors and fonts
			} else if ($duplicate == 'child' && $theme_time > 0) {
				ludos_paradise_customizer_save_css();
			}
		}
	}
}


// Duplicate theme options between template and child-theme
if (!function_exists('ludos_paradise_customizer_duplicate_theme_options')) {
	function ludos_paradise_customizer_duplicate_theme_options($from, $to, $timestamp = 0) {
		if ($timestamp == 0) $timestamp = get_option("ludos_paradise_options_timestamp_{$from}");
		$from = "theme_mods_{$from}";
		$from_options = get_option($from);
		$to = "theme_mods_{$to}";
		$to_options = get_option($to);
		if (is_array($from_options)) {
			if (!is_array($to_options)) $to_options = array();
			$theme_options = ludos_paradise_storage_get('options');
			foreach ($from_options as $k => $v) {
				if (isset($theme_options[$k])) $to_options[$k] = $v;
			}
			update_option($to, $to_options);
			update_option("ludos_paradise_options_timestamp_{$to}", $timestamp);
		}
	}
}


//--------------------------------------------------------------
//-- New panel in the Customizer Controls
//--------------------------------------------------------------

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('ludos_paradise_customizer_setup3')) {
	add_action( 'after_setup_theme', 'ludos_paradise_customizer_setup3', 3 );
	function ludos_paradise_customizer_setup3() {
		ludos_paradise_storage_merge_array('options', '', array(
			'cpt' => array(
				"title" => esc_html__('Plugins settings', 'ludos-paradise'),
				"desc" => '',
				"priority" => 400,
				"type" => "panel"
				)
			)
		);
	}
}
// 3 - add/remove Theme Options elements
if (!function_exists('ludos_paradise_customizer_setup4')) {
	add_action( 'after_setup_theme', 'ludos_paradise_customizer_setup4', 4 );
	function ludos_paradise_customizer_setup4() {
		ludos_paradise_storage_merge_array('options', '', array(
			'cpt_end' => array(
				"type" => "panel_end"
				)
			)
		);
	}
}


//--------------------------------------------------------------
//-- Register Customizer Controls
//--------------------------------------------------------------

define('LUDOS_PARADISE_CUSTOMIZE_PRIORITY', 200);		// Start priority for the new controls

// Register custom controls for the customizer
if (!function_exists('ludos_paradise_customizer_custom_controls')) {
	add_action( 'customize_register', 'ludos_paradise_customizer_custom_controls' );
	function ludos_paradise_customizer_custom_controls( $wp_customize ) {
		require_once LUDOS_PARADISE_THEME_DIR . 'theme-options/theme-customizer-controls.php';
	}
}

// Parse Theme Options and add controls to the customizer
if (!function_exists('ludos_paradise_customizer_register_controls')) {
	add_action( 'customize_register', 'ludos_paradise_customizer_register_controls', 20);
	function ludos_paradise_customizer_register_controls( $wp_customize ) {

		$refresh_auto = ludos_paradise_get_theme_setting('customize_refresh') != 'manual';
		
		$panels = array('');
		$p = 0;
		$sections = array('');
		$s = 0;
		
		$i = LUDOS_PARADISE_CUSTOMIZE_PRIORITY;

		// Reload Theme Options before create controls
		if (is_admin()) {
			ludos_paradise_storage_set('options_reloaded', true);
			ludos_paradise_load_theme_options();
		}
		$options = ludos_paradise_storage_get('options');

		foreach ($options as $id=>$opt) {
			$i = !empty($opt['priority']) 
					? $opt['priority'] 
					: (in_array($opt['type'], array('panel', 'section'))
							? LUDOS_PARADISE_CUSTOMIZE_PRIORITY
							: $i++
						);
			
			if (!empty($opt['hidden'])) continue;

			if (!isset($opt['title'])) $opt['title'] = '';
			if (!isset($opt['desc'])) $opt['desc'] = '';
			
			$transport = $refresh_auto && (!isset($opt['refresh']) || $opt['refresh']===true) ? 'refresh' : 'postMessage';

			if ($opt['type'] == 'panel') {

				if ($p > 0) {
					array_pop($panels);
					$p--;
				}
				if ($s > 0) {
					array_pop($sections);
					$s--;
				}

				$sec = $wp_customize->get_panel( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
					if ( !empty($opt['active_callback']) )	$sec->active_callback = $opt['active_callback'];
				} else {
					$wp_customize->add_panel( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'priority'	 => $i,
						'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : ''
					) );
				}
				array_push($panels, $id);
				$p++;

			} else if ($opt['type'] == 'panel_end') {

				array_pop($panels);
				$p--;

			} else if ($opt['type'] == 'section') {

				if ($s > 0) {
					array_pop($sections);
					$s--;
				}

				$sec = $wp_customize->get_section( $id );
				if ( is_object($sec) && !empty($sec->title) ) {
					$sec->title      = $opt['title'];
					$sec->description= $opt['desc'];
					$sec->panel      = esc_attr($panels[$p]);
					if ( !empty($opt['priority']) )	$sec->priority = $opt['priority'];
					if ( !empty($opt['active_callback']) )	$sec->active_callback = $opt['active_callback'];
				} else {
					$wp_customize->add_section( esc_attr($id) , array(
						'title'      => $opt['title'],
						'description'=> $opt['desc'],
						'panel'      => esc_attr($panels[$p]),
						'priority'	 => $i,
						'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : ''
					) );
				}
				array_push($sections, $id);
				$s++;

			} else if ($opt['type'] == 'section_end') {

				array_pop($sections);
				$s--;

			} else if ($opt['type'] == 'select') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'type'     => 'select',
					'choices'  => apply_filters('ludos_paradise_filter_options_get_list_choises', $opt['options'], $id)
				) );

			} else if ($opt['type'] == 'radio') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority'	 => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'type'     => 'radio',
					'choices'  => apply_filters('ludos_paradise_filter_options_get_list_choises', $opt['options'], $id)
				) );

			} else if ($opt['type'] == 'switch') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new Ludos_Paradise_Customize_Switch_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'choices'  => apply_filters('ludos_paradise_filter_options_get_list_choises', $opt['options'], $id),
					'input_attrs' => array(
						'value' => ludos_paradise_get_theme_option($id),
					)
				) ) );

			} else if ($opt['type'] == 'checkbox') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'priority'	 => $i,
					'type'     => 'checkbox'
				) );

			} else if ($opt['type'] == 'color') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'priority'	 => $i,
				) ) );

			} else if ($opt['type'] == 'image') {
				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_remove_protocol_from_url(ludos_paradise_get_theme_option($id), false),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'priority' => $i,
				) ) );

			} else if (in_array($opt['type'], array('media', 'audio', 'video'))) {
				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_remove_protocol_from_url(ludos_paradise_get_theme_option($id), false),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'priority' => $i,
				) ) );

			} else if ($opt['type'] == 'icon') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_remove_protocol_from_url(ludos_paradise_get_theme_option($id), false),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new Ludos_Paradise_Customize_Icon_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'input_attrs' => array(
						'value' => ludos_paradise_get_theme_option($id),
					)
				) ) );

			} else if ($opt['type'] == 'checklist') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new Ludos_Paradise_Customize_Checklist_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'choices' => apply_filters('ludos_paradise_filter_options_get_list_choises', $opt['options'], $id),
					'input_attrs' => array_merge($opt, array(
														'value' => ludos_paradise_get_theme_option($id),
														))
				) ) );

			} else if (in_array($opt['type'], array('slider', 'range'))) {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new Ludos_Paradise_Customize_Range_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'input_attrs' => array_merge($opt, array(
														'show_value' => !isset($opt['show_value']) || $opt['show_value'],
														'value' => ludos_paradise_get_theme_option($id)
														))
				) ) );

			} else if ($opt['type'] == 'scheme_editor') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );
			
				$wp_customize->add_control( new Ludos_Paradise_Customize_Scheme_Editor_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'input_attrs' => array_merge($opt, array(
														'value' => ludos_paradise_get_theme_option($id),
														))
				) ) );

			} else if ($opt['type'] == 'text_editor') {

				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => $transport
				) );

				$wp_customize->add_control( new Ludos_Paradise_Customize_Text_Editor_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'input_attrs' => array_merge($opt, array(
														'value' => ludos_paradise_get_theme_option($id),
														))
				) ) );

			} else if ($opt['type'] == 'button') {
			
				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $transport
				) );

				$wp_customize->add_control( new Ludos_Paradise_Customize_Button_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
					'input_attrs' => $opt,
				) ) );

			} else if ($opt['type'] == 'info') {
			
				$wp_customize->add_setting( $id, array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new Ludos_Paradise_Customize_Info_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
				) ) );

			} else if ($opt['type'] == 'hidden') {
			
				$wp_customize->add_setting( $id, array(
					'default'           => ludos_paradise_get_theme_option($id),
					'sanitize_callback' => 'ludos_paradise_sanitize_html',
					'transport'         => 'postMessage'
				) );

				$wp_customize->add_control( new Ludos_Paradise_Customize_Hidden_Control( $wp_customize, $id, array(
					'label'    => $opt['title'],
					'description' => $opt['desc'],
					'section'  => esc_attr($sections[$s]),
					'priority' => $i,
					'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
				) ) );

			} else {

				if (!apply_filters('ludos_paradise_filter_register_customizer_control', false, $wp_customize, $id, $sections[$s], $i, $transport, $opt )) {
					if ($opt['type'] == 'text_editor') $opt['type'] = 'textarea';
					
					$wp_customize->add_setting( $id, array(
						'default'           => ludos_paradise_get_theme_option($id),
						'sanitize_callback' => !empty($opt['sanitize']) 
													? $opt['sanitize'] 
													: ($opt['type'] == 'text' 
															? 'sanitize_text_field' 
															: 'wp_kses_post'
														),
						'transport'         => $transport
					) );
				
					$wp_customize->add_control( $id, array(
						'label'    => $opt['title'],
						'description' => $opt['desc'],
						'section'  => esc_attr($sections[$s]),
						'priority' => $i,
						'active_callback' => !empty($opt['active_callback']) ? $opt['active_callback'] : '',
						'type'     => $opt['type']	
					) );
				}
			}

			// Register Partial Refresh (if supported)
			if ($refresh_auto && isset($opt['refresh']) && is_string($opt['refresh']) 
				&& function_exists("ludos_paradise_customizer_partial_refresh_{$id}")
				&& isset($wp_customize->selective_refresh)) {
				$wp_customize->selective_refresh->add_partial($id, array(
					'selector'        => $opt['refresh'],
					'settings'        => $id,
					'render_callback' => "ludos_paradise_customizer_partial_refresh_{$id}",
					'container_inclusive' => !empty($opt['refresh_wrapper'])
				));
			}

		}


		// Setup standard WP Controls
		// ---------------------------------

		// Reorder standard WP sections
		$sec = $wp_customize->get_panel( 'nav_menus' );
		if (is_object($sec)) $sec->priority = 60;
		$sec = $wp_customize->get_panel( 'widgets' );
		if (is_object($sec)) $sec->priority = 61;
		$sec = $wp_customize->get_section( 'static_front_page' );
		if (is_object($sec)) $sec->priority = 62;
		$sec = $wp_customize->get_section( 'custom_css' );
		if (is_object($sec)) $sec->priority = 2000;
		
		// Modify standard WP controls
		$sec = $wp_customize->get_control( 'blogname' );
		if (is_object($sec))
			$sec->description = esc_html__('Use "((" and "))", "{{" and "}}" to modify style and color of parts of the text, "||" to break current line', 'ludos-paradise');
		$sec = $wp_customize->get_setting( 'blogname' );
		if (is_object($sec)) $sec->transport = 'postMessage';

		$sec = $wp_customize->get_setting( 'blogdescription' );
		if (is_object($sec)) $sec->transport = 'postMessage';

		$sec = $wp_customize->get_control( 'site_icon' );
		if (is_object($sec)) $sec->priority = 15;
		$sec = $wp_customize->get_control( 'custom_logo' );
		if (is_object($sec)) {
			$sec->priority = 50;
			$sec->description = wp_kses_data( __('Select or upload the site logo', 'ludos-paradise') );
		}

		$sec = $wp_customize->get_section( 'header_image' );
		$sec2 = $wp_customize->get_control( 'header_image_info' );
		if (is_object($sec2)) {
			$sec2->description = (!empty($sec2->description) ? $sec2->description . '<br>' : '') . $sec->description;
		}

		$sec = $wp_customize->get_control( 'header_image' );
		if (is_object($sec)) {
			$sec->priority = 300;
			$sec->section = 'header';
		}
		$sec = $wp_customize->get_control( 'header_video' );
		if (is_object($sec)) {
			$sec->priority = 310;
			$sec->section = 'header';
		}
		$sec = $wp_customize->get_control( 'external_header_video' );
		if (is_object($sec)) {
			$sec->priority = 320;
			$sec->section = 'header';
		}
		
		$sec = $wp_customize->get_section( 'background_image' );
		if (is_object($sec)) {
			$sec->title = esc_html__('Background', 'ludos-paradise');
			$sec->priority = 310;
		}

		$sec = $wp_customize->get_control( 'background_color' );
		if (is_object($sec)) {
			$sec->priority = 10;
			$sec->section = 'background_image';
		}

		// Remove unused sections
		$wp_customize->remove_section( 'colors');
		$wp_customize->remove_section( 'header_image');
	}
}


// Sanitize plain value - remove all tags and spaces
if (!function_exists('ludos_paradise_sanitize_value')) {
	function ludos_paradise_sanitize_value($value) {
		return empty($value) ? $value : trim(strip_tags($value));
	}
}


// Sanitize html value - keep only allowed tags
if (!function_exists('ludos_paradise_sanitize_html')) {
	function ludos_paradise_sanitize_html($value) {
		return empty($value) ? $value : wp_kses_post($value);
	}
}


// Return url to autofocus related field
if (!function_exists('ludos_paradise_customizer_get_focus_url')) {
	function ludos_paradise_customizer_get_focus_url($field) {
		return admin_url("customize.php?autofocus&#91;control&#93;={$field}");
	}
}

// Return link to autofocus related field
if (!function_exists('ludos_paradise_customizer_get_focus_link')) {
	function ludos_paradise_customizer_get_focus_link($field, $text) {
		return sprintf('<a href="%1$s" class="ludos_paradise_customizer_link">%2$s</a>',
						esc_url(ludos_paradise_customizer_get_focus_url($field)),
						$text
						);
	}
}

// Display message "Need to select widgets"
if (!function_exists('ludos_paradise_customizer_need_widgets_message')) {
	function ludos_paradise_customizer_need_widgets_message($field, $text) {
		?><div class="ludos_paradise_customizer_message"><?php
			// Translators: Add widget's name or link to focus specified section
			echo wp_kses_data(sprintf(__( 'You have to choose widget "<b>%s</b>" in this section. You can also select any other widget, and change the purpose of this section', 'ludos-paradise'),
										is_customize_preview()
											? $text
											: ludos_paradise_customizer_get_focus_link($field, $text)
							));
		?></div><?php
	}
}

// Display message "Need to install plugin ThemeREX Addons"
if (!function_exists('ludos_paradise_customizer_need_trx_addons_message')) {
	function ludos_paradise_customizer_need_trx_addons_message() {
		?><div class="ludos_paradise_customizer_message"><?php
			// Translators: Add the link to install plugin and its name
			echo wp_kses_data(sprintf(__( 'You need to install the <b>%s</b> plugin to be able to add Team members, Testimonials, Services and many other widgets', 'ludos-paradise'),
								is_customize_preview()
									? __('ThemeREX Addons', 'ludos-paradise')
									// Translators: Make the tag with link to install plugin
									: sprintf('<a href="%1$s" class="ludos_paradise_customizer_link">%2$s</a>',
									  			esc_url(wp_nonce_url(
															self_admin_url('update.php?action=install-plugin&plugin=trx_addons'),
															'install-plugin_trx_addons'
														)),
											  __('ThemeREX Addons', 'ludos-paradise')
											  )
						));
			echo '<br>' . wp_kses_data(__( 'Also you can insert in this section any other widgets and to modify its purpose', 'ludos-paradise'));
		?></div><?php
	}
}


//--------------------------------------------------------------
// Save custom settings in CSS file
//--------------------------------------------------------------

// Save CSS with custom colors and fonts after save custom options
if (!function_exists('ludos_paradise_customizer_action_save_after')) {
	add_action('customize_save_after', 'ludos_paradise_customizer_action_save_after');
	function ludos_paradise_customizer_action_save_after($api=false) {

		// Get saved settings
		$settings = $api->settings();

		// Store new schemes colors
		$schemes = ludos_paradise_unserialize($settings['scheme_storage']->value());
		if (is_array($schemes) && count($schemes) > 0) 
			ludos_paradise_storage_set('schemes', $schemes);

		// Store new fonts parameters
		$fonts = ludos_paradise_get_theme_fonts();
		foreach ($fonts as $tag=>$v) {
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$fonts[$tag][$css_prop] = $settings["{$tag}_{$css_prop}"]->value();
			}
		}
		ludos_paradise_storage_set('theme_fonts', $fonts);

		// Collect options from the external storages
		$options = ludos_paradise_storage_get('options');
		$external_storages = array();
		foreach ($options as $k=>$v) {
			// Skip non-data options - sections, info, etc.
			if (!isset($v['std']) || empty($v['options_storage'])) continue;
			// Get option value from Customizer
			$value = isset($settings[$k])
							? $settings[$k]->value()
							: ($v['type']=='checkbox' ? 0 : '');
			if (!isset($external_storages[$v['options_storage']])) {
				$external_storages[$v['options_storage']] = array();
			}
			$external_storages[$v['options_storage']][$k] = $value;
		}

		// Update options in the external storages
		foreach ($external_storages as $storage_name => $storage_values) {
			$storage = get_option($storage_name, false);
			if (is_array($storage)) {
				foreach ($storage_values as $k=>$v) {
					$storage[$k] = $v;
				}
				update_option($storage_name, apply_filters('ludos_paradise_filter_options_save', $storage, $storage_name));
			}
		}

		do_action('ludos_paradise_action_just_save_options');

		// Update ThemeOptions save timestamp
		$stylesheet_slug = get_option('stylesheet');
		$stylesheet_time = time();
		update_option("ludos_paradise_options_timestamp_{$stylesheet_slug}", $stylesheet_time);

		// Sinchronize theme options between child and parent themes
		if (ludos_paradise_get_theme_setting('duplicate_options') == 'both') {
			$theme_slug = get_option('template');
			if ($theme_slug != $stylesheet_slug) {
				ludos_paradise_customizer_duplicate_theme_options($stylesheet_slug, $theme_slug, $stylesheet_time);
			}
		}

		// Apply action - moved to the delayed state (see below) to load all enabled modules and apply changes after
		// Attention! Don't remove comment the line below!
		// Not need here: do_action('ludos_paradise_action_save_options');
		update_option( 'ludos_paradise_action', 'ludos_paradise_action_save_options' );
	}
}

// Save CSS with custom colors and fonts to the custom.css
if (!function_exists('ludos_paradise_customizer_save_css')) {

	add_action('ludos_paradise_action_save_options', 'ludos_paradise_customizer_save_css', 20);
	add_action('trx_addons_action_save_options', 'ludos_paradise_customizer_save_css', 20);
	function ludos_paradise_customizer_save_css() {
		$msg = 	'/* ' . esc_html__("ATTENTION! This file was generated automatically! Don't change it!!!", 'ludos-paradise') 
				. "\n----------------------------------------------------------------------- */\n";

		// Save CSS with custom colors and fonts into custom.css
		$css = ludos_paradise_customizer_get_css();
		ludos_paradise_fpc( ludos_paradise_get_file_dir('css/__colors.css'), $msg . $css );

		// Merge styles
		ludos_paradise_merge_sass( 'css/_theme-plugins.scss', apply_filters( 'ludos_paradise_filter_merge_styles', array(
																									'css/_mixins.scss',
																									'css/_theme-vars.scss'
																									) ) );

		// Merge responsive styles
		ludos_paradise_merge_sass( 'css/responsive.scss', apply_filters( 'ludos_paradise_filter_merge_styles_responsive', array(
																									'css/_mixins.scss',
																									'css/_theme-vars.scss',
																									'css/_theme-responsive.scss'
																									) ), true );

		// Merge scripts
		ludos_paradise_merge_files( 'js/__scripts.js', apply_filters( 'ludos_paradise_filter_merge_scripts', array(
																									'js/skip-link-focus.js',
																									'js/bideo.js',
																									'js/jquery.tubular.js',
																									'js/theme-utils.js',
																									'js/theme-init.js'
																									) ) );
	}
}


//--------------------------------------------------------------
// Customizer JS and CSS
//--------------------------------------------------------------

// Binds JS listener to Customizer controls.
if ( !function_exists( 'ludos_paradise_customizer_control_js' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'ludos_paradise_customizer_control_js' );
	function ludos_paradise_customizer_control_js() {
		wp_enqueue_style( 'ludos-paradise-customizer', ludos_paradise_get_file_url('theme-options/theme-customizer.css'), array(), null );
		wp_enqueue_script( 'ludos-paradise-customizer',
									ludos_paradise_get_file_url('theme-options/theme-customizer.js'),
									array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), null, true );
		wp_enqueue_script( 'ludos-paradise-colorpicker-colors', ludos_paradise_get_file_url('js/colorpicker/colors.js'), array('jquery'), null, true );
		wp_enqueue_script( 'ludos-paradise-colorpicker', ludos_paradise_get_file_url('js/colorpicker/jqcolorpicker.js'), array('jquery'), null, true );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_color_schemes', ludos_paradise_storage_get('schemes') );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_simple_schemes', ludos_paradise_storage_get('schemes_simple') );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_additional_colors', ludos_paradise_storage_get('scheme_colors_add') );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_theme_fonts', ludos_paradise_storage_get('theme_fonts') );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_customizer_vars', apply_filters('ludos_paradise_filter_customizer_vars', array(
			'max_load_fonts' => ludos_paradise_get_theme_setting('max_load_fonts'),
			'msg_refresh' => esc_html__('Refresh', 'ludos-paradise'),
			'msg_reset' => esc_html__('Reset', 'ludos-paradise'),
			'msg_reset_confirm' => esc_html__('Are you sure you want to reset all Theme Options?', 'ludos-paradise'),
			) ) );
		wp_localize_script( 'ludos-paradise-customizer', 'ludos_paradise_dependencies', ludos_paradise_get_theme_dependencies() );
		ludos_paradise_admin_localize_scripts();
	}
}


// Binds JS handlers to make the Customizer preview reload changes asynchronously.
if ( !function_exists( 'ludos_paradise_customizer_preview_js' ) ) {
	add_action( 'customize_preview_init', 'ludos_paradise_customizer_preview_js' );
	function ludos_paradise_customizer_preview_js() {
		wp_enqueue_script( 'ludos-paradise-customizer-preview',
							ludos_paradise_get_file_url('theme-options/theme-customizer-preview.js'), 
							array( 'customize-preview' ), null, true );
	}
}

// Output an Underscore template for generating CSS for the color scheme.
// The template generates the css dynamically for instant display in the Customizer preview.
if ( !function_exists( 'ludos_paradise_customizer_css_template' ) ) {
	add_action( 'customize_controls_print_footer_scripts', 'ludos_paradise_customizer_css_template' );
	function ludos_paradise_customizer_css_template() {
		$colors = array();
		foreach (ludos_paradise_get_scheme_colors() as $k=>$v)
			$colors[$k] = '{{ data.'.esc_attr($k).' }}';

		$tmpl_holder = 'script';

		$schemes = array_keys(ludos_paradise_get_list_schemes());
		if (count($schemes) > 0) {
			foreach ($schemes as $scheme) {
				ludos_paradise_show_layout(ludos_paradise_customizer_get_css($colors, false, false, $scheme),
									'<' . esc_attr($tmpl_holder) . ' type="text/html" id="tmpl-ludos_paradise-color-scheme-'.esc_attr($scheme).'">',
									'</' . esc_attr($tmpl_holder) . '>');
			}
		}


		// Fonts
		$fonts = ludos_paradise_get_theme_fonts();
		if (is_array($fonts) && count($fonts) > 0) {
			foreach ($fonts as $tag => $font) {
				$fonts[$tag]['font-family']		= '{{ data["'.$tag.'"]["font-family"] }}';
				$fonts[$tag]['font-size']		= '{{ data["'.$tag.'"]["font-size"] }}';
				$fonts[$tag]['line-height']		= '{{ data["'.$tag.'"]["line-height"] }}';
				$fonts[$tag]['font-weight']		= '{{ data["'.$tag.'"]["font-weight"] }}';
				$fonts[$tag]['font-style']		= '{{ data["'.$tag.'"]["font-style"] }}';
				$fonts[$tag]['text-decoration']	= '{{ data["'.$tag.'"]["text-decoration"] }}';
				$fonts[$tag]['text-transform']	= '{{ data["'.$tag.'"]["text-transform"] }}';
				$fonts[$tag]['letter-spacing']	= '{{ data["'.$tag.'"]["letter-spacing"] }}';
				$fonts[$tag]['margin-top']		= '{{ data["'.$tag.'"]["margin-top"] }}';
				$fonts[$tag]['margin-bottom']	= '{{ data["'.$tag.'"]["margin-bottom"] }}';
			}
			ludos_paradise_show_layout(ludos_paradise_customizer_get_css(false, $fonts, false, false),
								'<' . esc_attr($tmpl_holder) . ' type="text/html" id="tmpl-ludos_paradise-fonts">',
								'</' . esc_attr($tmpl_holder) . '>');
		}

	}
}

			
// Additional (calculated) theme-specific colors
if (!function_exists('ludos_paradise_customizer_add_theme_colors')) {
	function ludos_paradise_customizer_add_theme_colors($colors) {
		$add = ludos_paradise_storage_get('scheme_colors_add');
		if (is_array($add)) {
			foreach ($add as $k => $v) {
				if (substr($colors['text'], 0, 1) == '#') {
					$clr = $colors[$v['color']];
					if (isset($v['hue']) || isset($v['saturation']) || isset($v['brightness'])) {
						$clr = ludos_paradise_hsb2hex(ludos_paradise_hex2hsb($clr,
																isset($v['hue']) ? $v['hue'] : 0,
																isset($v['saturation']) ? $v['saturation'] : 0,
																isset($v['brightness']) ? $v['brightness'] : 0
																));
					}
					if (isset($v['alpha'])) {
						$clr = ludos_paradise_hex2rgba($clr, $v['alpha']);
					}
					$colors[$k] = $clr;
				} else {
					$colors[$k] = sprintf('{{ data.%s }}', $k);
				}
			}
		}
		return $colors;
	}
}


			
// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme-customizer-color-scheme.js
if (!function_exists('ludos_paradise_customizer_add_theme_fonts')) {
	function ludos_paradise_customizer_add_theme_fonts($fonts) {
		$rez = array();	
		foreach ($fonts as $tag => $font) {
			
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !ludos_paradise_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';' 
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !ludos_paradise_is_inherit($font['font-size'])
														? 'font-size:' . ludos_paradise_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !ludos_paradise_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !ludos_paradise_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !ludos_paradise_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !ludos_paradise_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !ludos_paradise_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !ludos_paradise_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !ludos_paradise_is_inherit($font['margin-top'])
														? 'margin-top:' . ludos_paradise_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !ludos_paradise_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . ludos_paradise_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}


// Add scheme name in each selector in the CSS (priority 100 - after complete css)
if (!function_exists('ludos_paradise_customizer_add_scheme_in_css')) {
	add_action( 'ludos_paradise_filter_get_css', 'ludos_paradise_customizer_add_scheme_in_css', 100, 4 );
	function ludos_paradise_customizer_add_scheme_in_css($css, $colors, $fonts, $scheme) {
		if ($colors && !empty($css['colors'])) {
			$rez = '';
			$in_comment = $in_rule = false;
			$allow = true;
			$scheme_class = sprintf('.scheme_%s ', $scheme);
			$self_class = '.scheme_self';
			$self_class_len = strlen($self_class);
			$css_str = str_replace(array('{{', '}}'), array('[[',']]'), $css['colors']);
			for ($i=0; $i<strlen($css_str); $i++) {
				$ch = $css_str[$i];
				if ($in_comment) {
					$rez .= $ch;
					if ($ch=='/' && $css_str[$i-1]=='*') {
						$in_comment = false;
						$allow = !$in_rule;
					}
				} else if ($in_rule) {
					$rez .= $ch;
					if ($ch=='}') {
						$in_rule = false;
						$allow = !$in_comment;
					}
				} else {
					if ($ch=='/' && $css_str[$i+1]=='*') {
						$rez .= $ch;
						$in_comment = true;
					} else if ($ch=='{') {
						$rez .= $ch;
						$in_rule = true;
					} else if ($ch==',') {
						$rez .= $ch;
						$allow = true;
					} else if (strpos(" \t\r\n", $ch)===false) {
						if ($allow) {
							$pos_comma = strpos($css_str, ',', $i+1);
							$pos_bracket = strpos($css_str, '{', $i+1);
							$pos = $pos_comma === false
										? $pos_bracket
										: ($pos_bracket === false
												? $pos_comma
												: min($pos_comma, $pos_bracket)
											);
							$selector = $pos > 0 ? substr($css_str, $i, $pos-$i) : '';
							if (strpos($selector, $self_class) !== false) {
								$rez .= str_replace($self_class, trim($scheme_class), $selector);
								$i += strlen($selector) - 1;
							} else {
								$rez .= $scheme_class . trim($ch);
							}
							$allow = false;
						} else
							$rez .= $ch;
					} else {
						$rez .= $ch;
					}
				}
			}
			$rez = str_replace(array('[[',']]'), array('{{', '}}'), $rez);
			$css['colors'] = $rez;
		}
		return $css;
	}
}


//----------------------------------------------------------------------------------------------
// Add fix to allow theme-specific sidebars in Customizer (if is_customize_preview() mode)
//----------------------------------------------------------------------------------------------
if (!function_exists('ludos_paradise_customizer_fix_sidebars') && is_customize_preview() && is_front_page()) {
	add_action('wp_footer', 'ludos_paradise_customizer_fix_sidebars');
	function ludos_paradise_customizer_fix_sidebars() {
		$sidebars = ludos_paradise_get_sidebars();
		if (is_array($sidebars)) {
			foreach ($sidebars as $sb=>$params) {
				if (!empty($params['front_page_section']) && is_active_sidebar($sb)) {
					?><div class="hidden"><?php dynamic_sidebar($sb); ?></div><?php
				}
			}
		}
	}
}

// Load theme options and styles
require_once LUDOS_PARADISE_THEME_DIR . 'theme-specific/theme-setup.php';
require_once LUDOS_PARADISE_THEME_DIR . 'theme-specific/theme-styles.php';
require_once LUDOS_PARADISE_THEME_DIR . 'theme-options/theme-options.php';
require_once LUDOS_PARADISE_THEME_DIR . 'theme-options/theme-options-override.php';
?>