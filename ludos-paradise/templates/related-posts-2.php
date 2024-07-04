<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_link = get_permalink();
$ludos_paradise_post_format = get_post_format();
$ludos_paradise_post_format = empty($ludos_paradise_post_format) ? 'standard' : str_replace('post-format-', '', $ludos_paradise_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($ludos_paradise_post_format) ); ?>><?php
	ludos_paradise_show_post_featured(array(
		'thumb_size' => apply_filters('ludos_paradise_filter_related_thumb_size', ludos_paradise_get_thumb_size( (int) ludos_paradise_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => ludos_paradise_get_theme_setting('allow_no_image'),
		'singular' => false
		)
	);
	?><div class="post_header entry-header"><?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($ludos_paradise_link); ?>"><?php echo wp_kses_data(ludos_paradise_get_date()); ?></a></span><?php
		}
		?>
		<h4 class="post_title entry-title"><a href="<?php echo esc_url($ludos_paradise_link); ?>"><?php the_title(); ?></a></h4>
	</div>
</div>