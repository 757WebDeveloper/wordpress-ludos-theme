<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

ludos_paradise_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	ludos_paradise_show_layout(get_query_var('blog_archive_start'));

	$ludos_paradise_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$ludos_paradise_sticky_out = ludos_paradise_get_theme_option('sticky_style')=='columns' 
							&& is_array($ludos_paradise_stickies) && count($ludos_paradise_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($ludos_paradise_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$ludos_paradise_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($ludos_paradise_sticky_out && !is_sticky()) {
			$ludos_paradise_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $ludos_paradise_sticky_out && is_sticky() ? 'sticky' :'chess' );
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