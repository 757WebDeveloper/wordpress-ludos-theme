<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage LUDOS_PARADISE
 * @since LUDOS_PARADISE 1.0
 */

$ludos_paradise_blog_style = explode('_', ludos_paradise_get_theme_option('blog_style'));
$ludos_paradise_columns = empty($ludos_paradise_blog_style[1]) ? 2 : max(2, $ludos_paradise_blog_style[1]);
$ludos_paradise_expanded = !ludos_paradise_sidebar_present() && ludos_paradise_is_on(ludos_paradise_get_theme_option('expand_content'));
$ludos_paradise_post_format = get_post_format();
$ludos_paradise_post_format = empty($ludos_paradise_post_format) ? 'standard' : str_replace('post-format-', '', $ludos_paradise_post_format);
$ludos_paradise_animation = ludos_paradise_get_theme_option('blog_animation');
$ludos_paradise_components = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('meta_parts'));
$ludos_paradise_counters = ludos_paradise_array_get_keys_by_value(ludos_paradise_get_theme_option('counters'));
?><div class="<?php echo esc_attr($ludos_paradise_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($ludos_paradise_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($ludos_paradise_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($ludos_paradise_columns)
					. ' post_layout_'.esc_attr($ludos_paradise_blog_style[0]) 
					. ' post_layout_'.esc_attr($ludos_paradise_blog_style[0]).'_'.esc_attr($ludos_paradise_columns)
					); ?>
	<?php echo (!ludos_paradise_is_off($ludos_paradise_animation) ? ' data-animation="'.esc_attr(ludos_paradise_get_animation_classes($ludos_paradise_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	ludos_paradise_show_post_featured( array( 'thumb_size' => ludos_paradise_get_thumb_size($ludos_paradise_blog_style[0] == 'classic'
													? (strpos(ludos_paradise_get_theme_option('body_style'), 'full')!==false 
															? ( $ludos_paradise_columns > 2 ? 'big' : 'huge' )
															: (	$ludos_paradise_columns > 2
																? ($ludos_paradise_expanded ? 'med' : 'small')
																: ($ludos_paradise_expanded ? 'big' : 'med')
																)
														)
													: (strpos(ludos_paradise_get_theme_option('body_style'), 'full')!==false 
															? ( $ludos_paradise_columns > 2 ? 'masonry-big' : 'full' )
															: (	$ludos_paradise_columns <= 2 && $ludos_paradise_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($ludos_paradise_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('ludos_paradise_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('ludos_paradise_action_before_post_meta'); 

			// Post meta
			if (!empty($ludos_paradise_components))
				ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
					'components' => 'date,author',
					'counters' => $ludos_paradise_counters,
					'seo' => false
					), $ludos_paradise_blog_style[0], $ludos_paradise_columns)
				);

			do_action('ludos_paradise_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$ludos_paradise_show_learn_more = false; 
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($ludos_paradise_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($ludos_paradise_post_format == 'quote') {
				if (($quote = ludos_paradise_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					ludos_paradise_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 4)!='[vc_') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($ludos_paradise_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($ludos_paradise_components))
				ludos_paradise_show_post_meta(apply_filters('ludos_paradise_filter_post_meta_args', array(
					'components' => $ludos_paradise_components,
					'counters' => $ludos_paradise_counters
					), $ludos_paradise_blog_style[0], $ludos_paradise_columns)
				);
		}
		// More button
		if ( $ludos_paradise_show_learn_more ) {
			?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'ludos-paradise'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>