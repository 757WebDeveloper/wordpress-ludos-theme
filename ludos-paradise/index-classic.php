<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

ludos_paradise_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	ludos_paradise_show_layout(get_query_var('blog_archive_start'));

	if (substr(ludos_paradise_get_theme_option('blog_style'), 0, 7) == 'masonry'){
		ludos_paradise_lazy_load_off();
	}
	
	$ludos_paradise_classes = 'posts_container '
						. (substr(ludos_paradise_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$ludos_paradise_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$ludos_paradise_sticky_out = ludos_paradise_get_theme_option('sticky_style')=='columns' 
							&& is_array($ludos_paradise_stickies) && count($ludos_paradise_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($ludos_paradise_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$ludos_paradise_sticky_out) {
		if (ludos_paradise_get_theme_option('first_post_large') && !is_paged() && !in_array(ludos_paradise_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($ludos_paradise_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($ludos_paradise_sticky_out && !is_sticky()) {
			$ludos_paradise_sticky_out = false;
			?></div><div class="<?php echo esc_attr($ludos_paradise_classes); ?>"><?php
		}
		get_template_part( 'content', $ludos_paradise_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	ludos_paradise_show_pagination();

	ludos_paradise_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>