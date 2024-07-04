<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$ludos_paradise_post_format = get_post_format();
$ludos_paradise_post_format = empty($ludos_paradise_post_format) ? 'standard' : str_replace('post-format-', '', $ludos_paradise_post_format);
$ludos_paradise_animation = ludos_paradise_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($ludos_paradise_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($ludos_paradise_post_format) ); ?>
	<?php echo (!ludos_paradise_is_off($ludos_paradise_animation) ? ' data-animation="'.esc_attr(ludos_paradise_get_animation_classes($ludos_paradise_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	ludos_paradise_show_post_featured(array(
		'thumb_size' => ludos_paradise_get_thumb_size($ludos_paradise_columns==1 ? 'big' : ($ludos_paradise_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($ludos_paradise_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(), 'sticky', $ludos_paradise_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>