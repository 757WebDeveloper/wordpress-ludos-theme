<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$ludos_paradise_content = '';
$ludos_paradise_blog_archive_mask = '%%CONTENT%%';
$ludos_paradise_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $ludos_paradise_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($ludos_paradise_content = apply_filters('the_content', get_the_content())) != '') {
		if (($ludos_paradise_pos = strpos($ludos_paradise_content, $ludos_paradise_blog_archive_mask)) !== false) {
			$ludos_paradise_content = preg_replace('/(\<p\>\s*)?'.$ludos_paradise_blog_archive_mask.'(\s*\<\/p\>)/i', $ludos_paradise_blog_archive_subst, $ludos_paradise_content);
		} else
			$ludos_paradise_content .= $ludos_paradise_blog_archive_subst;
		$ludos_paradise_content = explode($ludos_paradise_blog_archive_mask, $ludos_paradise_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) ludos_paradise_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$ludos_paradise_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$ludos_paradise_args = ludos_paradise_query_add_posts_and_cats($ludos_paradise_args, '', ludos_paradise_get_theme_option('post_type'), ludos_paradise_get_theme_option('parent_cat'));
$ludos_paradise_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($ludos_paradise_page_number > 1) {
	$ludos_paradise_args['paged'] = $ludos_paradise_page_number;
	$ludos_paradise_args['ignore_sticky_posts'] = true;
}
$ludos_paradise_ppp = ludos_paradise_get_theme_option('posts_per_page');
if ((int) $ludos_paradise_ppp != 0)
	$ludos_paradise_args['posts_per_page'] = (int) $ludos_paradise_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($ludos_paradise_args);


// Add internal query vars in the new query!
if (is_array($ludos_paradise_content) && count($ludos_paradise_content) == 2) {
	set_query_var('blog_archive_start', $ludos_paradise_content[0]);
	set_query_var('blog_archive_end', $ludos_paradise_content[1]);
}

get_template_part('index');
?>