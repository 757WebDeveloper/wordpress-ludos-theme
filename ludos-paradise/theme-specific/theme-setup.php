<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.22
 */

if (!defined("LUDOS_PARADISE_THEME_FREE"))		define("LUDOS_PARADISE_THEME_FREE", false);
if (!defined("LUDOS_PARADISE_THEME_FREE_WP"))	define("LUDOS_PARADISE_THEME_FREE_WP", false);

// Theme storage
$LUDOS_PARADISE_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'ludos-paradise'),

			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'instagram-feed'				=> esc_html__('Instagram Feed', 'ludos-paradise'),			
			'contact-form-7'				=> esc_html__('Contact Form 7', 'ludos-paradise'),
            'm-chart'		            	=> esc_html__('M Chart', 'ludos-paradise'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'ludos-paradise'),
			'woocommerce'					=> esc_html__('WooCommerce', 'ludos-paradise'),
			'wp-gdpr-compliance'			=> esc_html__('Cookie Information', 'ludos-paradise'),
			'trx_updater'			        => esc_html__('ThemeREX Updater', 'ludos-paradise'),
			'elegro-payment'			    => esc_html__('Elegro Crypto Payment', 'ludos-paradise')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		LUDOS_PARADISE_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					'siteorigin-panels'			=> esc_html__('SiteOrigin Panels', 'ludos-paradise'),
					) 

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'bbpress'					=> esc_html__('BBPress and BuddyPress', 'ludos-paradise'),
					'bp-classic'					=> esc_html__('BP Classic', 'ludos-paradise'),
					'essential-grid'			=> esc_html__('Essential Grid', 'ludos-paradise'),
					'revslider'					=> esc_html__('Revolution Slider', 'ludos-paradise'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'ludos-paradise'),
					)
	),
	
	// Key validator: 
	'theme_pro_key'		=> LUDOS_PARADISE_THEME_FREE 
								? 'env-ancora' 
								: '',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> ludos_paradise_get_protocol() . '://ludos-paradise.ancorathemes.com',
	'theme_doc_url'		=> ludos_paradise_get_protocol() . '://ludos-paradise.ancorathemes.com/doc',
	'theme_download_url'=> ludos_paradise_get_protocol() . '://1.envato.market/c/1262870/275988/4415?subId1=ancora&u=themeforest.net/item/dota-paradise-gaming-blog-store-wp-theme/21741960?s_rank=1',

	'theme_support_url'	=> ludos_paradise_get_protocol() . '://themerex.net/support',

	'theme_video_url'	=> ludos_paradise_get_protocol() . '://www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',

	// Responsive resolutions
	// Parameters to create css media query: min, max, 
	'responsive' => array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1441),
						'lg'		=> array('max' => 1263),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


