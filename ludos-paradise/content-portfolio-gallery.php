<?php
/**
 * The Gallery template to display posts
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
$ludos_paradise_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($ludos_paradise_columns).' post_format_'.esc_attr($ludos_paradise_post_format) ); ?>
	<?php echo (!ludos_paradise_is_off($ludos_paradise_animation) ? ' data-animation="'.esc_attr(ludos_paradise_get_animation_classes($ludos_paradise_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($ludos_paradise_image[1]) && !empty($ludos_paradise_image[2])) echo intval($ludos_paradise_image[1]) .'x' . intval($ludos_paradise_image[2]); ?>"
	data-src="<?php if (!empty($ludos_paradise_image[0])) echo esc_url($ludos_paradise_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$ludos_paradise_image_hover = 'icon';	
	if (in_array($ludos_paradise_image_hover, array('icons', 'zoom'))) $ludos_paradise_image_hover = 'dots';
	$ludos_paradise_components = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('meta_parts'));
	$ludos_paradise_counters = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('counters'));
	ludos_paradise_show_post_featured(array(
		'hover' => $ludos_paradise_image_hover,
		'thumb_size' => ludos_paradise_get_thumb_size( strpos(ludos_paradise_get_theme_option('body_style'), 'full')!==false || $ludos_paradise_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($ludos_paradise_components)
										? ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
											'components' => $ludos_paradise_components,
											'counters' => $ludos_paradise_counters,
											'seo' => false,
											'echo' => false
											), $ludos_paradise_blog_style[0], $ludos_paradise_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'ludos-paradise') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>