<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0.31
 */

get_header();

// If front-page is a static page
if (get_option('show_on_front') == 'page') {

	// If Front Page Builder is enabled - display sections
	if (ludos_paradise_is_on(ludos_paradise_get_theme_option('front_page_enabled'))) {

		if ( have_posts() ) the_post();

		$ludos_paradise_sections = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('front_page_sections'), 1, false);
		if (is_array($ludos_paradise_sections)) {
			foreach ($ludos_paradise_sections as $ludos_paradise_section) {
				get_template_part("front-page/section", $ludos_paradise_section);
			}
		}
	
	// Else if this page is blog archive
	} else if (is_page_template('blog.php')) {
		get_template_part('blog');

	// Else - display native page content
	} else {
		get_template_part('page');
	}

// Else get index template to show posts
} else {
	get_template_part('index');
}

get_footer();
?>