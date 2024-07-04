<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_blog_style = explode('_', ludos_paradise_get_theme_option('blog_style'));
$ludos_paradise_columns = empty($ludos_paradise_blog_style[1]) ? 2 : max(2, $ludos_paradise_blog_style[1]);
$ludos_paradise_post_format = get_post_format();
$ludos_paradise_post_format = empty($ludos_paradise_post_format) ? 'standard' : str_replace('post-format-', '', $ludos_paradise_post_format);
$ludos_paradise_animation = ludos_paradise_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($ludos_paradise_columns).' post_format_'.esc_attr($ludos_paradise_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!ludos_paradise_is_off($ludos_paradise_animation) ? ' data-animation="'.esc_attr(ludos_paradise_get_animation_classes($ludos_paradise_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$ludos_paradise_image_hover = ludos_paradise_get_theme_option('image_hover');
	// Featured image
	ludos_paradise_show_post_featured(array(
		'thumb_size' => ludos_paradise_get_thumb_size(strpos(ludos_paradise_get_theme_option('body_style'), 'full')!==false || $ludos_paradise_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $ludos_paradise_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $ludos_paradise_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>