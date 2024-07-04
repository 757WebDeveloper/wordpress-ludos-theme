<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_post_id    = get_the_ID();
$ludos_paradise_post_date  = ludos_paradise_get_date();
$ludos_paradise_post_title = get_the_title();
$ludos_paradise_post_link  = get_permalink();
$ludos_paradise_post_author_id   = get_the_author_meta('ID');
$ludos_paradise_post_author_name = get_the_author_meta('display_name');
$ludos_paradise_post_author_url  = get_author_posts_url($ludos_paradise_post_author_id, '');

$ludos_paradise_args = get_query_var('ludos_paradise_args_widgets_posts');
$ludos_paradise_show_date = isset($ludos_paradise_args['show_date']) ? (int) $ludos_paradise_args['show_date'] : 1;
$ludos_paradise_show_image = isset($ludos_paradise_args['show_image']) ? (int) $ludos_paradise_args['show_image'] : 1;
$ludos_paradise_show_author = isset($ludos_paradise_args['show_author']) ? (int) $ludos_paradise_args['show_author'] : 1;
$ludos_paradise_show_counters = isset($ludos_paradise_args['show_counters']) ? (int) $ludos_paradise_args['show_counters'] : 1;
$ludos_paradise_show_categories = isset($ludos_paradise_args['show_categories']) ? (int) $ludos_paradise_args['show_categories'] : 1;

$ludos_paradise_output = ludos_paradise_storage_get('ludos_paradise_output_widgets_posts');

$ludos_paradise_post_counters_output = '';
if ( $ludos_paradise_show_counters ) {
	$ludos_paradise_post_counters_output = '<span class="post_info_item post_info_counters">'
								. ludos_paradise_get_post_counters('comments')
							. '</span>';
}


$ludos_paradise_output .= '<article class="post_item with_thumb">';

if ($ludos_paradise_show_image) {
	$ludos_paradise_post_thumb = get_the_post_thumbnail($ludos_paradise_post_id, ludos_paradise_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($ludos_paradise_post_thumb) $ludos_paradise_output .= '<div class="post_thumb">' . ($ludos_paradise_post_link ? '<a href="' . esc_url($ludos_paradise_post_link) . '">' : '') . ($ludos_paradise_post_thumb) . ($ludos_paradise_post_link ? '</a>' : '') . '</div>';
}

$ludos_paradise_output .= '<div class="post_content">'
			. ($ludos_paradise_show_categories 
					? '<div class="post_categories">'
						. ludos_paradise_get_post_categories()
						. $ludos_paradise_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($ludos_paradise_post_link ? '<a href="' . esc_url($ludos_paradise_post_link) . '">' : '') . ($ludos_paradise_post_title) . ($ludos_paradise_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('ludos_paradise_filter_get_post_info', 
								'<div class="post_info">'
									. ($ludos_paradise_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($ludos_paradise_post_link ? '<a href="' . esc_url($ludos_paradise_post_link) . '" class="post_info_date">' : '') 
											. esc_html($ludos_paradise_post_date) 
											. ($ludos_paradise_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($ludos_paradise_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'ludos-paradise') . ' ' 
											. ($ludos_paradise_post_link ? '<a href="' . esc_url($ludos_paradise_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($ludos_paradise_post_author_name) 
											. ($ludos_paradise_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$ludos_paradise_show_categories && $ludos_paradise_post_counters_output
										? $ludos_paradise_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
ludos_paradise_storage_set('ludos_paradise_output_widgets_posts', $ludos_paradise_output);
?>