if ( !function_exists('ludos_paradise_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'ludos_paradise_customizer_theme_setup1', 1 );
	function ludos_paradise_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		ludos_paradise_storage_set('settings', array(
			
			'duplicate_options'		=> 'both',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// WPBakery Page Builder (default) - standard WPBakery Page Builder icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		ludos_paradise_storage_set('load_fonts', array(
			// Google font
            array(
                'name'   => 'Spectral SC',
                'family' => 'serif',
                'styles' => '500'		// Parameter 'style' used only for the Google fonts
            ),
			// Font-face packed with theme
            array(
                'name'	 => 'Josefin Sans',
                'family' => 'sans-serif'
            )

        ));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		ludos_paradise_storage_set('load_fonts_subset', 'latin,latin-ext');
		

		ludos_paradise_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'ludos-paradise'),
				'font-family'		=> '"Josefin Sans",sans-serif',
				'font-size' 		=> '17px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '23px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.4px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.4em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'ludos-paradise'),
				'font-family'		=> '"Spectral SC",serif',
				'font-size' 		=> '2.118em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.26em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '6.2rem',
				'margin-bottom'		=> '1.1rem'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'ludos-paradise'),
				'font-family'		=> '"Spectral SC",serif',
				'font-size' 		=> '1.765em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.28em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '6.2rem',
				'margin-bottom'		=> '0.9rem'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'ludos-paradise'),
				'font-family'		=> '"Spectral SC",serif',
				'font-size' 		=> '1.412em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.22em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '5.8rem',
				'margin-bottom'		=> '0.9rem'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'ludos-paradise'),
				'font-family'		=> '"Spectral SC",serif',
				'font-size' 		=> '1.059em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.24em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '5.3rem',
				'margin-bottom'		=> '1.2rem'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'ludos-paradise'),
				'font-family'		=> '"Josefin Sans",sans-serif',
				'font-size' 		=> '16px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.35em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.54px',
				'margin-top'		=> '4.9rem',
				'margin-bottom'		=> '1rem'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'ludos-paradise'),
				'font-family'		=> '"Josefin Sans",sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.4706em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-0.1px',
				'margin-top'		=> '4.55rem',
				'margin-bottom'		=> '1rem'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'ludos-paradise'),
				'font-family'		=> '"Josefin Sans",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'ludos-paradise'),
				'font-family'		=> '"Josefin Sans",sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '21px',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'ludos-paradise'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> 'normal',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.5px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'ludos-paradise'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '16px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.46px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the main menu items', 'ludos-paradise'),
				'font-family'		=> '"Spectral SC",serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.6px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'ludos-paradise'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'ludos-paradise'),
                'font-family'		=> '"Spectral SC",serif',
                'font-size' 		=> '15px',
                'font-weight'		=> '500',
                'font-style'		=> 'normal',
                'line-height'		=> '1.5em',
                'text-decoration'	=> 'none',
                'text-transform'	=> 'uppercase',
                'letter-spacing'	=> '0.6px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		ludos_paradise_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'ludos-paradise'),
							'description'	=> esc_html__('Colors of the main content area', 'ludos-paradise')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'ludos-paradise'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'ludos-paradise')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'ludos-paradise'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'ludos-paradise')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'ludos-paradise'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'ludos-paradise')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'ludos-paradise'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'ludos-paradise')
							),
			)
		);
		ludos_paradise_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'ludos-paradise'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'ludos-paradise')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'ludos-paradise'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'ludos-paradise')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'ludos-paradise'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'ludos-paradise')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'ludos-paradise'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'ludos-paradise')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'ludos-paradise')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'ludos-paradise')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'ludos-paradise')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the links inside this block', 'ludos-paradise')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'ludos-paradise')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'ludos-paradise')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'ludos-paradise')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'ludos-paradise')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'ludos-paradise'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'ludos-paradise')
							)
			)
		);
		ludos_paradise_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'ludos-paradise'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#e5e5e5',
		
					// Text and links colors
					'text'				=> '#333333',
					'text_light'		=> '#b7b7b7',
					'text_dark'			=> '#1d1d1d',
					'text_link'			=> '#72cfd5',
					'text_hover'		=> '#fe7259',
					'text_link2'		=> '#80d572',
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f3f5f7',
					'alter_bg_hover'	=> '#e6e8eb',
					'alter_bd_color'	=> '#e5e5e5',
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#1d1d1d',
					'alter_link'		=> '#fe7259',
					'alter_hover'		=> '#72cfd5',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#313131',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#bfbfbf',
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#72cfd5',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff',
					'input_bg_hover'	=> '#ffffff',
					'input_bd_color'	=> '#e7eaed',
					'input_bd_hover'	=> '#e0e0e0',
					'input_text'		=> '#888888',
					'input_light'		=> '#a7a7a7',
					'input_dark'		=> '#1d1d1d',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'ludos-paradise'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#0b1822',   
					'bd_color'			=> '#334459',   
		
					// Text and links colors
					'text'				=> '#9cabb9',   
					'text_light'		=> '#848484',
					'text_dark'			=> '#ffffff',   
					'text_link'			=> '#f2300d',   
					'text_hover'		=> '#d7310a',   
					'text_link2'		=> '#b21707',   
					'text_hover2'		=> '#ec5911',   
					'text_link3'		=> '#c80d09',   
					'text_hover3'		=> '#fc4c09',   

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#141a22',   
					'alter_bg_hover'	=> '#061217',   
					'alter_bd_color'	=> '#515d6c',   
					'alter_bd_hover'	=> '#404b58',   
					'alter_text'		=> '#a6a6a6',
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#f2300d',  
					'alter_hover'		=> '#ff8637',   
					'alter_link2'		=> '#d42c0a',  
					'alter_hover2'		=> '#ca0e09',   
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#162b35',   
					'extra_bg_hover'	=> '#21313e',   
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a6a6a6',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#162e3b',   
					'input_bg_hover'	=> '#061217',   
					'input_bd_color'	=> '#9cabb9',   
					'input_bd_hover'	=> '#ffffff',   
					'input_text'		=> '#9cabb9',   
					'input_light'		=> '#9cabb9',   
					'input_dark'		=> '#ffffff',   
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),

            // Color scheme: 'dark'
            'white' => array(
                'title'  => esc_html__('White', 'ludos-paradise'),
                'colors' => array(

                    // Whole block border and background
                    'bg_color'			=> '#ffffff',   
                    'bd_color'			=> '#dfe7ea',   

                    // Text and links colors
                    'text'				=> '#4c636d',   
                    'text_light'		=> '#848484',
                    'text_dark'			=> '#061217',   
                    'text_link'			=> '#f2300d',   
                    'text_hover'		=> '#d7310a',   
                    'text_link2'		=> '#b21707',   
                    'text_hover2'		=> '#ec5911',   
                    'text_link3'		=> '#c80d09',   
                    'text_hover3'		=> '#fc4c09',   

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'	=> '#141a22',   
                    'alter_bg_hover'	=> '#061217',   
                    'alter_bd_color'	=> '#515d6c',   
                    'alter_bd_hover'	=> '#404b58',   
                    'alter_text'		=> '#a6a6a6',
                    'alter_light'		=> '#5f5f5f',
                    'alter_dark'		=> '#ffffff',
                    'alter_link'		=> '#f2300d',   
                    'alter_hover'		=> '#ff8637',   
                    'alter_link2'		=> '#d42c0a',   
                    'alter_hover2'		=> '#ca0e09',   
                    'alter_link3'		=> '#eec432',
                    'alter_hover3'		=> '#ddb837',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'	=> '#162b35',   
                    'extra_bg_hover'	=> '#21313e',   
                    'extra_bd_color'	=> '#464646',
                    'extra_bd_hover'	=> '#4a4a4a',
                    'extra_text'		=> '#a6a6a6',
                    'extra_light'		=> '#5f5f5f',
                    'extra_dark'		=> '#ffffff',
                    'extra_link'		=> '#ffaa5f',
                    'extra_hover'		=> '#fe7259',
                    'extra_link2'		=> '#80d572',
                    'extra_hover2'		=> '#8be77c',
                    'extra_link3'		=> '#ddb837',
                    'extra_hover3'		=> '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'	=> '#162e3b',   
                    'input_bg_hover'	=> '#061217',   
                    'input_bd_color'	=> '#9cabb9',   
                    'input_bd_hover'	=> '#ffffff',   
                    'input_text'		=> '#9cabb9',   
                    'input_light'		=> '#9cabb9',   
                    'input_dark'		=> '#ffffff',   

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color'	=> '#e36650',
                    'inverse_bd_hover'	=> '#cb5b47',
                    'inverse_text'		=> '#1d1d1d',
                    'inverse_light'		=> '#5f5f5f',
                    'inverse_dark'		=> '#000000',
                    'inverse_link'		=> '#ffffff',
                    'inverse_hover'		=> '#1d1d1d'
                )
            )
		
		));
		
		// Simple schemes substitution
		ludos_paradise_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		ludos_paradise_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'bd_color_04'		=> array('color' => 'bd_color',			'alpha' => 0.4),
			'bd_color_05'		=> array('color' => 'bd_color',			'alpha' => 0.5),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_02'		    => array('color' => 'text',		        'alpha' => 0.2),
			'text_dark_02'		=> array('color' => 'text_dark',		'alpha' => 0.2),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		ludos_paradise_storage_set('theme_thumbs', apply_filters('ludos_paradise_filter_add_thumb_sizes', array(
			// Width of the image is equal to the content area width (without sidebar)
			// Height is fixed
			'ludos_paradise-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			// Width of the image is equal to the content area width (with sidebar)
			// Height is fixed
			'ludos_paradise-thumb-big' 		=> array(
												'size'	=> array( 710, 428, true),
												'title' => esc_html__( 'Large image', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			// Width of the image is equal to the 1/3 of the content area width (without sidebar)
			// Height is fixed
			'ludos_paradise-thumb-med' 		=> array(
												'size'	=> array( 370, 208, true),
												'title' => esc_html__( 'Medium image', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

                'ludos_paradise-thumb-magazine' 		=> array(
                    'size'	=> array( 770, 483, true),
                    'title' => esc_html__( 'Big magazine image', 'ludos-paradise' ),
                    'subst'	=> 'trx_addons-thumb-magazine'
                ),
                'ludos_paradise-thumb-magazines' 		=> array(
                    'size'	=> array( 386, 234, true),
                    'title' => esc_html__( 'Small magazine image', 'ludos-paradise' ),
                    'subst'	=> 'trx_addons-thumb-magazines'
                ),

                'ludos_paradise-thumb-vertical' 		=> array(
                    'size'	=> array( 455, 570, true),
                    'title' => esc_html__( 'Vertical image', 'ludos-paradise' ),
                    'subst'	=> 'trx_addons-thumb-vertical'
                ),
                'ludos_paradise-thumb-team' 		=> array(
                    'size'	=> array( 198, 380, true),
                    'title' => esc_html__( 'Team image', 'ludos-paradise' ),
                    'subst'	=> 'trx_addons-thumb-team'
                ),

                'ludos_paradise-thumb-square' 		=> array(
                    'size'	=> array( 237, 219, true),
                    'title' => esc_html__( 'Square image', 'ludos-paradise' ),
                    'subst'	=> 'trx_addons-thumb-square'
                ),

			// Small square image (for avatars in comments, etc.)
			'ludos_paradise-thumb-tiny' 		=> array(
												'size'	=> array(  94,  94, true),
												'title' => esc_html__( 'Small square avatar', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			// Width of the image is equal to the content area width (with sidebar)
			// Height is proportional (only downscale, not crop)
			'ludos_paradise-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
			// Height is proportional (only downscale, not crop)
			'ludos_paradise-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'ludos-paradise' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'ludos_paradise_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'ludos_paradise_importer_set_options', 9 );
	function ludos_paradise_importer_set_options($options=array()) {
		if (is_array($options)) {
			$rtl_slug = is_rtl() ? '-rtl' : '';
			$rtl_url = is_rtl() ? 'rtl.' : '';
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(ludos_paradise_get_protocol() . '://demofiles.ancorathemes.com/ludos-paradise'. $rtl_slug .'/');
			// Required plugins
			$options['required_plugins'] = array_keys(ludos_paradise_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Ludos Paradise Demo', 'ludos-paradise');
			$options['files']['default']['domain_dev'] = esc_url('http://dota.dv.ancorathemes.com');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url( 'https://' . $rtl_url . 'ludos-paradise.ancorathemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => ludos_paradise_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'ludos-paradise'),
					'content' => wp_kses(__("Create your front page right in the WordPress Customizer. There's no need in WPBakery Page Builder, or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'ludos-paradise'), 'ludos_paradise_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'ludos-paradise'),
					'duration' => 20
					),
				array(
					'image' => ludos_paradise_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'ludos-paradise'),
					'content' => wp_kses(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'ludos-paradise'), 'ludos_paradise_kses_content'),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'ludos-paradise'),
					'duration' => 20
					),
				array(
					'image' => ludos_paradise_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'ludos-paradise'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use Ludos Paradise', 'ludos-paradise'),'ludos_paradise_kses_content'),
					'link_url' => esc_url(ludos_paradise_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'ludos-paradise'),
					'duration' => 15
					),
				array(
					'image' => ludos_paradise_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video tutorials', 'ludos-paradise'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize Ludos Paradise in detail.', 'ludos-paradise'), 'ludos_paradise_kses_content'),
					'link_url' => esc_url(ludos_paradise_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'ludos-paradise'),
					'duration' => 15
					),
				array(
					'image' => ludos_paradise_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'ludos-paradise'),
					'content' => wp_kses(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'ludos-paradise'), 'ludos_paradise_kses_content'),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash'),
					'link_caption' => esc_html__('Contact Us', 'ludos-paradise'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('ludos_paradise_create_theme_options')) {

	function ludos_paradise_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'ludos-paradise');
		
		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count(ludos_paradise_storage_get('schemes')) < 2;
		
		ludos_paradise_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'ludos-paradise'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'ludos-paradise'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2 ludos_paradise_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'ludos-paradise') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2 ludos_paradise_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2 ludos_paradise_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2 ludos_paradise_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'ludos-paradise'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'ludos-paradise'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select width of the body content', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => ludos_paradise_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Background image', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload image, used as background', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"std" => '',
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'ludos-paradise'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'ludos-paradise') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'ludos-paradise'),
				"desc" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'ludos-paradise')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'ludos-paradise'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'ludos-paradise') ),
				"std" => 0,
				"type" => "text"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'ludos-paradise'),
				"desc" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'ludos-paradise') ),
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'ludos-paradise'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'ludos-paradise') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'ludos-paradise'), 'ludos_paradise_kses_content' ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'ludos-paradise'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'ludos-paradise'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => 'default',
				"options" => ludos_paradise_get_list_header_footer_types(),
				"type" => LUDOS_PARADISE_THEME_FREE || !ludos_paradise_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'ludos-paradise'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'ludos-paradise'), 'ludos_paradise_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => LUDOS_PARADISE_THEME_FREE ? 'header-default' : 'header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => 'default',
				"options" => array(),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'ludos-paradise') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'ludos-paradise') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'ludos-paradise') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => ludos_paradise_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select main menu style, position and other parameters', 'ludos-paradise') ),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'ludos-paradise'),
					'left'	=> esc_html__('Left',	'ludos-paradise'),
					'right'	=> esc_html__('Right',	'ludos-paradise')
				),
				"type" => LUDOS_PARADISE_THEME_FREE || !ludos_paradise_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'ludos-paradise') ),
				"std" => 1,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'ludos-paradise'),
				"desc" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'ludos-paradise') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'ludos-paradise') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'ludos-paradise') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'ludos-paradise'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'ludos-paradise'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'ludos-paradise'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'ludos-paradise'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'ludos-paradise'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
				),

            'title_info' => array(
                "title" => esc_html__('Additional settings', 'ludos-paradise'),
                "desc" => '',
                "priority" => 500,
                "dependency" => array(
                    'header_type' => array('default')
                ),
                "type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info"
            ),
            'show_page_title' => array(
                "title" => esc_html__('Show page title', 'ludos-paradise'),
                "desc" => wp_kses_data( __("Show page title in content area", 'ludos-paradise') ),
                "override" => array(
                    'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
                    'section' => esc_html__('Header', 'ludos-paradise')
                ),
                "std" => 1,
                "type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
            ),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'ludos-paradise'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'ludos-paradise')
				),
				"std" => 'default',
				"options" => ludos_paradise_get_list_header_footer_types(),
				"type" => LUDOS_PARADISE_THEME_FREE || !ludos_paradise_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'ludos-paradise'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'ludos-paradise'), 'ludos_paradise_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'ludos-paradise')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => LUDOS_PARADISE_THEME_FREE ? 'footer-default' : 'footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'ludos-paradise')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'ludos-paradise')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => ludos_paradise_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'ludos-paradise')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'ludos-paradise') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'ludos-paradise') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'ludos-paradise') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'ludos-paradise') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !ludos_paradise_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'ludos-paradise') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by AncoraThemes. All rights reserved.', 'ludos-paradise'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'ludos-paradise') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'ludos-paradise') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'ludos-paradise'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'ludos-paradise'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'ludos-paradise') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'ludos-paradise'),
						'fullpost'	=> esc_html__('Full post',	'ludos-paradise')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'ludos-paradise') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 41,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'ludos-paradise'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'ludos-paradise') ),
					"std" => 2,
					"options" => ludos_paradise_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'ludos-paradise'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'ludos-paradise'),
						'links'	=> esc_html__("Older/Newest", 'ludos-paradise'),
						'more'	=> esc_html__("Load more", 'ludos-paradise'),
						'infinite' => esc_html__("Infinite scroll", 'ludos-paradise')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'ludos-paradise'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'ludos-paradise') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'ludos-paradise') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'ludos-paradise') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'ludos-paradise'),
					"desc" => '',
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'ludos-paradise') ),
					"std" => 'hide',
					"options" => array(),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'ludos-paradise') ),
					"std" => 'hide',
					"options" => array(),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'ludos-paradise') ),
					"std" => 'hide',
					"options" => array(),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'ludos-paradise') ),
					"std" => 'hide',
					"options" => array(),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'ludos-paradise'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'ludos-paradise') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'ludos-paradise'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'ludos-paradise') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'ludos-paradise') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'ludos-paradise'),
						'columns' => esc_html__('Mini-cards',	'ludos-paradise')
					),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'ludos-paradise'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'ludos-paradise') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'ludos-paradise'),
						'date'		 => esc_html__('Post date', 'ludos-paradise'),
						'author'	 => esc_html__('Post author', 'ludos-paradise'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'ludos-paradise'),
						'share'		 => esc_html__('Share links', 'ludos-paradise'),
						'edit'		 => esc_html__('Edit link', 'ludos-paradise')
					),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'ludos-paradise'),
						'likes' => esc_html__('Likes', 'ludos-paradise'),
						'comments' => esc_html__('Comments', 'ludos-paradise')
					),
					"type" => LUDOS_PARADISE_THEME_FREE || !ludos_paradise_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Settings of the single post', 'ludos-paradise') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'ludos-paradise') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'ludos-paradise') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'ludos-paradise') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'ludos-paradise') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=1|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'ludos-paradise'),
						'date'		 => esc_html__('Post date', 'ludos-paradise'),
						'author'	 => esc_html__('Post author', 'ludos-paradise'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'ludos-paradise'),
						'share'		 => esc_html__('Share links', 'ludos-paradise'),
						'edit'		 => esc_html__('Edit link', 'ludos-paradise')
					),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Likes and Views are available only if plugin ThemeREX Addons is active", 'ludos-paradise') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'ludos-paradise'),
						'likes' => esc_html__('Likes', 'ludos-paradise'),
						'comments' => esc_html__('Comments', 'ludos-paradise')
					),
					"type" => LUDOS_PARADISE_THEME_FREE || !ludos_paradise_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'ludos-paradise') ),
					"std" => 1,
					"type" => !ludos_paradise_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'ludos-paradise') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'ludos-paradise'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'ludos-paradise'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'ludos-paradise') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'ludos-paradise')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'ludos-paradise'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'ludos-paradise') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => ludos_paradise_get_list_range(1,9),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'ludos-paradise'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'ludos-paradise') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => ludos_paradise_get_list_range(1,4),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'ludos-paradise'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'ludos-paradise') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => ludos_paradise_get_list_styles(1,2),
					"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'ludos-paradise'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'ludos-paradise') ),
				"hidden" => $hide_schemes,
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'ludos-paradise'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'ludos-paradise')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'ludos-paradise'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'ludos-paradise')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'ludos-paradise'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'ludos-paradise')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes || LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'ludos-paradise'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'ludos-paradise')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'ludos-paradise'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'ludos-paradise')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => $hide_schemes ? 'hidden' : "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'ludos-paradise'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'ludos-paradise') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'ludos-paradise'),
				"desc" => '',
				"std" => '$ludos_paradise_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"hidden" => true,
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'ludos-paradise') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'ludos-paradise')
				),
				"hidden" => true,
				"std" => '',
				"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'ludos-paradise'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'ludos-paradise') )
						. '<br>'
						. wp_kses_data( __('Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'ludos-paradise') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'ludos-paradise') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_3 ludos_paradise_new_row",
				"refresh" => false,
				"std" => '$ludos_paradise_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=ludos_paradise_get_theme_setting('max_load_fonts'); $i++) {
			if (ludos_paradise_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'ludos-paradise'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'ludos-paradise'),
				"desc" => '',
				"class" => "ludos_paradise_column-1_3 ludos_paradise_new_row",
				"refresh" => false,
				"std" => '$ludos_paradise_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'ludos-paradise'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'ludos-paradise') )
							: '',
				"class" => "ludos_paradise_column-1_3",
				"refresh" => false,
				"std" => '$ludos_paradise_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'ludos-paradise'),
					'serif' => esc_html__('serif', 'ludos-paradise'),
					'sans-serif' => esc_html__('sans-serif', 'ludos-paradise'),
					'monospace' => esc_html__('monospace', 'ludos-paradise'),
					'cursive' => esc_html__('cursive', 'ludos-paradise'),
					'fantasy' => esc_html__('fantasy', 'ludos-paradise')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'ludos-paradise'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'ludos-paradise') )
								. '<br>'
								. wp_kses_data( __('Attention! Each weight and style increase download size! Specify only used weights and styles.', 'ludos-paradise') )
							: '',
				"class" => "ludos_paradise_column-1_3",
				"refresh" => false,
				"std" => '$ludos_paradise_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = ludos_paradise_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'ludos-paradise'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'ludos-paradise'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'ludos-paradise'),
						'100' => esc_html__('100 (Light)', 'ludos-paradise'), 
						'200' => esc_html__('200 (Light)', 'ludos-paradise'), 
						'300' => esc_html__('300 (Thin)',  'ludos-paradise'),
						'400' => esc_html__('400 (Normal)', 'ludos-paradise'),
						'500' => esc_html__('500 (Semibold)', 'ludos-paradise'),
						'600' => esc_html__('600 (Semibold)', 'ludos-paradise'),
						'700' => esc_html__('700 (Bold)', 'ludos-paradise'),
						'800' => esc_html__('800 (Black)', 'ludos-paradise'),
						'900' => esc_html__('900 (Black)', 'ludos-paradise')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'ludos-paradise'),
						'normal' => esc_html__('Normal', 'ludos-paradise'), 
						'italic' => esc_html__('Italic', 'ludos-paradise')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'ludos-paradise'),
						'none' => esc_html__('None', 'ludos-paradise'), 
						'underline' => esc_html__('Underline', 'ludos-paradise'),
						'overline' => esc_html__('Overline', 'ludos-paradise'),
						'line-through' => esc_html__('Line-through', 'ludos-paradise')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'ludos-paradise'),
						'none' => esc_html__('None', 'ludos-paradise'), 
						'uppercase' => esc_html__('Uppercase', 'ludos-paradise'),
						'lowercase' => esc_html__('Lowercase', 'ludos-paradise'),
						'capitalize' => esc_html__('Capitalize', 'ludos-paradise')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "ludos_paradise_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$ludos_paradise_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		ludos_paradise_storage_set_array_before('options', 'panel_colors', $fonts);


		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if (!function_exists('get_header_video_url')) {
			ludos_paradise_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'ludos-paradise'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'ludos-paradise') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'ludos-paradise')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}


		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		// ------------------------------------------------------
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			ludos_paradise_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'ludos-paradise'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'ludos-paradise') ),
				"class" => "ludos_paradise_column-1_2 ludos_paradise_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('ludos_paradise_options_get_list_cpt_options')) {
	function ludos_paradise_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'ludos-paradise'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'ludos-paradise') ),
						"std" => 'inherit',
						"options" => ludos_paradise_get_list_header_footer_types(true),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'ludos-paradise'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'ludos-paradise'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'ludos-paradise'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'ludos-paradise'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'ludos-paradise'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'ludos-paradise') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'ludos-paradise'),
							1 => esc_html__('Yes', 'ludos-paradise'),
							0 => esc_html__('No', 'ludos-paradise'),
						),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'ludos-paradise'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'ludos-paradise'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'ludos-paradise'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'ludos-paradise'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'ludos-paradise'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'ludos-paradise'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'ludos-paradise'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'ludos-paradise'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'ludos-paradise') ),
						"std" => 'inherit',
						"options" => array(
							'inherit' => esc_html__('Inherit', 'ludos-paradise'),
							1 => esc_html__('Hide', 'ludos-paradise'),
							0 => esc_html__('Show', 'ludos-paradise'),
						),
						"type" => "switch"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'ludos-paradise'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'ludos-paradise') ),
						"std" => 'inherit',
						"options" => ludos_paradise_get_list_header_footer_types(true),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'ludos-paradise') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'ludos-paradise') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'ludos-paradise') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => ludos_paradise_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'ludos-paradise') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'ludos-paradise'),
						"desc" => '',
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'ludos-paradise') ),
						"std" => 'hide',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'ludos-paradise') ),
						"std" => 'hide',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'ludos-paradise') ),
						"std" => 'hide',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'ludos-paradise'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'ludos-paradise') ),
						"std" => 'hide',
						"options" => array(),
						"type" => LUDOS_PARADISE_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('ludos_paradise_options_get_list_choises')) {
	add_filter('ludos_paradise_filter_options_get_list_choises', 'ludos_paradise_options_get_list_choises', 10, 2);
	function ludos_paradise_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = ludos_paradise_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = ludos_paradise_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = ludos_paradise_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = ludos_paradise_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = ludos_paradise_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = ludos_paradise_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = ludos_paradise_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = ludos_paradise_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = ludos_paradise_array_merge(array(0 => esc_html__('- Select category -', 'ludos-paradise')), ludos_paradise_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = ludos_paradise_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = ludos_paradise_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = ludos_paradise_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>